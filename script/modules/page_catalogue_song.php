<?php
session_start();
require_once('../classes/User.class.php');
require_once('../classes/Song.class.php');
$record_id = (isset($_POST['id']) ? $_POST['id'] : 0);
if ($record_id > 0) {
	$song = Song::create($record_id);?>
				<div id="box_container">
					<div id="box_header" class="box_song_details_header">
						<div class="record_top"></div>
					</div>
					<div id="box_shadow"></div>
					<div id="box_repeat">
							<div class="record_container">
								<div class="record_header"></div>
								<div class="record_repeat">
									<div class="record_wrapper">
										<div class="song_image">
										<?php
											echo $song->getArtist()->displayImage();
										?>
										</div>
										<div class="song_content">
											<div class="song_title">											
												<span class="record_title"><?php echo $song->getSongTitle();?></span>
											</div>
											<div class="song_text">
												Year Released : <?php echo $song->getReleaseYear();?> <br />
												Artist: <?php echo $song->getArtist()->getArtistName();?> <br />
												Genre: <?php echo $song->getGenre()->getGenreName();?>
											</div>
										</div>
										<div class="record_options">
											<?php 
											if (User::getLoggedInUser() != null) {
												echo '<input type="button" onclick="add_to_cart('.$song->getSongID().');" class="buttonSubmit" value="Add" />';
											}
											?>
										</div>
									</div>
								</div>
								<div class="record_footer"></div>
							</div>
							<div class="record_container">
								<div class="record_header"></div>
								<div class="record_repeat">
									<div class="record_wrapper" style="height: 100%;">
										<?php echo nl2br($song->getSongLyrics());?>
									</div>
								</div>
								<div class="record_footer"></div>
							</div>
							
					
						
					</div>
					<div id="box_footer"></div>
				</div>
				<div id="side_image"></div>
				<script type="text/javascript">
					function add_to_cart(song_id) {
						var parameters = {song_id: song_id};
						process_request('cart_add', parameters, mycart_response);
					}
				</script>
<?php
}
?>