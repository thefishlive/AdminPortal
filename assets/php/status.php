<?php
					define("IN_ADMIN", NULL);
					require_once("global.php");
					Utils::include_file(ASSETS, "bSocks.php");

					$bSocks = new bSocks(Config::getSVHost(), Config::getSVPort(), Config::getSVPassword());
					$bSocks->requestServerStats();
					$rawMessage = $bSocks->receiveMessage(4096);
					$serverStats = json_decode($rawMessage);
					
					if ($serverStats != "") {
						$maxPlayers = $serverStats->{'max-players'};
						$noofPlayers = count($serverStats->{'online-players'});
						
						echo "<table width='100%' border='0'><tr>";
								echo "<td align='center'><img width='24' height='24' src='./assets/img/status/online.png' /></td>";
								echo "<td align='center'><b>Server is Online</b></td>";
								echo "
							</tr>
							<tr>
								";
								echo "<td align='center'>Players Online</td>" . "<td align='center'><b>" . $noofPlayers . "/" .$maxPlayers . "</b></td>";
								echo "
							</tr>
						</table>";
					}
					?>
					<p></p>
					
					<div style="height:650px;overflow:auto;">
					<?php
					$players = $serverStats->{'online-players'};
					
					$noofPlayers = count($players);
					
					$ranks = array("prisoner", "convict", "cub", "badger", "bigbadger", "devoted", "artisan", "technician", "honoured",  "legend", "investor", "helper", "moderator", "admin", "dev", "founder");
					$noofRanks = count($ranks);
					$baseImageLocation = "https://minotar.net/helm";
					$suffixImageLocation = "16.png";
					
					$hasPlayers = false;
					for ($rankIndex = $noofRanks - 1; $rankIndex >= 0; $rankIndex--)
					{
						$hasHeader = false;
						for ($i = 0; $i < $noofPlayers; $i++) {
						
							$playerName = $players[$i]->{'player-name'};
							$playerRank = strtolower($players[$i]->{'rank-name'}[0]->{'group'});
							
							if (strcmp($playerRank, $ranks[$rankIndex]) == 0)
							{
								
								$hasPlayers = true;
								$imageLocation = $baseImageLocation . $playerName . $suffixImageLocation;
							
								if ($hasHeader == false)
								{
									echo "<div class=\"row-fluid\">";
									echo "<div class=\"span10 offset1\"><b>" . ucfirst($playerRank) . "</b></div>";	
									
									$hasHeader = true;
									$isFirstGroup = false;
								}
								
								echo "<div class=\"span10 offset1 pointer\" onclick=\"playerInfo('$playerName')\" title=\"View player info for $playerName\"><img class=\"shadow\" src=\"$baseImageLocation/$playerName/$suffixImageLocation\"/>&nbsp;&nbsp;" . $playerName . "</div>";				
							}	
						}
						if ($hasPlayers) {
							echo "</div>";	
							$hasPlayers = false;
						}
					}
					echo "</div>";

?>