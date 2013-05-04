<?php $params = array(); if(isset($facebook_id)) $params[0] = $facebook_id; ?>
<div class="row">
	<div class="cols bucket">
		<?php if(isset($code) && $code === 2):?>
			<p class="error"><strong>Oh No!</strong> Something went wrong. See below to find out what.</p>
		<?php endif;?>
		<h1>Welcome<?php if(isset($first_name)):?>, <?php echo $first_name ?><?php endif;?>!</h1>
		<p class="welcome">Please fill out your settings.</p>
		<form method='POST' action='<?=$_SERVER['REQUEST_URI'] ?>'>
			<input type='hidden' id='facebook_id' name='facebook_id' size='40' value='<?php if(isset($facebook_id)) echo $facebook_id; ?>' />
			<?php if(isset($fields) && isset($fields['name'])):?>
				<p class='error'><?php echo $fields['name']?></p>
			<?php endif;?>
			<div>
				<label for='name'>Name:</label>
				<input type='text' id='name' name='name' value='<?php if(isset($name)) echo $name; ?>' />
			</div>
			<?php if(isset($fields) && isset($fields['email'])):?>
				<p class='error'><?php echo $fields['email']?></p>
			<?php endif;?>
			<div>
				<label for='email'>Email:</label>
				<input type='text' id='email' name='email' value='<?php if(isset($email)) echo $email; ?>' />
			</div>
			<?php if(isset($fields) && isset($fields['phone'])):?>
				<p class='error'><?php echo $fields['phone']?></p>
			<?php endif;?>
			<div>
				<label for='phone'>Cell Phone:</label>
				<input type='text' id='phone' name='phone' value='<?php if(isset($phone)) echo $phone; ?>' />
			</div>
			<?php if(isset($fields) && isset($fields['profile_pic'])):?>
				<p class='error'><?php echo $fields['profile_pic']?></p>
			<?php endif;?>
			<div>

				<label for='profile_pic'>Profile Picture:</label>
				<?php if(isset($profile_pic)):?>
					<img src="<?php echo $profile_pic ?>" id="profile" />
					<input type="hidden" name="facebook_pic" value="<?php echo $profile_pic ?>" />
				<?php endif;?>
				<input type="file" name="profile_pic" id="profile_pic">
			</div>
			<div>
				<label>I would like to serve in the following ways:</label>
				<?php foreach($teams as $team_field):?>
				<input type="checkbox" name="team[]" id="<?php echo $team_field['name']?>" value="<?php echo $team_field['id']?>" <?php if(isset($team) && in_array($team_field['id'], $team)) echo "checked";?>>
				<label for="<?php echo $team_field['name']?>" class="check_label"><a href="<?php echo Asset::create_url("Team","Get",array($team_field['id']))?>"><?php echo $team_field['name']?></a></label>

				<?php endforeach;?>
			</div>
			<?php if(isset($fields) && isset($fields['times'])):?>
				<p class='error'><?php echo $fields['times']?></p>
			<?php endif;?>
			<div>
				<label for='times'>I would like to serve this many times a month:</label>

				<input type="radio" name="times" id="One" value="1" <?php if(isset($times) && $times === "1") echo "checked";?>>
				<label for="One" class="check_label">One Time</label>
				<input type="radio" name="times" id="Two" value="2" <?php if(isset($times) && $times === "2") echo "checked";?>>
				<label for="Two" class="check_label">Two Times</label>
				<input type="radio" name="times" id="Three" value="3" <?php if(isset($times) && $times === "3") echo "checked";?>>
				<label for="Three" class="check_label">Three Times</label>
				<input type="radio" name="times" id="Every" value="5" <?php if(isset($times) && $times === "5") echo "checked";?>>
				<label for="Every" class="check_label">Every Week</label>
			</div>
			<div>
				<label>I would like to serve the following Sundays of the month:</label>
				<input type="checkbox" name="week[]" id="First" value="1" <?php if(isset($week) && in_array("1", $week)) echo "checked";?>>
				<label for="First" class="check_label">First</label>
				<input type="checkbox" name="week[]" id="Second" value="2" <?php if(isset($week) && in_array("2", $week)) echo "checked";?>>
				<label for="Second" class="check_label">Second</label>
				<input type="checkbox" name="week[]" id="Third" value="3" <?php if(isset($week) && in_array("3", $week)) echo "checked";?>>
				<label for="Third" class="check_label">Third</label>
				<input type="checkbox" name="week[]" id="Forth" value="4" <?php if(isset($week) && in_array("4", $week)) echo "checked";?>>
				<label for="Forth" class="check_label">Forth</label>
				<input type="checkbox" name="week[]" id="Fifth" value="5" <?php if(isset($week) && in_array("5", $week)) echo "checked";?>>
				<label for="Fifth" class="check_label">Fifth</label>
				<input type="checkbox" name="week[]" id="None" value="6" <?php if(isset($week) && in_array("6", $week)) echo "checked";?>>
				<label for="None" class="check_label">No Preference</label>
			</div>
			<?php if(isset($fields) && isset($fields['alert_type_id'])):?>
				<p class='error'><?php echo $fields['alert_type_id']?></p>
			<?php endif;?>
			<div>
				<label>Send me messages through:</label>
				<input type="radio" name="alert_type_id" id="Email" value="1" <?php if(isset($alert_type_id) && $alert_type_id === "1") echo "checked";?>>
				<label for="Email" class="check_label">Email</label>
				<input type="radio" name="alert_type_id" id="Text" value="2" <?php if(isset($alert_type_id) && $alert_type_id === "2") echo "checked";?>>
				<label for="Text" class="check_label">Text</label>
			</div>
			<?php if(isset($fields) && isset($fields['reminder_day_id'])):?>
				<p class='error'><?php echo $fields['reminder_day_id']?></p>
			<?php endif;?>
			<div>
				<label>Remind me on:</label>
				<input type="radio" name="reminder_day" id="Sunday" value="1" <?php if(isset($reminder_day) && $reminder_day === "1") echo "checked";?>>
				<label for="Sunday" class="check_label">Monday</label>
				<input type="radio" name="reminder_day" id="Sunday" value="2" <?php if(isset($reminder_day) && $reminder_day === "2") echo "checked";?>>
				<label for="Sunday" class="check_label">Tuesday</label>
				<input type="radio" name="reminder_day" id="Sunday" value="3" <?php if(isset($reminder_day) && $reminder_day === "3") echo "checked";?>>
				<label for="Sunday" class="check_label">Wednesday</label>
				<input type="radio" name="reminder_day" id="Sunday" value="4" <?php if(isset($reminder_day) && $reminder_day === "4") echo "checked";?>>
				<label for="Sunday" class="check_label">Thursday</label>
				<input type="radio" name="reminder_day" id="Sunday" value="5" <?php if(isset($reminder_day) && $reminder_day === "5") echo "checked";?>>
				<label for="Sunday" class="check_label">Friday</label>
				<input type="radio" name="reminder_day" id="Sunday" value="6" <?php if(isset($reminder_day) && $reminder_day === "6") echo "checked";?>>
				<label for="Sunday" class="check_label">Saturday</label>
				<input type="radio" name="reminder_day" id="Sunday" value="0" <?php if(isset($reminder_day) && $reminder_day === "0") echo "checked";?>>
				<label for="Sunday" class="check_label">Sunday</label>
				<input type="radio" name="reminder_day" id="Sunday" value="7" <?php if(isset($reminder_day) && $reminder_day === "7") echo "checked";?>>
				<label for="Sunday" class="check_label">Never</label>
			</div>
			<div class="row">
				<div class="col-6">
					<input type="submit" class="button" />
				</div>
			</div>
		</form>
	</div>
</div>