<div class="zonas form">
<?php echo $this->Form->create('Zona'); ?>
	<fieldset>
		<legend><?php echo __('Editar Zona'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('name', array('label' => 'Nombre'));
		echo $this->Form->input('id_tag_template', array('label' => 'ID Tag Template'));
		echo $this->Form->input('sites_id', array('label' => 'Sitio'));
		echo $this->Form->input('created', array('type' => 'hidden'));
		echo $this->Form->input('AdUnit', array('type' => 'select'));
	?>
	</fieldset>
<?php echo $this->Form->end(__('Guardar')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Acciones'); ?></h3>
	<ul>

		<li><?php echo $this->Form->postLink(__('Eliminar'), array('action' => 'delete', $this->Form->value('Zona.id')), null, __('Seguro desea eliminar %s?', $this->Form->value('Zona.name'))); ?></li>
		<li><?php echo $this->Html->link(__('Lista Zonas'), array('action' => 'index')); ?></li>
		<li><?php echo $this->Html->link(__('Lista Sitios'), array('controller' => 'sites', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('Nuevo Sitio'), array('controller' => 'sites', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('Lista Ad Units'), array('controller' => 'ad_units', 'action' => 'index')); ?> </li>
		<!--<li><?php echo $this->Html->link(__('New Ad Unit'), array('controller' => 'ad_units', 'action' => 'add')); ?> </li>-->
	</ul>
</div>
