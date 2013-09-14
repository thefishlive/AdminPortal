var commands = [];

var commandBtn = "</div>" +
				"<div class=\"row-fluid\">" + 
					"<div class=\"span10 center\">" +
						"<button class=\"btn\" id=\"execute-commands\">Execute Commands</button>";
					"</div>";					
				"</div>";

$(document).ready(function() {

	calculateGrief = function() {
		name = $("#name").val();
		noofblocks = $("#noof-blocks").val();
		
		if (name == "" || noofblocks == "") {
			return;
		} else if (isNaN(noofblocks)) {
			displayAlert("The amount of blocks must be a number");
			return;	
		}
		
		jailtime = Math.floor(5 + ((noofblocks - 1) * 0.5));
		requiresWarning = false;
		requiresTempBan = false;
		requiresPermBan = false;
		
		if (jailtime > 45) {
			requiresWarning = true;

			if (jailtime > 120) {
				requiresTempBan = true;

				if (jailtime > 240) {
					requiresPermBan = true;
				}
			}
			jailtime = 45;
		}

		output = $("#output");
		output.empty();
		i = 0;

		if (!requiresTempBan && !requiresPermBan) {
			output.append("<b>Jail Time: " + jailtime + " minutes</b><br/><i>/jail " + name + " " + jailtime + " Griefing " + noofblocks + " " + (noofblocks == 1 ? "block" : "blocks") + "<br/>");
			commands[i] = "jail " + name + " " + jailtime + " Griefing " + noofblocks + " " + (noofblocks == 1 ? "block" : "blocks");
			i++;
		}

		if (!requiresWarning) {
			output.append("<b>No warning is required.</b>");
		} else {
			if (!requiresTempBan && !requiresPermBan) {
				output.append("<b>Warning Required.</b><br/><i>/warn " + name + " Griefing " + noofblocks + " blocks</i>");
				commands[i] = "warn " + name + " Griefing " + noofblocks + " " + (noofblocks == 1 ? "block" : "blocks");
				i++;
			}

			if (requiresTempBan && !requiresPermBan) {
				time = Math.floor(24 * (noofblocks / 233));
				output.append("<b>Temp Ban Required.</b><br/><i>/tempban " + name + " " + time + " hour " + " Griefing " + noofblocks + " blocks</i>");
				commands[i] = "tempban " + name + " " + jailtime + " " + time + " hour " + " Griefing " + noofblocks + " " + (noofblocks == 1 ? "block" : "blocks");
				i++;
			}

			if (requiresTempBan && requiresPermBan) {
				output.append("<b>Perm Ban Required.</b><br/><i>/ban " + name + " Griefing " + noofblocks + " blocks</i>");
				commands[i] = "ban " + name + " Griefing " + noofblocks + " " + (noofblocks == 1 ? "block" : "blocks");
				i++;

				if (noofblocks >= 1000) {
					output.append("<br><b>What a Cunt...</b>");
				}
			}
		}
		
		output.append(commandBtn);
	};
	
	$("#calculate").click(calculateGrief);
	
	calculateGrief();
	
	$("#execute-commands").click(function() {
		
		if (commands.length == 0) {
			displayAlert("No commands to be executed");
			return;
		}
		
		executeCommands();
	});

	executeCommands = function() {
		console.log("executing " + commands.length + (commands.length == 1 ? " command" : " commands"));
		more = true;
		for (var i = 0; i < commands.length; i++) {
			console.log(commands[i]);
			if (i == commands.length - 1) {
				more = false;
			}
			finalcommand = !more;

			$.ajax({
				type : "POST",
				data : {
					command: commands[i]
				},
				url : "./assets/php/command.php",
				context : document.body,
				cache : false,
				success : function(html) {
					console.log(html);
					if (finalcommand) {
						displayMessage("Success", "Punishment has been given.");
					}
				},
				error: function (status, error){
					displayAlert("There was a error one of the commands");
				}
			});
		}
	}
});
