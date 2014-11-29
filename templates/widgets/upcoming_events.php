<div class="row">
	<?php foreach ($events as $event) { ?>
		<div class="col-md-4">
			<h3><?php echo htmlspecialchars($event->title); ?></h3>
			Date: <?php echo htmlspecialchars($event->getType()->date); ?>
		</div>
	<?php } ?>
</div>
