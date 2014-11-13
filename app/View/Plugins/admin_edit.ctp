<div class="plugins form">
<?php echo $this->Form->create('Plugin'); ?>
	<fieldset>
		<legend><?php echo __('Admin Edit Plugin'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('sites_id');
		echo $this->Form->input('AdOrder');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $this->Form->value('Plugin.id')), array(), __('Are you sure you want to delete # %s?', $this->Form->value('Plugin.id'))); ?></li>
		<li><?php echo $this->Html->link(__('List Plugins'), array('action' => 'index')); ?></li>
		<li><?php echo $this->Html->link(__('List Sites'), array('controller' => 'sites', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Sites'), array('controller' => 'sites', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Ad Orders'), array('controller' => 'ad_orders', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Ad Order'), array('controller' => 'ad_orders', 'action' => 'add')); ?> </li>
	</ul>
</div>