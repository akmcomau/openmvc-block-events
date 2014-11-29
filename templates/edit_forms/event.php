<div class="row">
	<div class="col-md-3 col-sm-3 title-2column"><?php echo $text_date; ?></div>
	<div class="col-md-9 col-sm-9 ">
		<input class="form-control" type="text" id="datepicker" name="date" />
		<?php echo $form->getHtmlErrorDiv('date'); ?>
	</div>
</div>
<hr class="separator-2column" />
<?php if ($enable_time) { ?>
	<div class="row">
		<div class="col-md-3 col-sm-3 title-2column"><?php echo $text_time; ?></div>
		<div class="col-md-9 col-sm-9 ">
			<input type="text" class="form-control" name="time" value="<?php echo htmlspecialchars($block->getType()->datetime ? date('H:i', strtotime($block->getType()->datetime)) : ''); ?>" />
			<?php echo $form->getHtmlErrorDiv('time'); ?>
		</div>
	</div>
	<hr class="separator-2column" />
<?php } ?>
<div class="row">
	<div class="col-md-3 col-sm-3 title-2column"><?php echo $text_url; ?></div>
	<div class="col-md-9 col-sm-9 ">
		<input type="text" class="form-control" name="url" value="<?php echo htmlspecialchars($block->getType()->url); ?>" />
		<?php echo $form->getHtmlErrorDiv('url'); ?>
	</div>
</div>
<hr class="separator-2column" />

<script type="text/javascript">
	$("#datepicker").datepicker();
	$('#datepicker').datepicker('option', 'dateFormat', 'yy-mm-dd');
	<?php if ($block->getType()->date) { ?>
		$("#datepicker").datepicker("setDate" , new Date('<?php echo date('Y-m-d', strtotime(htmlspecialchars($block->getType()->date))); ?>'));
	<?php } ?>
</script>
