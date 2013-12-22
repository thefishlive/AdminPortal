<?php

$debug = TRUE;
define ("FORUM", 1);
define ("ASSETS", 2);
define ("CONTENT", 3);

error_reporting($debug ? E_ALL : 0);

class Utils {

	private static $basedir = "../../";

	public static function include_file($location, $file) {
		$path = "";
		switch ($location) {
			case 1:
				$path .= self::$basedir . "../forum/";
				break;
			case 2:
				break;
			case 3:
				$path .= self::$basedir . "content/";
				break;
		}

		require_once $path . $file;
	}
}

class Config {

	protected static $filename = "../../config/config.php";
	protected static $loaded = false;
	protected static $json = NULL;

	public static function loadConfig() {
		if (self::$loaded) {
			return;
		}

		// Hacky way to get json
		ob_start();
		include(self::$filename);
		$raw = ob_get_clean();
		self::$json = json_decode($raw);
		self::$loaded = true;

		if (self::getVersion() != 1) {
			die("Error loading config(" + json_last_error() + ")");
		}
	}

	private static function getJsonError() {
		switch (json_last_error()) {
        case JSON_ERROR_NONE:
            echo ' - No errors';
        break;
        case JSON_ERROR_DEPTH:
            echo ' - Maximum stack depth exceeded';
        break;
        case JSON_ERROR_STATE_MISMATCH:
            echo ' - Underflow or the modes mismatch';
        break;
        case JSON_ERROR_CTRL_CHAR:
            echo ' - Unexpected control character found';
        break;
        case JSON_ERROR_SYNTAX:
            echo ' - Syntax error, malformed JSON';
        break;
        case JSON_ERROR_UTF8:
            echo ' - Malformed UTF-8 characters, possibly incorrectly encoded';
        break;
        default:
            echo ' - Unknown error';
        break;
    }
	}

	public static function getVersion() {
		self::loadConfig();
		return self::$json->{'version'};
	}

	public static function getDBHost() {
		self::loadConfig();
		return self::$json->{'databases'}->{'host'};
	}

	public static function getDBDatabase() {
		self::loadConfig();
		return self::$json->{'databases'}->{'database'};
	}

	public static function getDBUser() {
		self::loadConfig();
		return self::$json->{'databases'}->{'user'};
	}

	public static function getDBPassword() {
		self::loadConfig();
		return self::$json->{'databases'}->{'pass'};
	}

	public static function getSVHost() {
		self::loadConfig();
		return self::$json->{'server'}->{'host'};
	}

	public static function getSVPort() {
		self::loadConfig();
		return self::$json->{'server'}->{'port'};
	}

	public static function getSVPassword() {
		self::loadConfig();
		return self::$json->{'server'}->{'pass'};
	}

	public static function getYTHost() {
		self::loadConfig();
		return self::$json->{'youtrack'}->{'host'};
	}

	public static function getYTUser() {
		self::loadConfig();
		return self::$json->{'youtrack'}->{'user'};
	}

	public static function getYTPassword() {
		self::loadConfig();
		return self::$json->{'youtrack'}->{'pass'};
	}
}

class Database {

	public static function openMysqliConnection() {
		$link = mysqli_connect(Config::getDBHost(), Config::getDBUser(), Config::getDBPassword(), Config::getDBDatabase()) or die ("Error: Could not connect to database. (" . mysqli_error($link) . ")");
		return $link;
	}

	public static function openMysqlConnection() {
		$link = mysql_connect(Config::getDBHost(), Config::getDBUser(), Config::getDBPassword()) or die ("Error: Could not connect to database. (" . mysql_error($link) . ")");
		mysql_select_db(Config::getDBDatabase(), $link) or die ("Error: Could not select database. (" . mysql_error($link) . ")");
		return $link;
	}
}

class YoutrackHandler {

	public static function openYoutrackConnection() {
		$youtrack = new \YouTrack\Connection(Config::getYTHost(), Config::getYTUser(), Config::getYTPassword());
		return $youtrack;
	}
}
?>