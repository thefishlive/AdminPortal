$().ready(function() {
	$("#submit").click(function() {
		var username = $("#username").val();
		var password = $("#password").val();
		
		if (username == "" || password == "") {
			displayAlert("You must provide a " + (username == null ? "username" : "password"));
			console.log(username + " " + password);
			return;
		}
		
		var data = {username: username, password: password};
		$.ajax({
			type: "POST",
			data: data,
			url: "./assets/php/login.php",
			context: document.body,
			cache: false,
			success: function(responce) {
				if (responce.indexOf("ERROR:") != -1) {
					displayAlert(responce.replace("ERROR: ", ""));
					return;
				}
				
				var json = JSON.parse(responce);
				
				if (json['success']) {
					var caseCorrect = json['username'];
					displayMessage("Login successful", "Welcome " + caseCorrect);
					loadPage({page: "index"});
					refreshUsername(caseCorrect);
				} else {
					displayAlert("Sorry we could not log you in because " + json['error'] + ".");				
				}
			},
			error: function(status, error) {	
				displayAlert("Sorry a internal error occurred whilst trying to log in");
			}
		});
	});
});