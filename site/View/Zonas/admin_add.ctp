<div class="zonas form">
<?php echo $this->Form->create('Zona'); ?>
	<fieldset>
		<legend><?php echo __('Nueva Zona'); ?></legend>
	<?php
		echo $this->Form->input('name', array('label' => 'Nombre'));
		echo $this->Form->input('id_tag_template', array('label' => 'ID Tag Template'));
		echo $this->Form->input('adunit', array('class' => 'adunit_sel_single'));
		echo $this->Form->input('adunit_name', array('type' => 'hidden'));
		echo $this->Form->input('site', array('label' => 'Sitio'));
	?>
	</fieldset>
<?php echo $this->Form->end(__('Guardar')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Acciones'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('Lista Zonas'), array('action' => 'index')); ?></li>
		<li><?php echo $this->Html->link(__('Lista Sitios'), array('controller' => 'sites', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('Nuevo Sitio'), array('controller' => 'sites', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('Lista Ad Units'), array('controller' => 'ad_units', 'action' => 'index')); ?> </li>
		<!--<li><?php echo $this->Html->link(__('New Ad Unit'), array('controller' => 'ad_units', 'action' => 'add')); ?> </li>-->
	</ul>
</div>
