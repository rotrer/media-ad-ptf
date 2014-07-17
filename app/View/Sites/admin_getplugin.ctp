<div class="zonas form">
	<h2><?php echo __('Descargar Plugin'); ?></h2>
	<div class="actions">
		<?php echo $this->Html->link('Descarga aquí', array('controller' => 'sites', 'action' => 'descarga', 'admin' => true, $site_id)); ?>
	</div>
</div>
<div class="actions">
	<h3><?php echo __('Acciones'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Lista Sitios'), array('controller' => 'sites', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('Nuevo Sitio'), array('controller' => 'sites', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('Lista Usuarios'), array('controller' => 'users', 'action' => 'index')); ?> </li>
	</ul>
</div>
