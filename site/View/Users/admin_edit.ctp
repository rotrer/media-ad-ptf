<div class="users form">
<?php echo $this->Form->create('User'); ?>
	<fieldset>
		<legend><?php echo __('Admin Edit User'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('name');
		echo $this->Form->input('username');
		echo $this->Form->input('password', array('value' => '', 'required' => false));
		echo $this->Form->input('email');
		echo $this->Form->input('role',array(
				'options' => array('user' => 'Usuario', 'client' => 'Cliente', 'admin' => 'Administrador')
			));
		echo $this->Form->input('state', array(
				'options' => array('activo' => 'Activo', 'inactivo' => 'Inactivo')
			));
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $this->Form->value('User.id')), null, __('Are you sure you want to delete # %s?', $this->Form->value('User.id'))); ?></li>
		<li><?php echo $this->Html->link(__('List Users'), array('action' => 'index')); ?></li>
	</ul>
</div>
