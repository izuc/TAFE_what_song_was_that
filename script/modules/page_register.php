				<div id="box_container">
					<div id="box_header" class="box_register_header"></div>
					<div id="box_shadow"></div>
					<div id="box_repeat">
						<form id="register">
							<?php
								include('includes/form_user.inc.php');
							?>
						</form>
						<script type="text/javascript">
						$('#register').validationEngine({
							success : function() {
								var parameters = $('#register').serializeForm();
								parameters.user_account_type = 1;
								process_request('save_user', parameters, submit_response);
							},
							failure: function() {}
						});
						</script>
					</div>
					<div id="box_footer"></div>
				</div>
				<div id="side_image"></div>