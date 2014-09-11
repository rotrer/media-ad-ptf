<div class="zonas form">
	<?php echo $this->Form->create('Site', array('controller' => 'sites', 'action' => 'descarga', 'admin' => true)); ?>
	<fieldset>
		<h4>Descargar plugin para sitio: <?php echo $site['Site']['domain']; ?> </h4>
		<legend><?php echo __('Plugin'); ?></legend>
			<?php echo $this->Form->input('site_id', array('type' => 'hidden', 'value' => $site_id)); ?>
			<?php echo $this->Form->input('unq', array('type' => 'checkbox', 'value' => 1, 'label' => 'Habilitar solicitud única')); ?>
			<?php echo $this->Form->input('sync', array('type' => 'checkbox', 'value' => 1, 'label' => 'Habilitar la solicitud síncronica')); ?>
	<fieldset>
	<?php echo $this->Form->end(__('Descargar aquí')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Acciones'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Lista Sitios'), array('controller' => 'sites', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('Nuevo Sitio'), array('controller' => 'sites', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('Lista Usuarios'), array('controller' => 'users', 'action' => 'index')); ?> </li>
	</ul>
</div>