<div class="zonas form">
<?php echo $this->Form->create('Zona'); ?>
	<fieldset>
		<legend><?php echo __('Admin Edit Zona'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('name');
		echo $this->Form->input('id_tag_template');
		echo $this->Form->input('sites_id');
		echo $this->Form->input('created');
		echo $this->Form->input('AdUnit', array('type' => 'select'));
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $this->Form->value('Zona.id')), null, __('Are you sure you want to delete # %s?', $this->Form->value('Zona.id'))); ?></li>
		<li><?php echo $this->Html->link(__('List Zonas'), array('action' => 'index')); ?></li>
		<li><?php echo $this->Html->link(__('List Sites'), array('controller' => 'sites', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Sites'), array('controller' => 'sites', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Ad Units'), array('controller' => 'ad_units', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Ad Unit'), array('controller' => 'ad_units', 'action' => 'add')); ?> </li>
	</ul>
</div>
