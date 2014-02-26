<?php
session_start();
require_once('../classes/Artist.class.php');
require_once('../classes/Pagination.class.php');
				?>
				<div id="box_container">
					<div id="box_header" class="box_admin_artists_header">
						<div class="record_top">
							<a class="add_icon" onClick="show_record(0, 'admin_artist_form.php');" title="Add"></a>
						</div>
					</div>
					<div id="box_shadow"></div>
					<div id="box_repeat">
			<?php
						$result = Artist::fetchAll();
						if (sizeof($result['list']) > 0) {
							$pagination = $result['pagination'];
							$pagination->show('show_artists');
							foreach($result['list'] as $artist) { ?>
							<div class="record_container">
								<div class="record_header"></div>
								<div class="record_repeat">
									<div class="record_wrapper">
										<div class="song_image">
											<?php echo $artist->displayImage();?>
										</div>
										<div class="song_content">
											<?php echo $artist->getArtistName();?>
										</div>
										<div class="record_options">
											<div class="icon_box">
												<a class="edit_icon" onClick="show_record(<?php echo $artist->getArtistID();?>, 'admin_artist_form.php');" title="Edit"></a>
												<a class="delete_icon" onClick="delete_record(<?php echo $artist->getArtistID();?>, 'Artist', function() {show_artists(1);});" title="Delete"></a>
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
					function show_artists(page) {
						$('#content_repeat').load("script/modules/admin_artists.php<?php echo ((strlen(getenv("QUERY_STRING")) > 0)? '?'.getenv("QUERY_STRING") : '');?>", {page: page, random: Math.random()});
					}
				</script>
