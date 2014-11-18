<?php echo $this->Form->create('User', array('class' => 'form-horizontal', 'inputDefaults' => array(
        'label' => false,
        'div' => false
  	))); ?>
	<fieldset>

	<!-- Form Name -->
	<legend>Cambiar Contraseña</legend>

	<!-- Text input-->
	<div class="form-group">
	  <label class="col-md-4 control-label" for="nueva_pass">Nueva Contraseña</label>  
	  <div class="col-md-6">
	  <?php echo $this->Form->input('nueva_pass', array('type' => 'password', 'placeholder' => "*****", 'class' => "form-control input-md", 'required' => "required", 'autoComplete' => 'off')); ?>
	    
	  </div>
	</div>

	<!-- Text input-->
	<div class="form-group">
	  <label class="col-md-4 control-label" for="nueva_pass_r">Repetir Nueva Contraseña</label>  
	  <div class="col-md-6">
	  <?php echo $this->Form->input('nueva_pass_r', array('type' => 'password', 'placeholder' => "*****", 'class' => "form-control input-md", 'required' => "required", 'autoComplete' => 'off')); ?>
	  </div>
	</div>

	<!-- Button -->
	<div class="form-group">
	  <label class="col-md-4 control-label" for="enviar"></label>
	  <div class="col-md-4">
	    <button id="enviar" name="enviar" class="btn btn-primary">Actualizar</button>
	  </div>
	</div>

	</fieldset>
<?php echo $this->Form->end(); ?>