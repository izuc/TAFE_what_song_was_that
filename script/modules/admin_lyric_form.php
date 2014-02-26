<?php
session_start();
require_once('../classes/User.class.php');
require_once('../classes/Song.class.php');
if (User::isAdminSession()) {
	$record_id = (isset($_POST['id']) ? $_POST['id'] : 0);
	if ($record_id > 0) {
		$song = Song::create($record_id);
	}
?>
				<div id="box_container">
					<div id="box_header" class="box_admin_lyrics_header"></div>
					<div id="box_shadow"></div>
					<div id="box_repeat">
						<form id="lyric_form">
							<?php include('includes/form_lyric.inc.php');?>		
						</form>
						<script type="text/javascript">
							$('#lyric_form').validationEngine({
								success : function() {
									var parameters = $('#lyric_form').serializeForm();
									parameters.record_id = <?php echo $record_id;?>;
									process_request('save_lyric', parameters, submit_response);
								},
								failure: function() {}
							});
						</script>
					</div>
					<div id="box_footer"></div>
				</div>
				<div id="side_image"></div>
<?php
}
?>