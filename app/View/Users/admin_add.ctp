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
