$(document).ready(function() {

	var lastPlayer = "";
	$("#info-wrapper").hide();
	$("#options-wrapper").hide();
	$("#loading").hide();
	
	$("#player-name").click(function() {		
		if ($("#player-name").val() == "username") {
			$("#player-name").val("");
		}
	});

	$("#reason").click(function() {		
		if ($("#reason").val() == "reason") {
			$("#reason").val("");
		}
	});

	getInfo = function() {
		var playerName = $("#player-name").val();
		
		if (playerName == "" || playerName == "Username") {
			return;
		} else if (lastPlayer == playerName ) {
			return;
		}
		
		displayInfo(playerName);
	}
	
	$("#player-submit").click(getInfo);
	
	displayInfo = function(player) {		
		$("#info-wrapper").slideUp();	
		$("#options-wrapper").slideUp();
		$("#loading").show();
			
		lastPlayer = player;
			
		$.post("./assets/php/get-player.php", { name: player },
			function(data) {
				if (data.indexOf("ERROR") != -1) {
					displayAlert(data.replace("ERROR: ", ""));
					$("#loading").hide();
					return;
				}
					
				$("#player-info").html(data);
				$("#loading").hide();
				$("#info-wrapper").slideDown();
				$("#options-wrapper").slideDown();
			}
		);
	}
	
	getInfo();
});