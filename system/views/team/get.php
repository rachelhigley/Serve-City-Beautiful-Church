<div class="row">
	<div class="cols bucket">
		<?php if(Session::get('logged_in') && Auth::user("member_type_id") !== "2"): ?>
			<div class="utility">
				<a href="<?php echo Asset::create_url('team',"update",array($team['id']))?>">Edit Team</a> |
				<a href="<?php echo Asset::create_url('testimonial',"post",array($team['id']))?>">Add Testimonial</a>
			</div>
		<?php endif;?>
		<h1><?php echo $team['name']?></h1>
		<!-- <iframe width="560" height="315" src="<?php echo $team['video']?>" frameborder="0" allowfullscreen></iframe> -->
		<div class="row"><?php echo Asset::img($team['photo']);?></div>
		<p><?php echo preg_replace( "/\n/", "<br />", $team['content']);?></p>
	</div>
</div>
<?php if($testimonials): ?>
	<div class="row">
		<h2>Testimonials</h2>
	</div>
	<?php foreach($testimonials as $i=>$testimonial):?>
		<?php if($i%3 === 0 ) echo '<div class="row">' ?>
		<div class="cols col-4">
			<div class="bucket">
				<?php echo Asset::img($testimonial['photo']) ?>
				<h3><?php echo $testimonial['name'] ?></h3>
				<p><?php echo $testimonial['content']?></p>
			</div>
		</div>
		<?php if($i%3 === 2 ) echo '</div>' ?>
	<?php endforeach;?>
	<?php if($i%3 !== 2) echo '</div>' ?>
<?php endif;?>