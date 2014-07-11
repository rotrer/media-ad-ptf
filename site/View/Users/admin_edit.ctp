<div class="users form">
<?php echo $this->Form->create('User'); ?>
	<fieldset>
		<legend><?php echo __('Editar Usuario'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('name', array('label' => 'Nombre'));
		echo $this->Form->input('username', array('type' => 'hidden'));
		echo $this->Form->input('password', array('value' => '', 'required' => false, 'label' => 'Contraseña'));
		echo $this->Form->input('email');
		echo $this->Form->input('role',array(
				'options' => array('user' => 'Usuario', 'client' => 'Cliente', 'admin' => 'Administrador'),
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

		<li><?php echo $this->Form->postLink(__('Eliminar'), array('action' => 'delete', $this->Form->value('User.id')), null, __('Seguro desea eliminar a %s?', $this->Form->value('User.name'))); ?></li>
		<li><?php echo $this->Html->link(__('Lista de usuarios'), array('action' => 'index')); ?></li>
	</ul>
</div>
