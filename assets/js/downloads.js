$().ready(function() {
	deleteFile = function(curdir, file) {
		$.ajax({
			type: "POST",
			data: {
				dir: curdir,
				file: file,
				option: "delete"
			},
			url: "./assets/php/downloads.php",
			context: document.body,
			cache: false,
			success: function(html) {
				if (html.contains("ERROR:")) {
					displayAlert(html.replace("ERROR: ", ""));
					return;
				}
				
				displayMessage("Success", "Successfully deleted file " + file);
				loadPage({page:"downloads", dir: dir});
			},
			error: function(status, error) {	
				displayAlert("Could not delete file (" + file + ")");
			}
		});
	}
	
	openFolder = function(dir) {
		loadPage({page: "downloads", dir: dir});
	}
});