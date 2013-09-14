var alert = "<div id=\"alert\" class=\"toast toasttext01 fade in\">" +
				"<button type=\"button\" class=\"close\" data-dismiss=\"alert\"></button>" +
				"<div class=\"pull-left\">" +
					"<img class=\"toast-object\" src=\"./assets/img/favicon.png\">" +
				"</div>" +
				"<div id=\"alert-body\" class=\"toast-body\">" +
					"<h4 class=\"toast-heading\"><b>%TITLE%</b></h4>" +
					"<p>%MESSAGE%</p>" +
				"</div>" +
			"</div>";

var loading = "<div class=\"progress progress-indeterminate center\">" +
				"<div class=\"win-ring\"></div>"
			"</div>";

var active = "index";

$(document).ready(function(){

	loadPage = function(data){
		if (data['page'] == null) {
			displayAlert("No page defined for loading");
			return;
		}
		
		$("#" + active).removeClass("active");
		//$("#" + data['page']).addClass("active");
		active = data['page'];
	
		$("#content").html(loading);
		
		$.ajax({
			type: "POST",
			data: data,
			url: "./assets/php/page.php",
			context: document.body,
			cache: false,
			success: function(html) {
				if (html.indexOf("ERROR:") != -1) {
					displayAlert(html.replace("ERROR: ", ""));
					$("#content").html("");
					return;
				}
				
				$("#content").html(html);
			},
			error: function(status, error) {	
				$("#content").html("");		
				console.log(status + " " + error);
				displayAlert("Could not load page (" + data['page'] + ")");
			}
		});
	}
	
	playerInfo = function(playerName) {
		loadPage({page:'playersearch', user: playerName});
	}
	
	$('a#create-permlink').zclip({
		path:'./assets/swf/ZeroClipboard.swf',
		copy: function(){
			displayMessage("Success", "Copied link to your clipboard");
			return "http://mcbadgercraft.com/portal/?page=" + active;
		}
	});
	
	displayAlert = function(error) {
		displayMessage("An error has occurred", error);
	}
	
	displayMessage = function(title, message) {
		console.log(title);
		console.log(message);
		$("#alerts-container").append(alert.replace("%MESSAGE%", message).replace("%TITLE%", title));
	}
	
	reloadPage = function() {
		loadPage({page:active});
	}
	
	ServerStatusRefresh = function(){
		$.ajax({
			type: "POST",
			url: "./assets/php/status.php",
			context: document.body,
			cache: true,
			success: function(html) {
				$("#server-status").html(html);
			},
			fail: function() {
				displayAlert("Could not update server status");
			}
		});
	}
	
    $('table tr').click(function(){
        window.location = $(this).attr('href');
        return false;
    });

	ServerStatusRefresh();
	setInterval("ServerStatusRefresh();", 10000);

	updateUsername = function(username) {
		$("#username").html(username);
	}
});	