<?php echo $this->Form->create('Site', array('class' => 'form-horizontal', 'inputDefaults' => array(
        'label' => false,
        'div' => false
  	))); ?>
	<fieldset>

	<!-- Form Name -->
	<legend>Nuevo Sitio</legend>

	<!-- Text input-->
	<div class="form-group">
	  <label class="col-md-4 control-label" for="name">Nombre</label>  
	  <div class="col-md-6">
	  <?php echo $this->Form->input('name', array('placeholder' => "Nombre sitio", 'class' => "form-control input-md", 'required' => "required")); ?>
	    
	  </div>
	</div>

	<!-- Text input-->
	<div class="form-group">
	  <label class="col-md-4 control-label" for="domain">Dominio</label>  
	  <div class="col-md-6">
	  <?php echo $this->Form->input('domain', array('placeholder' => "dominio.cl", 'class' => "form-control input-md", 'required' => "required")); ?>
	    
	  </div>
	</div>

	<!-- Select Basic -->
	<div class="form-group">
	  <label class="col-md-4 control-label" for="state">Estado</label>
	  <div class="col-md-6">
	  	<?php echo $this->Form->input('state', array(
				'options' => array('activo' => 'Activo', 'inactivo' => 'Inactivo'), 'class'=> 'form-control', 'required' => "required"
			)); ?>
	  </div>
	</div>

	<!-- Select Multiple -->
	<div class="form-group">
	  <label class="col-md-4 control-label" for="User">Usuarios asociados</label>
	  <div class="col-md-6">
	    <?php echo $this->Form->input('User', array('class'=> 'form-control', 'multiple' => 'multiple')); ?>
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