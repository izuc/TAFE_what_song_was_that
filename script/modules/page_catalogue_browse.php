<?php
session_start();
require_once('../classes/Song.class.php');
require_once('../classes/Pagination.class.php');
require_once('../includes/utils.inc.php');
						$result = Song::fetchAll((isset($_POST['query'])? $_POST['query'] : ''), $_POST['genre_id']);
						if (sizeof($result['list']) > 0) {
							$pagination = $result['pagination'];
							$pagination->show('browse_catalogue');
							foreach($result['list'] as $song) {
						?>
							<div class="song_container">
								<div class="song_header"></div>
								<div class="song_repeat">
									<div class="song_wrapper">
										<div class="song_image">
										<?php
											echo $song->getArtist()->displayImage();
										?>
										</div>
										<div class="song_content">
											<div class="song_title">											
												<span class="record_title link" title="<?php echo wordwrap(trim_text($song->getSongLyrics(), 250), 30, "<br />\n");?>" onClick="show_record(<?php echo $song->getSongID();?>, 'page_catalogue_song.php');"><?php echo trim_text($song->getSongTitle(), 18);?></span>
											</div>
											<div class="song_text">
												Year Released : <?php echo $song->getReleaseYear();?> <br />
												Artist: <?php echo $song->getArtist()->getArtistName();?> <br />
												Genre: <?php echo $song->getGenre()->getGenreName();?>
											</div>
										</div>
									</div>
								</div>
								<div class="song_footer"></div>
							</div>
						<?php
							}
						} else {
							echo '<div class="catalogue_error">Sorry. There are no songs found matching this criteria.</div>';
						}
						?>
						<script type="text/javascript">
							if ($('.record_title').length) {
								$('.record_title').tipsy({gravity: 's'});
							}
						</script>
										
   