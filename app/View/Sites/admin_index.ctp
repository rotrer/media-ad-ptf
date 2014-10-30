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
				<td>
					<?php echo $this->Html->link(__('Get Plugin'), array('action' => 'getplugin', $site['Site']['id']), array('class' => 'btn btn-default', 'role' => 'button')); ?>
					<?php echo $this->Html->link(__('Ver'), array('action' => 'view', $site['Site']['id']), array('class' => 'btn btn-default', 'role' => 'button')); ?>
					<?php echo $this->Html->link(__('Editar'), array('action' => 'edit', $site['Site']['id']), array('class' => 'btn btn-default', 'role' => 'button')); ?>
					<?php echo $this->Form->postLink(__('Eliminar'), array('action' => 'delete', $site['Site']['id']), array('class' => 'btn btn-default', 'role' => 'button'), __('Seguro desea eliminar %s?', $site['Site']['name'])); ?>
				</td>
			</tr>
			<?php endforeach; ?>
		</tbody>
	</table>
	<!-- <p>
	<?php
	echo $this->Paginator->counter(array(
	'format' => __('Página {:page} de {:pages}, mostrando {:current} registro de {:count} total, empieza con {:start}, finaliza con {:end}')
	));
	?>	</p> -->
	<nav>
	  <ul class="pager">
	    <li><?php echo $this->Paginator->prev('< ' . __('Anterior'), array(), null, array('class' => 'prev disabled')); ?></li>
	    <!-- <li><?php #echo $this->Paginator->numbers(array('separator' => '')); ?></li> -->
	    <li><?php echo $this->Paginator->next(__('Siguiente') . ' >', array(), null, array('class' => 'next disabled')); ?></li>
	  </ul>
	</nav>
	<div class="paging">
	
	</div>
</div>