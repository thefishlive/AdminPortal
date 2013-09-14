<?php
class modpack extends Page {
	
	protected $downloadUrl;
	
	public function __construct() {
		$this->downloadUrl = "http://mcbadgercraft.com/adminpack/installer/";
	}
	
	function getContent() {
		return <<<PAGE
		<div id="modpack" class="row-fluid box shadow">
			<div class="span10 offset1">
				<p>
					<h3>Staff Modpack</h3>
					<br />
				
					<b>Download:</b><br/>
					<p>
						&emsp;&emsp;<a href="$this->downloadUrl">Mod Pack Installer</a><br />\n
					</p>
					
					<b>Mods:</b><br/>
					<p>
						<ul>
							<li><a href="http://www.minecraftforum.net/topic/514000-api-minecraft-forge/">Forge</a></li>
							<li><a href="http://www.minecraftforum.net/topic/249637-132-optifine-hd-b3-fps-boost-hd-textures-aa-af-and-much-more/">OptiFine</a></li>
							<li><a href="http://www.minecraftforum.net/topic/467504-132-macro-keybind-mod-093-and-liteloader-for-132/">LiteLoader</a></li>
							<li><a href="http://www.minecraftforum.net/topic/1432205-132-bupload-upload-screenshots-straight-to-imgurcom/">bUpload</a></li>
							<li><a href="http://www.minecraftforum.net/topic/1720872-15x-inventory-tweaks-154-may-1/">Inventory Tweaks</a></li>
							<li><a href="http://www.minecraftforum.net/topic/467504-132-macro-keybind-mod-093-and-liteloader-for-132/">Macro / Keybind mod</a></li>
							<li><a href="http://www.minecraftforum.net/topic/909223-125142-smp-chickenbones-mods/">Not Enough Items</a></li>
							<li><a href="http://www.minecraftforum.net/topic/1540451-145-tabbychat-v143-chat-tabs-and-more-for-multiplayer-custom-chat-filters-chat-logging-highlighting/">TabbyChat</a></li>
							<li><a href="http://www.minecraftforum.net/topic/885099-mc-132-we-54-worldeditcui-gui-visualizer-for-worldedit-v132a/">WorldEdit CUI (litemod edition)</a></li>
							<li><a href="http://www.planetminecraft.com/mod/zans-minimap/">Zan's Minimap</a></li>
						</ul>
					</p>
				</p>
			</div>		
		</div>
PAGE;
	}
	
	function canView($group) {
		return isUserStaff($group);
	}
}
?>