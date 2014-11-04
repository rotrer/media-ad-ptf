<?php echo $this->Form->create(null, array('url' => '/admin', 'class' => 'form-horizontal')); ?>
	<fieldset>

	<!-- Form Name -->
	<legend>Login</legend>

	<!-- Text input-->
	<div class="form-group">
	  <label class="col-md-4 control-label" for="email">Email</label>  
	  <div class="col-md-6">
	    <?php echo $this->Form->input('email', array('label'=> false, 'div' => false, 'placeholder' => 'mail@dominio.com', 'class' => 'form-control input-md', 'required' => 'required')); ?>
	  </div>
	</div>

	<!-- Password input-->
	<div class="form-group">
	  <label class="col-md-4 control-label" for="password">Contraseña</label>
	  <div class="col-md-6">
	    <?php echo $this->Form->input('password', array('label'=> false, 'div' => false, 'placeholder' => '******', 'class' => 'form-control input-md', 'required' => 'required')); ?>
	  </div>
	</div>

	<!-- Button -->
	<div class="form-group">
	  <label class="col-md-4 control-label" for="enviar"></label>
	  <div class="col-md-4">
	    <button id="enviar" name="enviar" class="btn btn-primary">Entrar</button>
	  </div>
	</div>

	</fieldset>
<?php echo $this->Form->end(); ?>

<!-- <div class="alert alert-success">...</div>
<div class="alert alert-info">...</div>
<div class="alert alert-warning">...</div>
<div class="alert alert-danger">...</div> -->