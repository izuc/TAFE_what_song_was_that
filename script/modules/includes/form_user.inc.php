<?php
require_once('../classes/Genre.class.php');
?>
							<table class="form_table">
								<tr valign="top">
									<td colspan="2"><div id="info_message" style="display: none;"></div></td>
								</tr>
								<tr valign="top"> 
									<td width="30%">
										<label for="user_first_name">First Name:</label>
									</td>
									<td width="70%">
										<input id="user_first_name" class="validate[custom[onlyLetter],length[0,15]] text-input" name="user_first_name" value="<?php if (isset($user)) echo $user->getUserFirstName(); ?>" title="First Name" maxlength="15" tabindex="5" type="text" />
									</td>
								</tr>
								<tr valign="top"> 
									<td width="30%">
										<label for="user_last_name">Last Name:</label>
									</td>
									<td width="70%">
										<input id="user_last_name" class="validate[custom[onlyLetter],length[0,15]] text-input" name="user_last_name" value="<?php if (isset($user)) echo $user->getUserLastName(); ?>" title="Last Name" maxlength="15" tabindex="6" type="text" />
									</td>
								</tr>
								<tr valign="top"> 
									<td width="30%">
										<label for="user_email_address">Email:</label>
									</td>
									<td width="70%">
										<input id="user_email_address" class="validate[custom[email],length[0,25]] text-input" name="user_email_address" value="<?php if (isset($user)) echo $user->getUserEmailAddress(); ?>" title="Email Address" maxlength="25" tabindex="7" type="text" />
									</td>
								</tr>
								<tr valign="top"> 
									<td width="30%">
										<label for="user_favourite_genre">Favourite Genre:</label>
									</td>
									<td width="70%">
										<select id="user_favourite_genre" name="user_favourite_genre" style="width: 145px;">
											<option value='0'>[-- None --]</option>
											<?php Genre::displaySelectOptions(((isset($user))? $user->getUserFavouriteGenre() : 0)); ?>
										</select>
									</td>
								</tr>
								<tr valign="top"> 
									<td width="30%">
										<label for="user_phone_number">Telephone:</label>
									</td>
									<td width="70%">
										<input id="user_phone_number" class="validate[custom[telephone]] text-input" name="user_phone_number" value="<?php if (isset($user)) echo $user->getUserPhoneNumber(); ?>" title="Phone Number" maxlength="10" tabindex="8" type="text" /> 
									</td>
								</tr>
								<tr valign="top"> 
									<td width="30%">
										<label for="user_account_password">Password:</label>
									</td>
									<td width="70%">
										<input id="user_account_password" class="text-input" name="user_account_password" value="" title="Password" maxlength="15" tabindex="9" type="password" /> 
									</td>
								</tr>
								<tr valign="top">
									<td colspan="2" style="text-align: center;"><input class="buttonSubmit" type="submit" value="Submit" tabindex="10" /></td>
								</tr>
							</table>