<div class="sites form">
<?php echo $this->Form->create('Site'); ?>
	<fieldset>
		<legend><?php echo __('Editar Sitio'); ?></legend>
	<?php
		echo $this->Form->input('name', array('label'=> 'Nombre'));
		echo $this->Form->input('domain', array('label'=> 'Dominio'));
		echo $this->Form->input('public_key', array('readonly', 'label'=> 'Llave Pública'));
		echo $this->Form->input('state', array(
				'options' => array('activo' => 'Activo', 'inactivo' => 'Inactivo'),
				'label'=> 'Estado'
			));
		echo $this->Form->input('User', array('label' => 'Usuarios asociados'));
	?>
	</fieldset>
<?php echo $this->Form->end(__('Enviar')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Acciones'); ?></h3>
	<ul>

		<li><?php echo $this->Form->postLink(__('Eliminar'), array('action' => 'delete', $this->Form->value('Site.id')), null, __('Seguro desea elminar %s?', $this->Form->value('Site.name'))); ?></li>
		<li><?php echo $this->Html->link(__('Lista Sitios'), array('action' => 'index')); ?></li>
		<li><?php echo $this->Html->link(__('Lista Usuarios'), array('controller' => 'users', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('Nuevo Usuario'), array('controller' => 'users', 'action' => 'add')); ?> </li>
	</ul>
</div>
