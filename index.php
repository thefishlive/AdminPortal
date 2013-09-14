<?php 
error_reporting(E_ALL);

if (isset($_GET['page'])) {
	$page = $_GET['page'];
} else {
	$page = "index";
}

define('IN_ADMIN', true);
define('IN_MYBB', true);
global $mybb, $lang, $query, $db, $cache, $plugins, $lang, $config, $displaygroupfields;
require_once("../forum/global.php");

if ($mybb->user['uid']) {
	$username = $mybb->user['username'];
} else {
	$page = "login";
}
?>
<!DOCTYPE html>
<html lang="en">
<head> 
	<!-- Mobile support -->
	<meta name="viewport" content="width=device-width, height=device-height, initial-scale=1.0">
	<link rel="stylesheet" type="text/ccs" href="./assets/css/bootstrap-responsive.css">
	
	<!-- Stylesheets -->
	<link rel="stylesheet" type="text/css" href="./assets/css/bootmetro.css">
	<link rel="stylesheet" type="text/css" href="./assets/css/bootmetro-responsive.css">
	<link rel="stylesheet" type="text/css" href="./assets/css/bootmetro-icons.css">
	<link rel="stylesheet" type="text/css" href="./assets/css/bootmetro-ui-light.css">
	<link rel="stylesheet" type="text/css" href="./assets/css/datepicker.css">
	<link rel="stylesheet" type="text/css" href="./assets/css/admin.css">
	
	<!-- Modernizr script -->
	<script src="./assets/js/min/modernizr-2.6.2.min.js"></script>
	
	<!-- Site title -->
	<title>McBadgerCraft - Admin Portal</title>
	
	<!-- favicon -->
	<link rel="icon" type="image/vnd.microsoft.icon" href="http://mcbadgercraft.com/store/img/favicon.ico?1336909396" />
	<link rel="shortcut icon" type="image/x-icon" href="http://mcbadgercraft.com/store/img/favicon.ico?1336909396" />
</head>

<body>
	<div id="wrap">
		<!--[if lt IE 7]>
		<p class="chromeframe">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> or <a href="http://www.google.com/chromeframe/?redirect=true">activate Google Chrome Frame</a> to improve your experience.</p>
		<![endif]-->
		
		<div id="alerts-container">
		</div>
		
		<div class="navbar navbar-fixed-top shadow">
			<div class="navbar-inner">
				<a class="brand pointer" onClick="loadPage({page:'index'})"><img src="http://mcbadgercraft.com/store/img/favicon.ico?1336909396"/>McBadgerCraft Admin</a>
				<ul class="nav" style="padding-top: 5px;">
					<li id="modpack" class="nav-item"><a onClick="loadPage({page:'modpack'})">Mod Pack</a></li>
					<!--<li id="downloads" class="nav-item"><a onClick="loadPage({page:'downloads'})">Downloads</a></li>-->
					<li id="player-search" class="nav-item"><a onClick="loadPage({page:'playersearch'})">Player Search</a></li>
					<li id="grief-calculator" class="nav-item"><a onClick="loadPage({page:'griefcalculator'})">Grief Calculator</a></li>
					<li id="chat-logs" class="nav-item"><a onClick="loadPage({page:'chatlogs'})">Chat Logs</a></li>
					<li id="ban-list" class="nav-item"><a onClick="loadPage({page:'banlist'})">Ban List</a></li>
					<li id="bugs" class="nav-item"><a onClick="loadPage({page:'bugs'})">Bugs</a></li>
				</ul>
				<div class="pull-right username">				
					<p><a id="create-permlink"><i class="icon-copy-2 pointer"></i></a>&nbsp;<i class="icon-reload reload" onclick="reloadPage()"></i>&nbsp;<i class="icon-user"></i>&nbsp;<font id="username"><?php echo $username?></font></p>
				</div>
			</div>
		</div>
		
		<div id="sidebar-left" class="row-fluid box shadow">
			<div id="server-status" class="span12">	
				<!-- Server status -->		
			</div>
		</div>

		<!--<div id="sidebar-right" class="row-fluid box shadow">
			<div id="server-right" class="span12">	
			</div>
		</div>-->	

		<div id="content">
			<!-- Page Content -->
		</div>
	</div>
		
	<!-- scripts to load -->
	<script type="text/javascript" src="./assets/js/min/jquery-1.10.0.min.js"></script>
	<script type="text/javascript" src="./assets/js/jquery.zclip.js"></script>
		
	<!--[if IE 7]>
	<script type="text/javascript" src="scripts/bootmetro-icons-ie7.js">
	<![endif]-->

	<script type="text/javascript" src="./assets/js/min/bootstrap.min.js"></script>
	<script type="text/javascript" src="./assets/js/bootmetro-panorama.js"></script>
	<script type="text/javascript" src="./assets/js/bootmetro-pivot.js"></script>
	<script type="text/javascript" src="./assets/js/bootmetro-charms.js"></script>
	<script type="text/javascript" src="./assets/js/bootstrap-datepicker.js"></script>

	<script type="text/javascript" src="./assets/js/admin.js"></script>
	
	<script type="text/javascript">
		$(document).ready(function(){
			<?php
			if (isset($page)) {
				$data = "{page:'$page'";
				
				foreach (array_merge($_GET, $_POST) as $key => $value) {
					$data .= ",$key:'$value'";
				}
				
				$data .= "}";
				echo "loadPage($data);\n";
			}
			?>
		});
	</script>
</body>

</html>