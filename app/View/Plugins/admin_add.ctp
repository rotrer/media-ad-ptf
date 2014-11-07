<?php echo $this->Form->create('Plugin', array('class' => 'form-horizontal', 'inputDefaults' => array(
        'label' => false,
        'div' => false
  	))); ?>
	<fieldset>

	<!-- Form Name -->
	<legend>Nuevo Plugin</legend>

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

	<!-- Button -->
	<div class="form-group">
	  <label class="col-md-4 control-label" for="enviar"></label>
	  <div class="col-md-4">
	    <button id="enviar" name="enviar" class="btn btn-primary">Continuar</button>
	  </div>
	</div>

	</fieldset>
<?php echo $this->Form->end(); ?>