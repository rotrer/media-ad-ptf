<h2 class="sub-header"><?php echo __('Sitios'); ?></h2>
<div class="table-responsive">
	<table class="table table-striped">
		<thead>
			<tr>
				<!--th><?php echo $this->Paginator->sort('id'); ?></th-->
				<th><?php echo $this->Paginator->sort('name', 'Nombre'); ?></th>
				<th><?php echo $this->Paginator->sort('public_key', 'Llave pública'); ?></th>
				<th><?php echo $this->Paginator->sort('state', 'Estado'); ?></th>
				<th><?php echo $this->Paginator->sort('created', 'Fecha registro'); ?></th>
				<th class="actions"><?php echo __('Acciones'); ?></th>
			</tr>
		</thead>
		<tbody>
			<?php foreach ($sites as $site): ?>
			<tr>
				<!--td><?php echo h($site['Site']['id']); ?>&nbsp;</td-->
				<td><?php echo h($site['Site']['name']); ?>&nbsp;</td>
				<td><?php echo h($site['Site']['public_key']); ?>&nbsp;</td>
				<td><?php echo h($site['Site']['state']); ?>&nbsp;</td>
				<td><?php echo date('d-m-Y', strtotime($site['Site']['created'])); ?>&nbsp;</td>
				<td class="actions">
					<?php echo $this->Html->link(__('Get Plugin'), array('action' => 'getplugin', $site['Site']['id'])); ?>
					<?php echo $this->Html->link(__('Ver'), array('action' => 'view', $site['Site']['id'])); ?>
					<?php echo $this->Html->link(__('Editar'), array('action' => 'edit', $site['Site']['id'])); ?>
					<?php echo $this->Form->postLink(__('Eliminar'), array('action' => 'delete', $site['Site']['id']), null, __('Seguro desea eliminar %s?', $site['Site']['name'])); ?>
				</td>
			</tr>
			<?php endforeach; ?>
		</tbody>
	</table>
</div>
<div class="sites index">
	<h2><?php echo __('Sitios'); ?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<!--th><?php echo $this->Paginator->sort('id'); ?></th-->
			<th><?php echo $this->Paginator->sort('name', 'Nombre'); ?></th>
			<th><?php echo $this->Paginator->sort('public_key', 'Llave pública'); ?></th>
			<th><?php echo $this->Paginator->sort('state', 'Estado'); ?></th>
			<th><?php echo $this->Paginator->sort('created', 'Fecha registro'); ?></th>
			<th class="actions"><?php echo __('Acciones'); ?></th>
	</tr>
	<?php foreach ($sites as $site): ?>
	<tr>
		<!--td><?php echo h($site['Site']['id']); ?>&nbsp;</td-->
		<td><?php echo h($site['Site']['name']); ?>&nbsp;</td>
		<td><?php echo h($site['Site']['public_key']); ?>&nbsp;</td>
		<td><?php echo h($site['Site']['state']); ?>&nbsp;</td>
		<td><?php echo date('d-m-Y', strtotime($site['Site']['created'])); ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('Get Plugin'), array('action' => 'getplugin', $site['Site']['id'])); ?>
			<?php echo $this->Html->link(__('Ver'), array('action' => 'view', $site['Site']['id'])); ?>
			<?php echo $this->Html->link(__('Editar'), array('action' => 'edit', $site['Site']['id'])); ?>
			<?php echo $this->Form->postLink(__('Eliminar'), array('action' => 'delete', $site['Site']['id']), null, __('Seguro desea eliminar %s?', $site['Site']['name'])); ?>
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
		<li><?php echo $this->Html->link(__('Nuevo Sitio'), array('action' => 'add')); ?></li>
		<li><?php echo $this->Html->link(__('Lista de Usuarios'), array('controller' => 'users', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('Nuevo Usuario'), array('controller' => 'users', 'action' => 'add')); ?> </li>
	</ul>
</div>
