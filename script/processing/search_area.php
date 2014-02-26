<?php
session_start();
require_once('../classes/User.class.php');
$user = User::getLoggedInUser();
if ($user != null) { ?>
	<div id="song_search">
			<input id="song_search_q" type="text" size="20" name="query" /><a href="#" id="song_search_submit" class="submit">Search</a>
	</div>
	<script type="text/javascript">
		$('#song_search_submit').click(function () {
			if ($('#catalogue_container').length) {
				browse_catalogue(1);
			} else {
				$('#content_repeat').load("script/modules/page_catalogue.php", {random: Math.random()});
			}
		});
	</script>
<?php
}
?>
