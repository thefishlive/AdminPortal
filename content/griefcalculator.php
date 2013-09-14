<?php
class griefcalculator extends Page {
	
	protected $user;
	protected $blocks;
	
	function __construct() {
		$this->page = "griefcalculator";
		
		if (isset($_POST['user'])) {
			$this->user = $_POST['user'];
		}
		if (isset($_POST['blocks'])) {
			$this->blocks = $_POST['blocks'];
		}
	}
	
	function getContent() {
		return <<<PAGE
		<script type="text/javascript" src="./assets/js/griefcalculator.js"></script>
		
		<div class="row-fluid box shadow">	
			<div class="span 10 offset1">		
				Name: <input type="text" id="name" value="$this->user"/><br/>		
				Number of Blocks: <input type="text" id="noof-blocks" value="$this->blocks"/>		
				<input type="submit" value="Calculate" id="calculate"/>	
			</div>	
			
			<div class="span 10 offset1">	
			</div>
				
			<div id="output" class="span 10 offset1">	
			</div>
		</div>	
PAGE;
	}
	
	function canView($group) {
		return isUserStaff($group);
	}
}
