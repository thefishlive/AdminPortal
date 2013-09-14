<?php
class index extends Page {

	protected $content;
	
	public function __construct() {
		$this->page = "index";
		$this->setup();
	}	
	
	public function setup() {	
		$this->content = <<<PAGE
			<script src="./assets/js/index.js"></script>
			<div class="row-fluid center">
				<div class="span6 offset3 metro">
                    <a id="mod-pack-tile" class="tile squarepeek bg-color-grayLight" href="#">
                    	<img alt="150x150" src="./assets/img/tiles/player.png" style="width: 150px; height: 300px;"></img>
                        <div class="text-inner"">
                        	<div class="text4">
					        	<b>Mod Pack</b>
					        </div>
					        <br/>
                        	<div class="text4">
					        	Get the staff mod pack installer
					        </div>
					    </div>
					</a>

                    <a id="player-search-tile" class="tile squarepeek bg-color-grayLight" href="#">
                    	<img alt="150x150" src="./assets/img/tiles/player.png" style="width: 150px; height: 300px;"></img>
                        <div class="text-inner"">
                        	<div class="text4">
					        	<b>Player Search</b>
					        </div>
					        <br/>
                        	<div class="text4">
					        	Get all relevant information about a player
					        </div>
					    </div>
					</a>

					<a id="gief-calcuator-tile" class="tile squarepeek bg-color-grayLight" href="#">
                    	<img alt="150x150" src="./assets/img/tiles/player.png" style="width: 150px; height: 300px;"></img>
                        <div class="text-inner"">
                        	<div class="text4">
					        	<b>Grief Calculator</b>
					        </div>
					        <br/>
                        	<div class="text4">
					        	View the grief calculator
					        </div>
					    </div>
					</a>

					<a id="chat-logs-tile" class="tile squarepeek bg-color-grayLight" href="#">
                    	<img alt="150x150" src="./assets/img/tiles/player.png" style="width: 150px; height: 300px;"></img>
                        <div class="text-inner"">
                        	<div class="text4">
					        	<b>Chat Logs</b>
					        </div>
					        <br/>
                        	<div class="text4">
					        	View the chat logs
					        </div>
					    </div>
					</a>

					<a id="ban-list-tile" class="tile squarepeek bg-color-grayLight" href="#">
                    	<img alt="150x150" src="./assets/img/tiles/player.png" style="width: 150px; height: 300px;"></img>
                        <div class="text-inner"">
                        	<div class="text4">
					        	<b>Ban list</b>
					        </div>
					        <br/>
                        	<div class="text4">
					        	View the latest ban list
					        </div>
					    </div>
					</a>

					<a id="bugs-tile" class="tile squarepeek bg-color-grayLight" href="#">
                    	<img alt="150x150" src="./assets/img/tiles/player.png" style="width: 150px; height: 300px;"></img>
                        <div class="text-inner"">
                        	<div class="text4">
					        	<b>Bugs</b>
					        </div>
					        <br/>
                        	<div class="text4">
					        	View the bug list
					        </div>
					    </div>
					</a>
				</div>
			</div>
PAGE;
	}
	
	function getContent() {
		return $this->content;
	}
	
	function canView($group) {
		return true;
	}
}
?>