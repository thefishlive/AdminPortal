<?php
	require_once 'global.php';
	$con = Database::openMysqlConnection();
	$from = strtotime($_POST['timeFrom']);
	$to = strtotime($_POST['timeTo']);
	$noof = 0;
	
	echo $_POST['timeFrom'] . " " . $_POST['timeTo'] . "<br />";
	echo $from . " " . $to;
	
	$all_chat = mysql_query("SELECT * FROM `lb-chat` WHERE `date` >= '$from' AND `date` <= '$to' LIMIT 0, 100");

	while($chatmessage = mysql_fetch_array($all_chat))
	{
		$playerdata = mysql_query("SELECT * FROM `lb-players` WHERE `playerid`=" . $chatmessage['playerid'] . " LIMIT 0, 1");
		$player = mysql_fetch_array($playerdata);	
		if ($chatmessage['playerid'] === '7') {			continue;				}
		//if (strpos($chatmessage['message'], '/', 0) === 0)
		//	continue;
		echo "<b>" . $player['playername'] . "</b> " . $chatmessage['message'] . "<br/>";
		$noof++;
	}	

	if ($noof == 0) {		echo "No logs from the given time period ($from -> $to)";			}
	
	mysql_close($con);
?>