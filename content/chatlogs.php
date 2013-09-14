<?php
class chatlogs extends Page {

	function __construct() {
		$this->page = "Chat Logs";
	}		
	
	function getContent() {
		return <<<PAGE
			<script language="text/javascript" src="./assets/js/chatlogs.js"></script>

			<div id="chatlog-panel" class="row-fluid box shadow">
				<div class="span10 offset1 center">
					<p>
						From					
						<input type="text" id="time-from" size="20" value="" style="margin-top:6px;"/>
						To					
						<input type="text" id="time-to" size="20" value="" style="margin-top:6px;"/>
						<button class="btn btn-primary" id="search-chat">Search</button>
					</p>				
				</div>			
			</div>			
			
			<div id="loading" class="hide center">
				<div class="progress progress-indeterminate center">
					<div class="win-ring"></div>
				</div>
			</div>

			<div id="chatlog-wrapper" class="row-fluid box shadow hide">
				<div id="chatlog-output" class="span10 offset1"></div>
			</div>
PAGE;
	}		
	
	function canView($user) {
		return isUserStaff($user);	
	}
}
?>