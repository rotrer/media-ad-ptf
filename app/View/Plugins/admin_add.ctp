<?php echo $this->Form->create('Plugin', array('class' => 'form-inline', 'inputDefaults' => array(
        'label' => false,
        'div' => false
  	))); ?>
	<fieldset>

	<!-- Form Name -->
	<legend>Nuevo Plugin</legend>

		<div class="row">
			<div class="col-md-12">
				<h4>Datos generales</h4><br>
				<!-- Text input-->
				<div class="form-group">
				  <label class="col-md-4 control-label" for="name">Nombre</label>  
				  <div class="col-md-6">
				  <?php echo $this->Form->input('name', array('placeholder' => "Ej. Campaña Producto Heineken", 'class' => "form-control input-md", 'required' => "required")); ?>
				    
				  </div>
				</div>

				<!-- Text input-->
				<div class="form-group">
				  <label class="col-md-4 control-label" for="domain">Sitios</label>  
				  <div class="col-md-6">
				  <?php echo $this->Form->input('sites_id', array('empty' => 'Seleccione', 'placeholder' => "dominio.cl", 'class' => "form-control input-md", 'required' => "required")); ?>
				    
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
						  <label class="col-md-4 control-label" for="enviar"></label>
						  <div class="col-md-4">
						    <button id="newZona" name="enviar" class="btn btn-info btn-xs">Agregar</button>
						  </div>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-3"><strong>Línea Pedido</strong></div>
					<div class="col-md-3"><strong>Ad Unit</strong></div>
					<div class="col-md-3"><strong>Nombre Zona</strong></div>
					<div class="col-md-3"><strong>ID Tag Template</strong></div>
				</div>
				<p>&nbsp;</p>
				<div class="row rowZonas">
					<div class="col-md-3">
						<div class="form-group">

  						<?php echo $this->Form->input(null, array('name' => 'line_item[]', 'options' => $lineList, 'type' => 'select' ,'empty' => 'Seleccione', 'class' => "form-control selectedLine", 'required' => "required")); ?>
						</div>
					</div>
					<div class="col-md-3">
						<div class="form-group">
  						<?php echo $this->Form->input(null, array('name' => 'ad_unit[]', 'options' => '', 'type' => 'select', 'empty' => 'Seleccione', 'class' => "form-control", 'required' => "required")); ?>
						</div>
					</div>
					<div class="col-md-3">
						<div class="form-group">
  						<?php echo $this->Form->input(null, array('name' => 'zona_name[]', 'type' => 'text', 'class' => "form-control", 'required' => "required")); ?>
						</div>
					</div>
					<div class="col-md-3">
						<div class="form-group">
  						<?php echo $this->Form->input(null, array('name' => 'id_tag_template[]', 'type' => 'text', 'class' => "form-control", 'required' => "required")); ?>
						</div>
						<button type="button" class="btn btn-danger  pull-right">
							<span class="glyphicon glyphicon-remove"></span>
						</button>
					</div>
				</div>
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
				    <button id="enviar" name="enviar" class="btn btn-primary">Continuar</button>
				  </div>
				</div>
			</div>
		</div>

	</fieldset>
<?php echo $this->Form->end(); ?>