<?php
Utils::include_file(ASSETS, 'youtrack/youtrackclient.php');

class bugs extends Page {
	
	private $youtrack;
	private $filter;

	function __construct() {
		$this->page = "bugs";
		$this->youtrack = new \YouTrack\Connection(Config::getYTHost(), Config::getYTUser(), Config::getYTPassword());
		$this->filter = "";
		if (isset($_POST['state'])) {
			$this->filter .= $this->convertStateToYoutrack($_POST['state']);
		}
		$this->filter .= " sort by: {issue id} ASC";
	}
	
	function convertStateToYoutrack($state) {
		switch($state) {
			case "In_Progress":
				return "#{In Progress}";
			case "Won't_fix":
				return "#{Won't Fix}";
			default:
				return "#" . $state;
		}
	}

	function convertStateToClass($state) {
		switch ($state) {
			case "Open":
				return "error";
			case "Fixed":
			case "Built":
				return "success";
			case "In Progress":
				return "warning";
			case "Can't Reproduce":
			case "Duplicate":
			case "Invalid":
			case "Won't Fix":
			default:
				return "info";
		}
	}

	function getContent() {
		$issues = $this->youtrack->get_issues($this->filter, array("id", "projectShortName", "summary", "description", "created", "state", "reporterName", "assignee"), 1000);
		
		$content = "<div class=\"row-fluid box shadow ban-list\">";
		$content .= "<table class=\"bugs table table-striped\">";

		$content .= "<thead>";
			$content .= "<tr>";
			$content .= "<td><b>Id</b></td>";
			$content .= "<td><b>Summary</b></td>";
			$content .= "<td><b>State</b></td>";
			$content .= "<td><b>Reporter</b></td>";
			$content .= "<td><b>Assignee</b></td>";
			$content .= "</tr>";
		$content .= "</thead>";

		foreach ($issues as $issue) {
			$content .= "<tr title=\"" . $issue->__get('description') . "\" href=\"http://server.mcbadgercraft.com:88/issue/" . $issue->__get('id') . "\" class=\"" . $this->convertStateToClass($issue->__get("State")) . "\">";
			$content .= "<td><b>" . $issue->__get('id') . "</b></td>";
			$content .= "<td>" . $issue->__get('summary') . "</td>";
			$content .= "<td width=\"80px\">" . $issue->__get('State') . "</td>";
			$content .= "<td>" . $issue->__get('reporterName') . "</td>";
			$content .= "<td>" . $issue->__get('Assignee') . "</td>";
			$content .= "</tr>";
		}

		$content .= "</table>";
		$content .= "</div>";

		return $content;
	}

	function canView($groupId) {
		return isUserStaff($groupId);
	}
}
?>