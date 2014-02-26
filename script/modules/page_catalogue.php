<?php
session_start();
require_once('../classes/Song.class.php');
require_once('../classes/Genre.class.php');
require_once('../classes/User.class.php');
$LoggedInUser = User::getLoggedInUser();
?>
				<div id="catalogue_container">
					<div id="catalogue_header">
						<div id="genre_selection_box">
							<select id="genre_selection" onchange="browse_catalogue(1);">
								<option value='0'>Display All Genres</option>
								<?php Genre::displaySelectOptions(((isset($LoggedInUser))? $LoggedInUser->getUserFavouriteGenre() : 0)); ?>
							</select>
						</div>
					</div>
					<div id="catalogue_shadow"></div>
					<div id="catalogue_repeat">
					
					
					</div>
					<div id="catalogue_footer"></div>
				</div>
				<script type="text/javascript">
					function browse_catalogue(page) {
						$('#catalogue_repeat').load("script/modules/page_catalogue_browse.php", {page: page, query: (($('#song_search_q').length)? $('#song_search_q').val() : ''),genre_id: $('#genre_selection').val(), random: Math.random()});
					}
					browse_catalogue(1);
				</script>