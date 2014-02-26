<?php
session_start();
require_once('../classes/User.class.php');
require_once('../classes/Artist.class.php');
if (User::isAdminSession()) {
	$record_id = (isset($_POST['id']) ? $_POST['id'] : 0);
	if ($record_id > 0) {
		$artist = Artist::create($record_id);
	}
?>
				<div id="box_container">
					<div id="box_header" class="box_admin_artists_header"></div>
					<div id="box_shadow"></div>
					<div id="box_repeat">
						<form id="artist_form">
							<?php include('includes/form_artist.inc.php');?>		
						</form>
						<script type="text/javascript">
							new AjaxUpload('#upload_image', {
								action: 'script/processing/upload.php',
								name: 'image',
								onComplete : function(file) {
									$('#artist_image').val(file);
								}	
							});
							$('#artist_form').validationEngine({
								success : function() {
									var parameters = $('#artist_form').serializeForm();
									parameters.record_id = <?php echo $record_id;?>;
									parameters.artist_image = $('#artist_image').val();
									process_request('save_artist', parameters, submit_response);
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