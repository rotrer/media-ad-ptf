<div class="adUnits form">
<?php echo $this->Form->create('AdUnit'); ?>
	<fieldset>
		<legend><?php echo __('Admin Add Ad Unit'); ?></legend>
	<?php
		echo $this->Form->input('dfp_id');
		echo $this->Form->input('name');
		echo $this->Form->input('sizes');
		echo $this->Form->input('Zona');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('List Ad Units'), array('action' => 'index')); ?></li>
		<li><?php echo $this->Html->link(__('List Zonas'), array('controller' => 'zonas', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Zona'), array('controller' => 'zonas', 'action' => 'add')); ?> </li>
	</ul>
</div>
