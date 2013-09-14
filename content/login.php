<?php
class login extends Page {

	protected $content;
	
	public function __construct() {
		$this->page = "login";
		$this->setup();
	}	
	
	public function setup() {	
		$this->content = <<<PAGE
			<script type="text/javascript" src="./assets/js/login.js"></script>
			<div class="row-fluid shadow box center">\n
				<div class="span8 offset2">\n
					<input id="username" type="text" placeholder="Username" /><br />
					<input id="password" type="password" placeholder="Password" /><br />
					<input id="submit" type="submit" value="Login" /><br />
				</div>\n
			</div>
PAGE;
	}
	
	function getContent() {
		if($this->loggedIn) {
			return <<<PAGE
				<script type="text/javascript">
					$().ready(function() {
						loadPage({page:'index'});
					});
				</script>
PAGE;
		}
		
		return $this->content;
	}
	
	function canView($group) {
		return true;
	}
}
?>