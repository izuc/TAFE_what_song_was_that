<?php
session_start();
require_once('../classes/User.class.php');
?>
				<div id="box_container">
					<div id="box_header" class="box_profile_header"></div>
					<div id="box_shadow"></div>
					<div id="box_repeat">
						<form id="profile">
							<?php
								$user = User::getLoggedInUser();
								if ($user != null) include('includes/form_user.inc.php');
							?>
						</form>
						<script type="text/javascript">
						$('#profile').validationEngine({
							success : function() {
								<?php
									$user_logged_in = User::getLoggedInUser();
									if ($user_logged_in != null) {
										echo '
											var parameters = $(\'#profile\').serializeForm();
											parameters.record_id = '.$user_logged_in->getUserID().'
											parameters.user_account_type = '.$user_logged_in->getUserAccountType().';
											process_request(\'save_user\', parameters, submit_response);
										';
									}
								?>
							},
							failure: function() {}
						});
						</script>
					</div>
					<div id="box_footer"></div>
				</div>
				<div id="side_image"></div>