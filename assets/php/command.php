<?php

	function isAllowedCommand($command) {
		switch(strtolower($command)) {
			case "ban":
			case "warn":
			case "jail":
			case "tempban":
			case "unban":
				return true;
			default:
				return false;
		}
	}

	// certain "special" staff members
	function isBlockedPlayer($player) {
		switch(strtolower($player)) {
			case "thefish97":
			case "n3wton":
			case "tilly_lala":
			case "tdc_hodgy":
			case "03ddruler":
			case "itstolate":
			case "darkace6141":
			case "alexendoo":
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

	if (!isset($_REQUEST['command'])) {
		die (json_encode(array("success" => false, "error" => "not enough information given")));
	}

	define('IN_ADMIN', TRUE);
	define('IN_MYBB', TRUE);
	global $mybb, $lang, $query, $db, $cache, $plugins, $lang, $config, $displaygroupfields;

	require_once("bSocks.php");
	require_once("global.php");
	Utils::include_file(FORUM, "global.php");

	$groupId = $mybb->user['usergroup'];
	$sender = $mybb->user['username'];
	$command = $_REQUEST['command'];

	if (!isUserMod($groupId)) {
		die (json_encode(array("success" => false, "error" => "not enough permissions")));
	}

	$command_parts = explode(' ', $command);

	var_dump($command_parts);
	if (!isAllowedCommand(substr($command_parts[0], 0, strpos($command, ' ')))) {
		die (json_encode(array("success" => false, "error" => "that command is not allowed to be executed from the web")));
	}

	if (!isAllowedCommand(substr($command_parts[1], 0, strpos($command, ' ')))) {
		die (json_encode(array("success" => false, "error" => $command_parts[1] . " cannot be " . $command_parts[0] . "ed")));
	}

	$bsocks = new bSocks(Config::getSVHost(), Config::getSVPort(), Config::getSVPass());
	$bsocks->executeCommand($sender, $command);

	die (json_encode(array("success" => true, "sender" => $sender, "command" => $command)));
?>