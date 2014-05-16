<div class="sites form">
<?php echo $this->Form->create('Site'); ?>
	<fieldset>
		<legend><?php echo __('Admin Edit Site'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('name');
		echo $this->Form->input('public_key');
		echo $this->Form->input('state');
		echo $this->Form->input('User');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $this->Form->value('Site.id')), null, __('Are you sure you want to delete # %s?', $this->Form->value('Site.id'))); ?></li>
		<li><?php echo $this->Html->link(__('List Sites'), array('action' => 'index')); ?></li>
		<li><?php echo $this->Html->link(__('List Users'), array('controller' => 'users', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New User'), array('controller' => 'users', 'action' => 'add')); ?> </li>
	</ul>
</div>
