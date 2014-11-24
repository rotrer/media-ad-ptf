<?php echo $this->Form->create('Plugin', array('class' => 'form-inline', 'inputDefaults' => array(
        'label' => false,
        'div' => false
  	))); ?>
	<fieldset>

	<!-- Form Name -->
	<legend>Editar Plugin</legend>

		<div class="row">
			<div class="col-md-12">
				<h4>Datos generales</h4><br>
				<!-- Text input-->
				<div class="form-group">
				  <label class="col-md-4 control-label" for="name">Nombre</label>  
				  <div class="col-md-6">
				  <?php echo $this->Form->input('name', array('value' => $plugin['Plugin']['name'], 'placeholder' => "Ej. Campaña Producto Heineken", 'class' => "form-control input-md", 'required' => "required")); ?>
				    
				  </div>
				</div>

				<!-- Text input-->
				<div class="form-group">
				  <label class="col-md-4 control-label" for="domain">Sitios</label>  
				  <div class="col-md-6">
				  <?php echo $this->Form->input('sites_id', array('options' => $sites, 'selected' => $plugin['Plugin']['sites_id'], 'empty' => 'Seleccione', 'placeholder' => "dominio.cl", 'class' => "form-control input-md", 'required' => "required")); ?>
				    
				  </div>
				</div>
			</div>
		</div>

		<div class="row">
			<div class="col-md-12">
				<h4>Datos zonas</h4><br>
				<div class="row">
					<div class="col-md-9">
					</div>
					<div class="col-md-3">
						<!-- Button -->
						<div class="form-group pull-right">
					  	<div class="wait-agregar" style="float:left; display:none;">
					  		<?php echo $this->Html->image('spinner.gif', array('alt' => 'Wait')); ?>
					  	</div>
					    <button id="newZona" name="enviar" class="btn btn-info btn-xs">Agregar</button>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-2"><strong>Línea Pedido</strong></div>
					<div class="col-md-2"><strong>Ad Unit</strong></div>
					<div class="col-md-2"><strong>Nombre Zona</strong></div>
					<div class="col-md-2"><strong>ID Tag Template</strong></div>
					<div class="col-md-1"><strong>Out of page</strong></div>
					<div class="col-md-3"><strong>Estilo</strong></div>
				</div>
				<p>&nbsp;</p>
				<?php if($zonasLineInfo) foreach ($zonasLineInfo as $key => $zona) { ?>
				<?php echo $this->Form->input(null, array('value' => $zona['Zona']['id'], 'name' => 'zona_id[]', 'type' => 'hidden')); ?>
				<div class="row rowZonas">
					<div class="col-md-2">
						<div class="form-group">
  						<?php #echo $this->Form->input(null, array('name' => 'line_item[]', 'options' => $lineList, 'type' => 'select' ,'empty' => 'Seleccione', 'class' => "form-control selectedLine", 'required' => "required")); ?>
  						<select name="line_item[]" class="form-control selectedLine" required="required" id="PluginSitesId">
								<option value="">Seleccione</option>
								<?php foreach ($lineList as $key => $line) { $selectedLine = (strstr($key, $zona['LineItems']['line_id_dfp'])) ? 'selected="selected"' : ''; ?>
								<option value="<?php echo $key; ?>" <?php echo $selectedLine; ?>><?php echo $line; ?></option>
								<?php } ?>
							</select>
						</div>
					</div>
					<div class="col-md-2">
						<div class="wait-select" style="float:left; display:none;">
				  		<?php echo $this->Html->image('spinner.gif', array('alt' => 'Wait')); ?>
				  	</div>
						<div class="form-group">
  						<?php #echo $this->Form->input(null, array('name' => 'ad_unit[]', 'options' => '', 'type' => 'select', 'empty' => 'Seleccione', 'class' => "form-control", 'required' => "required")); ?>
  						<select name="ad_unit[]" class="form-control" required="required" id="PluginSitesId">
								<option value="">Seleccione</option>
								<option value="<?php echo $zona['AdUnits']['name'] ?>|<?php echo $zona['AdUnits']['adunit_id_dfp'] ?>" selected="selected"><?php echo $zona['AdUnits']['name'] ?></option>
							</select>
						</div>
					</div>
					<div class="col-md-2">
						<div class="form-group">
  						<?php echo $this->Form->input(null, array('value' => $zona['Zona']['name'], 'name' => 'zona_name[]', 'type' => 'text', 'class' => "form-control", 'required' => "required")); ?>
						</div>
					</div>
					<div class="col-md-2">
						<div class="form-group">
  						<?php echo $this->Form->input(null, array('value' => $zona['Zona']['id_tag_template'], 'name' => 'id_tag_template[]', 'type' => 'text', 'class' => "form-control", 'required' => "required")); ?>
						</div>
					</div>
					<div class="col-md-1">
						<div class="form-group">
  						<select name="out_of_page[]" class="form-control" id="PluginSitesId">
								<option value="">Seleccione</option>
								<option value="1" <?php echo ($zona['Zona']['out_of_page'] == 1) ? 'selected="selected"' : ''; ?>>SI</option>
								<option value="0" <?php echo ($zona['Zona']['out_of_page'] == 0) ? 'selected="selected"' : ''; ?>>NO</option>
							</select>
						</div>
					</div>
					<div class="col-md-3">
						<div class="form-group">
  						<?php echo $this->Form->input(null, array('value' => $zona['Zona']['style'], 'name' => 'style[]', 'type' => 'textarea', 'class' => "form-control")); ?>
						</div>
						<button type="button" class="btn btn-danger pull-right zonaDelete" data-zona="<?php echo $zona['Zona']['id']; ?>">
							<span class="glyphicon glyphicon-remove"></span>
						</button>
					</div>
				</div>
				<?php } ?>
				<div class="addZona"></div>
			</div>


			<p>&nbsp;</p>
		</div>

		<div class="row">
			<div class="col-md-9">
			</div>
			<div class="col-md-3">
				<!-- Button -->
				<div class="form-group pull-right">
				  <label class="col-md-4 control-label" for="enviar"></label>
				  <div class="col-md-4">
				    <button id="enviar" name="enviar" class="btn btn-primary">Guardar</button>
				  </div>
				</div>
			</div>
		</div>

	</fieldset>
<?php echo $this->Form->end(); ?>