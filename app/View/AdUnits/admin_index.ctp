<div class="adUnits index">
	<h2><?php echo __('Ad Units'); ?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('id'); ?></th>
			<th><?php echo $this->Paginator->sort('name', 'Nombre'); ?></th>
			<th><?php echo $this->Paginator->sort('created', 'Fecha Registro'); ?></th>
			<th class="actions"><?php echo __('Acciones'); ?></th>
	</tr>
	<?php foreach ($adUnits as $adUnit): ?>
	<tr>
		<td><?php echo h($adUnit['AdUnit']['id']); ?>&nbsp;</td>
		<td><?php echo h($adUnit['AdUnit']['name']); ?>&nbsp;</td>
		<td><?php echo date('d-m-Y', strtotime($adUnit['AdUnit']['created'])); ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('Ver'), array('action' => 'view', $adUnit['AdUnit']['id'])); ?>
			<?php echo $this->Form->postLink(__('Eliminar'), array('action' => 'delete', $adUnit['AdUnit']['id']), null, __('Seguro desea eliminar %s?', $adUnit['AdUnit']['name'])); ?>
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
		<!--li><?php echo $this->Html->link(__('Nuevo AdUnit'), array('action' => 'add')); ?></li-->
		<li><?php echo $this->Html->link(__('Lista Zonas'), array('controller' => 'zonas', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('Nueva Zona'), array('controller' => 'zonas', 'action' => 'add')); ?> </li>
	</ul>
</div>
