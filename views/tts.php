<div class="container-fluid">
	<div class="row">
		<div class="col-sm-9">
			<?php
				if ($id) {
			?>
					<h2>
						<?php echo _("Text To Speech").": ". $name; ?>
					</h2>
			<?php
				}
			?>
			<div class="fpbx-container">
				<div class="display full-border">
					<form class="fpbx-submit popover-form" autocomplete="off" name="editTTS" action="" method="post" data-fpbx-delete="config.php?display=tts&id=<?php echo $id; ?>&action=delete">
					<input type="hidden" name="display" value="tts">
					<input type="hidden" name="action" value="<?php echo ($id ? 'edit' : 'add') ?>">
					<?php if ($id) { ?>
						<input type="hidden" name="id" value="<?php echo $id; ?>">
					<?php } ?>
					<!--Device List-->
					<div class="element-container">
						<div class="row">
							<div class="form-group">
								<div class="col-md-9">
									<h5><?php echo _("Main settings"); ?>:<hr></h5>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="form-group">
								<div class="col-md-3">
									<label class="control-label" for="name"><?php echo _("Name"); ?></label>
									<i class="fa fa-question-circle fpbx-help-icon" data-for="name"></i>
								</div>
								<div class="col-md-6">
									<input type="text" name="name" value="<?php echo (isset($name) ? $name : ''); ?>">
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-12">
								<span id="name-help" class="help-block fpbx-help-block"><?php echo _("Give this TTS Destination a brief name to help you identify it"); ?></span>
							</div>
						</div>
						<div class="row">
							<div class="form-group">
								<div class="col-md-3">
									<label class="control-label" for="text"><?php echo _("Text"); ?></label>
									<i class="fa fa-question-circle fpbx-help-icon" data-for="text"></i>
								</div>
								<div class="col-md-6">
									<textarea name="text" cols=50 rows=5>
										<?php echo (isset($text) ? $text : ''); ?>
									</textarea>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-12">
								<span id="text-help" class="help-block fpbx-help-block"><?php echo _("Enter the text you want to synthetize."); ?></span>
							</div>
						</div>
						<div class="row">
							<div class="form-group">
								<div class="col-md-9">
									<h5><?php echo _("TTS Engine"); ?>:<hr></h5>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="form-group">
								<div class="col-md-3">
									<label class="control-label" for="engine"><?php echo _("Choose an Engine"); ?></label>
									<i class="fa fa-question-circle fpbx-help-icon" data-for="engine"></i>
								</div>
								<div class="col-md-6">
									<?php if( !isset($tts_agi_error) ) { ?>
										<select name="engine">
											<?php
												foreach ($engine_list as $e)
												{
													if ($e['name'] == $engine) {
														echo '<option value="' . $e['name'] . '" selected=1>' . $e['name'] . '</option>';
													} else {
														echo '<option value="' . $e['name'] . '">' . $e['name'] . '</option>';
													}
												}
											?>
										</select>
									<?php } else { ?>
										<i><?php echo $tts_agi_error; ?></i>
									<?php } ?>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-12">
								<span id="engine-help" class="help-block fpbx-help-block"><?php echo _("List of TTS engine detected on the server. Choose the one you want to use for the current sentence."); ?></span>
							</div>
						</div>
						<div class="row">
							<div class="form-group">
								<div class="col-md-3">
									<label class="control-label" for="goto"><?php echo _("Desintation"); ?></label>
									<i class="fa fa-question-circle fpbx-help-icon" data-for="goto"></i>
								</div>
								<div class="col-md-6">
									<?php
									if (isset($goto)) {
										echo drawselects($goto,0);
									} else {
										echo drawselects(null, 0);
									}
									?>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-12">
								<span id="goto-help" class="help-block fpbx-help-block"><?php echo _("After the Text to Speech was played go to"); ?></span>
							</div>
						</div>
					</div>
					</form>
				</div>
			</div>
		</div>
		<div class="col-sm-3 hidden-xs">
			<div class="list-group">
				<a href="?display=tts" class="list-group-item <?php echo (empty($id)) ? 'active' : '';?>">
					<?php echo _("Add a Text to Speech item"); ?>
				</a>
				<?php
				if (isset($tts_list)) {
					foreach ($tts_list as $item) {
				?>
						<a href="config.php?display=tts&id=<?php echo urlencode($item['id']);?>" class="list-group-item <?php echo ($id == $item['id']) ? 'active' : '';?>">
							<?php echo $item['name']; ?>
						</a>
				<?php
					}
				}
				?>
			</div>
		</div>
	</div>
</div>
