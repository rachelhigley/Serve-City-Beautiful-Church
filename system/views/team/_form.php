<?php $params = array(); if(isset($id)) $params[0] = $id; ?>
<form method='POST' action='<?= Asset::create_url('Team',$action,$params) ?>' enctype="multipart/form-data">
	<?php if(isset($fields) && isset($fields['name'])):?>
		<p class='error'><?php echo $fields['name']?></p>
	<?php endif;?>
	<div>
		<label for='name'>Name:</label>
		<input type='text' id='name' name='name' value='<?php if(isset($name)) echo $name; ?>' />
	</div>
	<div>
		<label for="team_type">Team Type:</label>
		<input type="radio" name="team_type_id" id="normal" value="1"<?php if(!isset($team_type_id)) echo "checked" ?>  <?php if(isset($team_type_id) && $team_type_id === "1") echo "checked";?>>
		<label for="normal" class="check_label">Normal</label>
		<input type="radio" name="team_type_id" id="hidden" value="2" <?php if(isset($team_type_id) && $team_type_id === "2") echo "checked";?>>
		<label for="hidden" class="check_label">Hidden</label>
	</div>
	<?php if(isset($fields) && isset($fields['photo'])):?>
		<p class='error'><?php echo $fields['photo']?></p>
	<?php endif;?>
	<div>
		<label for='photo'>Photo:</label>
		<?php if(isset($photo)):  ?>
			<?php echo Asset::img($photo, array('width'=>250,'id'=>"profile")) ?>
		<?php endif;?>
		<input type="file" name="photo" id="photo">
	</div>
	<?php if(isset($fields) && isset($fields['summary'])):?>
		<p class='error'><?php echo $fields['summary']?></p>
	<?php endif;?>
	<div>
		<label for='summary'>Summary: <em>Displayed on home page</em></label>
		<textarea name="summary" id="summary" cols="30" rows="10"><?php if(isset($summary)) echo $summary; ?></textarea>
	</div>
	<?php if(isset($fields) && isset($fields['video'])):?>
		<p class='error'><?php echo $fields['video']?></p>
	<?php endif;?>
	<div>
		<label for='video'>Video Link:<em>Youtube embed link</em></label>
		<input type='text' id='video' name='video' value='<?php if(isset($video)) echo $video; ?>' />
	</div>
	<?php if(isset($fields) && isset($fields['content'])):?>
		<p class='error'><?php echo $fields['content']?></p>
	<?php endif;?>
	<div>
		<label for='content'>Content: </label>
		<textarea name="content" id="content" cols="30" rows="10"><?php if(isset($content)) echo $content; ?></textarea>
	</div>
	<div class="row">
		<div class="col-6">
			<input type='submit' value='save' class="button" />
		</div>
	</div>
</form>