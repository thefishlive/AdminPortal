<?php
class playersearch extends Page {
	
	protected $user;
	
	public function __construct() {
		$this->page = "Player Search";
		
		if (isset($_POST['user'])) {
			$this->user = $_POST['user'];
		} else {
			$this->user = "Username";
		}
	}
	
	function getContent() {
		$content = <<<PAGE
		<script type="text/javascript" src="./assets/js/player-search.js"></script>
			
		<div class="row-fluid box shadow">
			<div class="span2"><p class="pull-right" style="padding-top:4px"><b>Username:</b></label></div>
			<div class="span8"><input type="text" id="player-name" value="$this->user" style="width: 100%; height:100%"/></div>
			<div class="span2"><input type="submit" id="player-submit" value="search"/></div>	
		</div>
		
		<div id="info-wrapper" class="row-fluid box shadow hide">
			<div class="span8 offset2" id="player-info"></div>
		</div>
		
		<div id="loading" class="center hide">
			<div class="progress progress-indeterminate center">
				<div class="win-ring"></div>
			</div>
		</div>

		
PAGE;
		
		if (isUserAdmin($this->mybb->user['usergroup'])) {
			$content .= <<<PAGE

			<div id="options-wrapper" class="row-fluid box shadow hide">		
				<div class="row-fluid">
					<div class="span10 offset1 center"><h3>Player Options</h3></div>
				</div>
				
				<br />
				<div class="row-fluid">
					<div class="span8 offset2"><input type="text" id="reason" value="reason" style="width: 100%; height:100%"/></div>
				</div>
				<div class="row-fluid">
					<div class="span2 offset2"><button class="btn btn-danger">Ban</button></div>
					<div class="span2 center"><button class="btn btn-warning pull-left">Temp Ban</button></div>
					<div class="span2"><button class="btn btn-info pull-right">Warn</button></div>
					<div class="span2"><button class="btn btn-success pull-right">UnBan</button></div>
				</div>
				<br />
			</div>
PAGE;
		}
		return $content;
	}
	
	function canView($group) {
		return isUserStaff($group);
	}
}

?>