<?php

	require_once 'global.php';
	error_reporting(0);
	
    function formattime($time) {
        $days = floor($time / 86400);
        $hours = floor(($time - ($days*86400)) / 3600);
        $mins = floor(($time - ($hours*3600) - ($days*86400)) / 60);

        return $days . " day" . ($days == 1 ? "" : "s") . " " . $hours . " hour" . ($hours == 1 ? "" : "s") . " " . $mins . " min" . ($mins == 1 ? "" : "s") . " ";
    }
    
	if (isset($_POST['name'])) {
        $name = $_POST['name'];
    } elseif (isset($_GET['name'])) {
        $name = $_GET['name'];
    } else {
		die("ERROR: No name sent with post request"); 
    }
	
	// connect to the database
	$serverDBC = Database::openMysqlConnection();

	// connect to the database
	//$webDBC = mysql_connect("localhost", "n3wton_vote", "B4dger1989");
	//mysql_select_db("n3wton_vote", $webDBC);
	
	/* Player basic infomation */
	$query = "SELECT * FROM permissions_inheritance WHERE child LIKE '$name' AND type='1';";
	$r = mysql_query($query, $serverDBC);
	$results = mysql_num_rows($r);
	
	if ($results == 0) {
		die("ERROR: This player does not have a permissions entry on the server");
	} elseif ($results > 1) {
		echo "<b> $name has more than one entry in the database</b><br />";
	}
	
	// there should only be one responce
	$row = mysql_fetch_assoc($r);
	$group = ucfirst($row['parent']);
	$caseName = $row['child'];
	
	/* Player basic infomation */
	$query = "SELECT * FROM `lb-players` WHERE playername LIKE '$name';";
	$r = mysql_query($query, $serverDBC);
	
	if (!$r) {
		echo mysql_error();
	}

	$results = mysql_num_rows($r);
	
	if ($results == 0) {
		die("ERROR: This player does not have a logblock entry on the server");
	} elseif ($results > 1) {
		echo "<b> $name has more than one entry in the database</b><br />";
	}
	
	// there should only be one responce
	$row = mysql_fetch_assoc($r);
	$ip = substr($row['ip'], 1, strpos($row['ip'], ":") - 1);
	$first = $row['firstlogin'];
	$last = $row['lastlogin'];
	$time = formatTime($row['onlinetime']);
    // TODO add user's skin, would look super cool
    ?>
<div class="row-fluid">
	<div class="span10 offset1 center"><h3>Player Info</h3></div>
</div>

<div class="row-fluid">
	<div class="row-fluid">
		<div class="span4 offset2"><b> Player: </b></div><div class="span6"><?php echo $caseName ?></div>
	</div>
	<div class="row-fluid">
		<div class="span4 offset2"><b> Rank: </b></div><div class="span6"><?php echo $group ?></div>
	</div>
	<div class="row-fluid">
		<div class="span4 offset2"><b> First Logged In: </b></div><div class="span6"><?php echo $first ?></div>
	</div>
	<div class="row-fluid">
		<div class="span4 offset2"><b> Last Logged In: </b></div><div class="span6"><?php echo $last ?></div>
	</div>
	<div class="row-fluid">
		<div class="span4 offset2"><b> Last Known Ip: </b></div><div class="span6"><?php echo $ip ?></div>
	</div>
	<div class="row-fluid">
		<div class="span4 offset2"><b> Has been online for: </b></div><div class="span6"><?php echo $time ?></div>
	</div>
</div>
	<?php
	/* FigAdmin information */
	// get all warnings the user has
	$query = "SELECT * FROM figadmin WHERE name LIKE '" . $name . "' AND type='2';";
	$r = mysql_query($query, $serverDBC);
	
    if (!$r) {
        if (error_reporting() > 0) die("ERROR: " . mysql_error());
    }
    $warnings = mysql_num_rows($r);
	echo "<br />";

	echo "<div class=\"row-fluid\">";
	echo "<div class=\"span10 offset1 center\"><b>$caseName has " . $warnings . " warning" . ($warnings == 1 ? "" : "s") . "</b></div>";
	
	// if the player has warnings display them to the admin
	if ($warnings > 0) {
		$id = 1;
		
		while($row = mysql_fetch_assoc($r)){ 
			echo "<div class=\"span10 offset2\"><b> Warning " . $id . ": </b><br/>";
			echo "&emsp;<b> Reason: </b>" .  $row['reason'] . "<br />";
			echo "&emsp;<b> Staff Member: </b>" .  $row['admin'] . "<br />";
			echo "&emsp;<b> Time: </b>" . date("F j, Y, g:i a", $row['time']) . "<br /></div>";
			$id++;
		}
	}
	echo "</div>";
	
	// get if the user is banned
	$query = "SELECT * FROM figadmin WHERE name LIKE '" . $name . "' AND (type='0' OR type='1');";
	$r = mysql_query($query, $serverDBC);
	
    if (!$r) {
        if (error_reporting() > 0) die("ERROR: " . mysql_error());
    }
    
	$results = mysql_num_rows($r);
	$row = mysql_fetch_assoc($r);
	
	echo "<br />";
		
	echo "<div class=\"row-fluid\">";
	// if no results we can safely assume that they are not banned
	$banned = $results > 0;
	
	echo "<div class=\"span10 offset1 center\"><b> $caseName is " . ($banned ? "" : "not") . " banned</b></div>";
	
	if ($banned) {
		echo "<div class=\"span10 offset2\">&emsp;<b> Reason: </b>" .  $row['reason'] . "<br />";
		echo "&emsp;<b> Staff Member: </b>" .  $row['admin'] . "<br />";
		echo "&emsp;<b> Time: </b>" . date("F j, Y, g:i a", $row['time']) . "<br /></div>";
	}
	echo "</div>";
	
	echo "<br />";
	
    $query = "SELECT * FROM jail_prisoners WHERE PlayerName LIKE '" . $name . "';";
    $r = mysql_query($query, $serverDBC);
    
    if (!$r) {
        if (error_reporting() > 0) die("ERROR: " . mysql_error());
    }
    
    $jailed = mysql_num_rows($r) >= 1;
    
	echo "<div class=\"row-fluid\">";
	echo "<div class=\"span10 offset1 center\"><b> $caseName is " . ($jailed ? "" : "not") . " jailed</b></div>";
    
    if ($jailed) {
        $row = mysql_fetch_assoc($r);   
		echo "<div class=\"span10 offset2\">&emsp;<b> Reason: </b>" .  $row['reason'] . "<br />";
		echo "&emsp;<b> Staff Member: </b>" .  $row['Jailer'] . "<br />";
		echo "&emsp;<b> Time Remaining: </b>" . $row['RemainTime'] . " minutes<br /></div>";  
    }
	echo "</div>";
	
    //echo "<br />";

	/*
    $query = "SELECT service, count(vote_id) AS amount FROM mcbadgercraft_votes WHERE username='$name' GROUP BY service";
    $r = mysql_query($query, $webDBC);
            
    if (!$r) {
        if (error_reporting() > 0) die("ERROR: " . mysql_error());
    } else {
        echo "<b>Vote Stats for $caseName</b><br/>";
        
        if (mysql_num_rows($r) == 0) {
            echo "$caseName has never voted";
        }
        
        while($row = mysql_fetch_assoc($r)) {
            echo "<b>" . $row['service'] . ": </b>" . $row['amount'] . "<br/>";
        }                
    }*/
	
	// close any connections
    mysql_close($serverDBC);
    //mysql_close($webDBC);
?>