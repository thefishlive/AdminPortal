<script language="JavaScript">
	setInterval( "getLatestChat();", 1000 );
	$(document).ready(function(){
		getLatestChat = function(){
			$.ajax({
				url: "admin/live-chat/get-chat.php",
				context: document.body,
				cache: true,
				success: function(html){
					$("#livechat-panel").html(html);
				}
			});
		}
		getLatestChat();
	});
</script>

<div id="livechat-panel">
	Loading...
</div>