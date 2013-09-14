<?php
define('IN_MYBB', NULL);

global $mybb, $lang, $query, $db, $cache, $plugins, $lang, $config, $displaygroupfields;

require_once("../../../forum/global.php");
require_once("../../../forum/inc/functions_user.php");
require_once("./MyBBIntegrator.php");

$MyBBI = new MyBBIntegrator($mybb, $db, $cache, $plugins, $lang, $config);

$username = $_REQUEST['username'];
$password = $_REQUEST['password'];

$correct = false;

// Checks to make sure the user can login; they haven't had too many tries at logging in.
// Is a fatal call if user has had too many tries
$logins = login_attempt_check();
$login_text = '';

if(!username_exists($username)) {
	my_setcookie('loginattempts', $logins + 1);
	die (json_encode(array("success" => false, "error" => "that username does not exist")));
}

$query = $db->simple_select("users", "loginattempts", "LOWER(username)='".$db->escape_string(my_strtolower($mybb->input['username']))."' OR LOWER(email)='".$db->escape_string(my_strtolower($mybb->input['username']))."'", array('limit' => 1));
$loginattempts = $db->fetch_field($query, "loginattempts");

// Don't check password when captcha isn't solved
if(empty($errors)) {
	$user = validate_password_from_username($username, $password);
	
	// Login failed
	if(!$user['uid']) {
		my_setcookie('loginattempts', $logins + 1);
		$db->update_query("users", array('loginattempts' => 'loginattempts+1'), "LOWER(username) = '".$db->escape_string(my_strtolower($mybb->input['username']))."'", 1, true);

		die (json_encode(array("success" => false, "error" => "Your password is incorrect")));
	}
}

my_setcookie('loginattempts', 1);
$db->delete_query("sessions", "ip='".$db->escape_string($session->ipaddress)."' AND sid != '".$session->sid."'");
$newsession = array(
	"uid" => $user['uid'],
);

$db->update_query("sessions", $newsession, "sid='".$session->sid."'");
$db->update_query("users", array("loginattempts" => 1), "uid='{$user['uid']}'");
my_setcookie("mybbuser", $user['uid']."_".$user['loginkey'], null, true);
my_setcookie("sid", $session->sid, -1, true);

die (json_encode(array("success" => true, "username" => $username)));
?>