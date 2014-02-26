							<table class="form_table">
								<tr valign="top">
									<td colspan="2"><div id="info_message" style="display: none;"></div></td>
								</tr>
								<tr valign="top"> 
									<td width="30%">
									<?php echo ((isset($artist))? $artist->displayImage() : '<img id="image_uploaded" src="uploads/default_image.png" width="80px" height="80px" />');?>									
									</td>
									<td width="70%">
										<label for="artist_name">Artist Name:</label><br />
										<input id="artist_name" class="validate[custom[onlyLetter]] text-input" name="artist_name" value="<?php if (isset($artist)) echo $artist->getArtistName(); ?>" title="Artist Name" maxlength="15" tabindex="5" type="text" /> <br />
										<input id="artist_image" name="artist_image" value="<?php if (isset($artist)) echo $artist->getArtistImage(); ?>" type="text" size="8" readonly="true" /><input id="upload_image" type="button" value="Browse" />
									</td>
								</tr>
								<tr valign="top">
									<td colspan="2" style="text-align: center;"><input class="buttonSubmit" type="submit" value="Submit" tabindex="10" /></td>
								</tr>
							</table>
	
