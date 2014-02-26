<?php
session_start();
require_once('../classes/Song.class.php');
require_once('../classes/Pagination.class.php');
				?>
				<div id="box_container">
					<div id="box_header" class="box_admin_lyrics_header">
						<div class="record_top">
							<a class="add_icon" onClick="show_record(0, 'admin_lyric_form.php');" title="Add"></a>
						</div>
					</div>
					<div id="box_shadow"></div>
					<div id="box_repeat">
			<?php
						$result = Song::fetchAll();
						if (sizeof($result['list']) > 0) {
							$pagination = $result['pagination'];
							$pagination->show('show_songs');
							foreach($result['list'] as $song) {
						?>
							<div class="record_container">
								<div class="record_header"></div>
								<div class="record_repeat">
									<div class="record_wrapper">
										<div class="song_image">
											<?php echo $song->getArtist()->displayImage();?>
										</div>
										<div class="song_content">
											<?php echo $song->getSongTitle();?>
										</div>
										<div class="record_options">
											<div class="icon_box">
												<a class="edit_icon" onClick="show_record(<?php echo $song->getSongID();?>, 'admin_lyric_form.php');" title="Edit"></a>
												<a class="delete_icon" onClick="delete_record(<?php echo $song->getSongID();?>, 'Song', function() {show_songs(1);});" title="Delete"></a>
											</div>
										</div>
									</div>
								</div>
								<div class="record_footer"></div>
							</div>
						<?php
							}
						}
						?>
					</div>
					<div id="box_footer"></div>
				</div>
				<div id="side_image"></div>
				<script type="text/javascript">
					function show_songs(page) {
						$('#content_repeat').load("script/modules/admin_lyrics.php<?php echo ((strlen(getenv("QUERY_STRING")) > 0)? '?'.getenv("QUERY_STRING") : '');?>", {page: page, random: Math.random()});
					}
				</script>
