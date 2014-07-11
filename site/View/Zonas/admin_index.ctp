<div class="zonas index">
	<h2><?php echo __('Zonas'); ?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('id'); ?></th>
			<th><?php echo $this->Paginator->sort('name', 'Nombre'); ?></th>
			<th><?php echo $this->Paginator->sort('id_tag_template', 'ID Tag Template'); ?></th>
			<th><?php echo $this->Paginator->sort('sites_id', 'Sitio'); ?></th>
			<th><?php echo $this->Paginator->sort('created', 'Fecha Registro'); ?></th>
			<th class="actions"><?php echo __('Acciones'); ?></th>
	</tr>
	<?php foreach ($zonas as $zona): ?>
	<tr>
		<td><?php echo h($zona['Zona']['id']); ?>&nbsp;</td>
		<td><?php echo h($zona['Zona']['name']); ?>&nbsp;</td>
		<td><?php echo h($zona['Zona']['id_tag_template']); ?>&nbsp;</td>
		<td>
			<?php echo $this->Html->link($zona['Sites']['name'], array('controller' => 'sites', 'action' => 'view', $zona['Sites']['id'])); ?>
		</td>
		<td><?php echo date('d-m-Y', strtotime($zona['Zona']['created'])); ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('Ver'), array('action' => 'view', $zona['Zona']['id'])); ?>
			<?php echo $this->Html->link(__('Editar'), array('action' => 'edit', $zona['Zona']['id'])); ?>
			<?php echo $this->Form->postLink(__('Eliminar'), array('action' => 'delete', $zona['Zona']['id']), null, __('Seguro desea eliminar %s?', $zona['Zona']['name'] . ' / ' . $zona['Sites']['name'])); ?>
		</td>
	</tr>
<?php endforeach; ?>
	</table>
	<p>
	<?php
	echo $this->Paginator->counter(array(
	'format' => __('Página {:page} de {:pages}, mostrando {:current} registro de {:count} total, empieza con {:start}, finaliza con {:end}')
	));
	?>	</p>
	<div class="paging">
	<?php
		echo $this->Paginator->prev('< ' . __('anterior'), array(), null, array('class' => 'prev disabled'));
		echo $this->Paginator->numbers(array('separator' => ''));
		echo $this->Paginator->next(__('siguiente') . ' >', array(), null, array('class' => 'next disabled'));
	?>
	</div>
</div>
<div class="actions">
	<h3><?php echo __('Acciones'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Nueva Zona'), array('action' => 'add')); ?></li>
		<li><?php echo $this->Html->link(__('Lista Sitios'), array('controller' => 'sites', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('Nuevo Sitios'), array('controller' => 'sites', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('Lista Ad Units'), array('controller' => 'ad_units', 'action' => 'index')); ?> </li>
		<!--<li><?php echo $this->Html->link(__('New Ad Unit'), array('controller' => 'ad_units', 'action' => 'add')); ?> </li>-->
	</ul>
</div>
