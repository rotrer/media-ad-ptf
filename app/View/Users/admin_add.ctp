<div class="users form">
<?php echo $this->Form->create('User'); ?>
	<fieldset>
		<legend><?php echo __('Nuevo Usuario'); ?></legend>
	<?php
		echo $this->Form->input('name', array('label' => 'Nombre'));
		echo $this->Form->input('email', array('label' => 'Email', 'class' => 'checkemail'));
	?>
	<div class="check_email" style="display:none;"></div>
	<?php
		echo $this->Form->input('role',array(
				'options' => array('user' => 'Usuario', 'admin' => 'Administrador'),
				'label' => 'Rol'
			));
		echo $this->Form->input('state', array(
				'options' => array('activo' => 'Activo', 'inactivo' => 'Inactivo'),
				'label' => 'Estado'
			));
	?>
	</fieldset>
<?php echo $this->Form->end(__('Guardar')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Acciones'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('Lista de usuarios'), array('action' => 'index')); ?></li>
	</ul>
</div>


<?php echo $this->Form->create('User', array('class' => 'form-horizontal', 'inputDefaults' => array(
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
	  <?php echo $this->Form->input('name', array('placeholder' => "Nombre usuario", 'class' => "form-control input-md", 'required' => "required")); ?>
	    
	  </div>
	</div>

	<!-- Text input-->
	<div class="form-group">
	  <label class="col-md-4 control-label" for="email">Email</label>  
	  <div class="col-md-6">
	  <?php echo $this->Form->input('email', array('placeholder' => "email@dominio.cl", 'class' => "form-control input-md checkemail", 'required' => "required")); ?>
	  </div>
	  <div class="check_email" style="display:none;"></div>
	</div>

	<!-- Select Basic -->
	<div class="form-group">
	  <label class="col-md-4 control-label" for="role">Rol</label>
	  <div class="col-md-6">
	  	<?php echo $this->Form->input('role', array(
				'options' => array('user' => 'Usuario', 'admin' => 'Administrador'), 'empty' => 'Seleccione', 'class'=> 'form-control', 'required' => "required"
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