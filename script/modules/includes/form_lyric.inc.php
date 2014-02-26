<?php
require_once('../classes/Genre.class.php');
require_once('../classes/Artist.class.php');
?>
							<table class="form_table">
								<tr valign="top">
									<td colspan="2"><div id="info_message" style="display: none;"></div></td>
								</tr>
								<tr valign="top"> 
									<td width="50%">
										<label for="artist_id">Artist</label> <br />
										<select id="artist_id" name="artist_id" class="validate[required]" style="width: 145px;">
											<option value="0">[-- Please Select --]</option>
											<?php Artist::displaySelectOptions(((isset($song))? $song->getArtistID() : 0));?>
										</select>
									</td>
									<td width="50%">
										<label for="genre_id">Genre</label> <br />
										<select id="genre_id" name="genre_id" class="validate[required]" style="width: 145px;">
											<option value='0'>[-- Please Select --]</option>
											<?php Genre::displaySelectOptions(((isset($song))? $song->getGenreID() : 0)); ?>
										</select>
									</td>
								</tr>
								<tr valign="top"> 
									<td width="50%">
										<label for="song_title">Song Title</label> <br />
										<input id="song_title" class="validate[required, length[5,25]] text-input" name="song_title" value="<?php echo ((isset($song))? $song->getSongTitle() : '');?>" maxlength="25" title="song title" type="text" />
									</td>
									<td width="50%">
										<label for="song_release_year">Song Release Year</label> <br />
										<input id="song_release_year" class="validate[required, custom[onlyNumber, length[4,4]]] text-input" name="song_release_year" value="<?php echo ((isset($song))? $song->getReleaseYear() : '');?>" maxlength="4" title="song release year" type="text" />
									</td>
								</tr>
								<tr valign="top"> 
									<td colspan="2" width="100%">
										<label for="song_lyrics">Song Lyrics</label> <br />
										<textarea id="song_lyrics" name="song_lyrics" class="validate[required]" rows="25" cols="40"><?php echo ((isset($song))? $song->getSongLyrics() : '');?></textarea>
									</td>
								</tr>
								<tr valign="top">
									<td colspan="2" style="text-align: center;"><input class="buttonSubmit" type="submit" value="Submit" /></td>
								</tr>
							</table>
	
