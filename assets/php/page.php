<?php
function isUserStaff($groupId) {
	switch ($groupId) {
		case 11: // moderator
		case 6:  // moderator
		case 10: // admin
		case 18: // developer
		case 8:  // founder
		case 22: // helper
			return true;
		default:
			return false;
	}
}

function isUserAdmin($groupId) {
	switch ($groupId) {
		case 10: // admin
		case 18: // developer
		case 8:  // founder
			return true;
		default:
			return false;
	}
}

function isUserMod($groupId) {
	switch($groupId) {
		case 10: // admin
		case 18: // dev
		case 8:  // founder
		case 11: // moderator
		case 6:  // moderator
			return true;
		default:
			return false;
	}
}

define("DEBUG", true);

if (isset($_POST['page'])) {
	$pageName = strtolower($_POST['page']);	
} elseif (isset($_GET['page']) && DEBUG) {
	$pageName = strtolower($_GET['page']);	
} else {
	die ("ERROR: No page defined");
}
$filename = "../../content/" . $pageName . ".php";

if (!file_exists($filename)) {
	die ("ERROR: page does not exist ($pageName)");
}

define('IN_ADMIN', TRUE);
define('IN_MYBB', TRUE);
global $mybb, $lang, $query, $db, $cache, $plugins, $lang, $config, $displaygroupfields;

require_once("global.php");
require_once("../../../forum/global.php");
require_once $filename;

echo $mybb->mybb->user['usergroup'];

//Utils::include_file(CONTENT, $filename);

$page = new $pageName();

$page->init($mybb);
$page->displayPage();

abstract class Page {
	
	protected $page;
	protected $mybb;
	protected $loggedIn;
	
	public abstract function getContent();

	public abstract function canView($group);

	public function checkPermissions() {
		if (!defined("IN_ADMIN")) {
			return false;
		}
		return $this->canView($this->mybb->user['usergroup']);
	}
	
	public function init(&$mybb) {
		$this->mybb = $mybb;
		$this->loggedIn = $this->mybb->user['uid'] == true;
	}
	
	public function displayPage() {
		if (!$this->checkPermissions()) {
			echo <<<PAGE
				<script type="text/javascript">
					$().ready(function() {
						displayAlert("You do not have permission to view this page");
					});
				</script>
PAGE;
			return;
		}
		
		echo $this->getContent();
	}
}