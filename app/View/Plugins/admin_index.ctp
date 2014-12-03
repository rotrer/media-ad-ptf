<h2 class="sub-header"><?php echo __('Plugins'); ?></h2>
<div class="table-responsive">
	<table class="table table-striped">
		<thead>
			<tr>
				<th><?php echo $this->Paginator->sort('name', 'Nombre'); ?></th>
				<th><?php echo $this->Paginator->sort('version', 'Versión'); ?></th>
				<th><?php echo $this->Paginator->sort('public_key', 'Llave pública'); ?></th>
				<th><?php echo $this->Paginator->sort('sites_id', 'Sitio Asociado'); ?></th>
				<th><?php echo $this->Paginator->sort('created', 'Fecha registro'); ?></th>
				<th class="actions"><?php echo __('Acciones'); ?></th>
			</tr>
		</thead>
		<tbody>
			<?php foreach ($plugins as $plugin): ?>
			<tr>
				<td><?php echo h($plugin['Plugin']['name']); ?>&nbsp;</td>
				<td><?php echo h($plugin['Plugin']['version']); ?>&nbsp;</td>
				<td><?php echo h($plugin['Plugin']['public_key']); ?>&nbsp;</td>
				<td><?php echo $this->Html->link($plugin['Sites']['name'], array('controller' => 'sites', 'action' => 'view', $plugin['Sites']['id'])); ?>&nbsp;</td>
				<td><?php echo date('d-m-Y', strtotime($plugin['Plugin']['created'])); ?>&nbsp;</td>
				<td>
					<div class="btn-group">
						<?php echo $this->Html->link(__('Más'), array('controller' => 'plugins', 'action' => 'more', $plugin['Plugin']['id']), array('class' => 'btn btn-default', 'role' => 'button')); ?>
						<?php echo $this->Html->link(__('Ver'), array('action' => 'view', $plugin['Plugin']['id']), array('class' => 'btn btn-default', 'role' => 'button')); ?>
						<?php echo $this->Html->link(__('Editar'), array('action' => 'edit', $plugin['Plugin']['id']), array('class' => 'btn btn-default', 'role' => 'button')); ?>
						<?php echo $this->Form->postLink(__('Eliminar'), array('action' => 'delete', $plugin['Plugin']['id']), array('class' => 'btn btn-danger', 'role' => 'button'), __('Seguro desea eliminar %s?', $plugin['Plugin']['name'])); ?>
					</div>
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