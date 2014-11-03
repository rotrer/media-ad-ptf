<?php echo $this->Form->create('Zona', array('class' => 'form-horizontal')); ?>
<fieldset>

<!-- Form Name -->
<legend>Agregar Zona a un Sitio</legend>
<dl>
	<dt><?php echo __('Nombre'); ?></dt>
	<dd>
		<?php echo h($sites['Site']['name']); ?>
		&nbsp;
	</dd>
	<dt><?php echo __('Url'); ?></dt>
	<dd>
		<?php echo h($sites['Site']['domain']); ?>
		&nbsp;
	</dd>
</dl>
<div class="table-responsive">
	<table class="table table-striped">
		<thead>
			<tr>
				<th><label class="control-label">Zona Nombre</label></th>
				<th><label class="control-label">Ad Unit</label></th>
				<th><label class="control-label">ID Tag Template</label></th>
			</tr>
		</thead>
		<tbody>
			<?php for ($i=0; $i < $cantidad_zonas; $i++) { ?>
			<tr>
				<td>
					<div class="form-group">
					  <div class="col-md-6">
					  	<?php echo $this->Form->input('name'.$i, array('div' => false, 'label' => false, 'required', 'class' => 'form-control input-md', 'placeholder' => 'Nombre Zona')); ?>
					  </div>
					</div>
				</td>
				<td>
					<div class="form-group">
					  <div class="col-md-6">
					  	<?php echo $this->Form->select('adunit'.$i, $adunits, array('div' => false, 'label' => false, 'required', 'empty' => 'Seleccione', 'class' => 'form-control adunit_sel')); ?>
							<?php echo $this->Form->input('adunit_name'.$i, array('type' => 'hidden')); ?>
					  </div>
					</div>
				</td>
				<td>
					<div class="form-group">
					  <div class="col-md-6">
					  	<?php echo $this->Form->input('id_tag_template'.$i, array('div' => false, 'label' => false, 'required', 'class' => 'form-control input-md', 'placeholder' => '#ID_TAG')); ?>
					  </div>
					</div>
				</td>
			</tr>
			<?php } ?>
		</tbody>
	</table>
</div>

<!-- Button -->
<div class="form-group">
  <label class="col-md-4 control-label pull-right" for="singlebutton"></label>
  <div class="col-md-4">
    <button id="singlebutton" name="singlebutton" class="btn btn-success">Finalizar</button>
  </div>
</div>

</fieldset>
<?php echo $this->Form->end(); ?>