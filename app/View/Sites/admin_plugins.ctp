<h2 class="sub-header"><?php echo __('Plugins'); ?></h2>
<div class="table-responsive">
	<table class="table table-striped">
		<?php if($plugins): ?>
		<thead>
			<tr>
				<th>Nombre</th>
				<th>Sitio Asociado</th>
				<th>Fecha registro</th>
				<th class="actions"><?php echo __('Acciones'); ?></th>
			</tr>
		</thead>
		<?php endif; ?>
		<tbody>
			<?php if($plugins): foreach ($plugins as $plugin): ?>
			<tr>
				<td><?php echo h($plugin['Plugin']['name']); ?>&nbsp;</td>
				<td><?php echo $this->Html->link($plugin['Sites']['name'], array('controller' => 'sites', 'action' => 'view', $plugin['Sites']['id'])); ?>&nbsp;</td>
				<td><?php echo date('d-m-Y', strtotime($plugin['Plugin']['created'])); ?>&nbsp;</td>
				<td>
					<div class="btn-group">
						<?php echo $this->Html->link(__('Descargar'), array('controller' => 'plugins', 'action' => 'download', $plugin['Plugin']['id']), array('class' => 'btn btn-default', 'role' => 'button')); ?>
						<?php echo $this->Html->link(__('Ver'), array('action' => 'view', $plugin['Plugin']['id']), array('class' => 'btn btn-default', 'role' => 'button')); ?>
						<?php echo $this->Html->link(__('Editar'), array('action' => 'edit', $plugin['Plugin']['id']), array('class' => 'btn btn-default', 'role' => 'button')); ?>
					</div>
				</td>
			</tr>
			<?php endforeach; ?>
			<?php else: ?>
			<tr>
				<td>
					<h3 class="alert alert-info">No hay plugins asociados a este sitio.</h3>
				</td>
			</tr>
			<?php endif; ?>
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