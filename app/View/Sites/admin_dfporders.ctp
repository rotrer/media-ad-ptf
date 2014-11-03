<?php echo $this->Form->create('', array('class' => 'form-horizontal')); ?>
	<?php echo $this->Form->input('site_id', array('value' => $site['Site']['id'], 'type' => 'hidden')); ?>
	<?php echo $this->Form->input('name_order', array('id' => 'name_order', 'type' => 'hidden')); ?>
	<?php echo $this->Form->input('name_lineitem', array('id' => 'name_lineitem', 'type' => 'hidden')); ?>
<fieldset>

<!-- Form Name -->
<legend>Sitio: <?php echo h($site['Site']['name']); ?></legend>

<!-- Text input-->
<div class="form-group">
  <label class="col-md-4 control-label" for="textinput">Nombre</label>  
  <div class="col-md-6">
  <input id="textinput" name="textinput" type="text" placeholder="placeholder" class="form-control input-md" value="<?php echo h($site['Site']['name']); ?>" readonly>
    
  </div>
</div>

<!-- Text input-->
<div class="form-group">
  <label class="col-md-4 control-label" for="textinput">Estado</label>  
  <div class="col-md-6">
  <input id="textinput" name="textinput" type="text" placeholder="placeholder" class="form-control input-md" value="<?php echo h($site['Site']['state']); ?>" readonly>
    
  </div>
</div>

<!-- Text input-->
<div class="form-group">
  <label class="col-md-4 control-label" for="textinput">Fecha Registro</label>  
  <div class="col-md-6">
  <input id="textinput" name="textinput" type="text" placeholder="placeholder" class="form-control input-md" value="<?php echo date('d-m-Y', strtotime($site['Site']['created'])); ?>" readonly>
    
  </div>
</div>

<!-- Select Basic -->
<div class="form-group">
  <label class="col-md-4 control-label" for="orders">Pedidos</label>
  <div class="col-md-6">
  	<select name="data[Site][order_id]" id="orders" class="form-control" required>
			<option value="">Seleccione</option>
			<?php foreach ($orders as $key => $order) { ?>
			<option value="<?php echo $key; ?>"><?php echo $order; ?></option>
			<?php } ?>
		</select>
  </div>
</div>

<!-- Select Basic -->
<div class="form-group">
  <label class="col-md-4 control-label" for="line_items">Líneas de Pedidos</label>
  <div class="col-md-6">
  	<select name="data[Site][line_item_id]" id="line_items" class="form-control" required>
			<option value="">Seleccione</option>
		</select>
		<span class="load_lines loading" style="display:none;">Cargando...</span>
  </div>
</div>

<!-- Select Basic -->
<div class="form-group">
  <label class="col-md-4 control-label" for="cantidad_zonas">Cantidad de Zonas</label>
  <div class="col-md-6">
    <select name="data[Site][cantidad_zonas]" id="cantidad_zonas" class="form-control" required>
			<option value="">Seleccione</option>
			<?php for ($i=1; $i <= 20; $i++) { ?>
			<option value="<?php echo $i; ?>"><?php echo $i; ?></option>
			<?php } ?>
		</select>
  </div>
</div>

<!-- Button -->
<div class="form-group">
  <label class="col-md-4 control-label" for="singlebutton"></label>
  <div class="col-md-4">
    <button id="singlebutton" name="singlebutton" class="btn btn-primary">Continuar</button>
  </div>
</div>

</fieldset>
<?php echo $this->Form->end(); ?>
