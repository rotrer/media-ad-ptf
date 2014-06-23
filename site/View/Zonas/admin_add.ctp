<div class="zonas form">
<?php echo $this->Form->create('Zona'); ?>
	<fieldset>
		<legend><?php echo __('Admin Add Site'); ?></legend>
	<?php
		echo $this->Form->input('name');
		echo $this->Form->input('id_tag_template');
		echo $this->Form->input('adunit', array('class' => 'adunit_sel_single'));
		echo $this->Form->input('adunit_name', array('type' => 'hidden'));
		echo $this->Form->input('site');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Continuar')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('List Zonas'), array('action' => 'index')); ?></li>
		<li><?php echo $this->Html->link(__('List Sites'), array('controller' => 'sites', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Sites'), array('controller' => 'sites', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Ad Units'), array('controller' => 'ad_units', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Ad Unit'), array('controller' => 'ad_units', 'action' => 'add')); ?> </li>
	</ul>
</div>
