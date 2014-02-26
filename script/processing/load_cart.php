<?php
session_start();
require_once('../classes/User.class.php');
require_once('../classes/Log.class.php');
require_once('../classes/Song.class.php');
require_once('../includes/utils.inc.php');
$user = User::getLoggedInUser();
if ($user != null) { 
	$log = $user->fetchCart();
	if ($log != null) {
		$logItems = $log->getLogItems();
		if (sizeof($logItems) > 0) {
			echo '	
					<div id="mycart_header"></div>
					<div id="mycart_shadow"></div>
					<div id="mycart_repeat">
						<div id="mycart_links">';
					
						foreach ($logItems as $item) {
							$song = $item->getSongObject();
							if ($song != null) {
								echo '<div class="mycart_item">
											<span class="mycart_item_link"><a class="link" onClick="show_record('.$song->getSongID().', \'page_catalogue_song.php\');">' . trim_text($song->getSongTitle(), 10) . '</a></span>
											<span class="mycart_item_removal"><a class="link" onclick="remove_cart_item('.$item->getItemID().');">[Remove]</a></span>
								</div>';
							}
							
						}
			echo'		</div>
						<div id="mycart_buttons">
							<input type="button" onclick="download_cart();" class="buttonSubmit" value="download"/>
						</div>
					</div>
					<div id="mycart_footer"></div>
					<script type="text/javascript">
						function remove_cart_item(song_id) {
							var parameters = {song_id: song_id};
							process_request(\'cart_remove\', parameters, mycart_response);
						}
						function download_cart() {
							var load = window.open(\'download.php\');
							$(\'#mycart_container\').load("script/processing/load_cart.php", {random: Math.random()});
						}
					</script>
					';
		}
	}
}
?>
