<?php

class banlist extends Page {
	
	function __construct() {
		$this->page = "bugs";
	}
	
	function getContent() {
		$start = "<div id=\"ban-list-panel\">";
		$end = "</div>";
		
		$dbc = Database::openMysqlConnection();
	
		$query = "SELECT * FROM figadmin WHERE type='0' ORDER BY name";
		$r = mysql_query($query, $dbc);
			
		$bans = "<div class=\"row-fluid box shadow ban-list\">";
		while($row = mysql_fetch_assoc($r)) {
			$bans .= "<div class=\"row-fluid\">";
			$bans .= "<div class=\"span3 offset3\"><p class=\"center\">" . $row['name'] . "</p></div><div class=\"span3\"><p class=\"center\">" . $row['admin'] . "</p></div>\n";
			$bans .= "</div>";
		}
		$bans .= "</div>";
			
		echo "\n";
		
		mysql_close($dbc);
		return $start . $bans . $end;
	}
	
	function canView($group) {
		return isUserStaff($group);
	}
}
?>