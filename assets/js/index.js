$().ready(function() {
	
	$("#mod-pack-tile").click(function() {
		loadPage({page:"modpack"});
	});

	$("#player-search-tile").click(function() {
		loadPage({page:"playersearch"});
	});

	$("#gief-calcuator-tile").click(function() {
		loadPage({page:"griefcalculator"});
	});

	$("#chat-list-tile").click(function() {
		loadPage({page:"chatlogs"});
	});

	$("#ban-list-tile").click(function() {
		loadPage({page:"banlist"});
	});

	$("#bugs-tile").click(function() {
		loadPage({page:"bugs"});
	});

});