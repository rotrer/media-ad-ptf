<h2 class="sub-header"><?php echo __('Usuarios'); ?></h2>
<div class="table-responsive">
	<table class="table table-striped">
		<thead>
			<tr>
				<th><?php echo $this->Paginator->sort('name', 'Nombre'); ?></th>
				<th><?php echo $this->Paginator->sort('email'); ?></th>
				<th><?php echo $this->Paginator->sort('role', 'Rol'); ?></th>
				<th><?php echo $this->Paginator->sort('state', 'Estado'); ?></th>
				<th><?php echo $this->Paginator->sort('first_login', 'Validado'); ?></th>
				<th><?php echo $this->Paginator->sort('created', 'Usuario Desde'); ?></th>
				<th class="actions"><?php echo __('Acciones'); ?></th>
			</tr>
		</thead>
		<tbody>
			<?php foreach ($users as $user): ?>
			<tr>
				<td><?php echo h($user['User']['name']); ?>&nbsp;</td>
				<td><?php echo h($user['User']['email']); ?>&nbsp;</td>
				<td><?php echo h($user['User']['role']); ?>&nbsp;</td>
				<td><?php echo h($user['User']['state']); ?>&nbsp;</td>
				<td><?php echo ($user['User']['first_login']) ? 'SÍ' : 'NO'; ?>&nbsp;</td>
				<td><?php echo date('d-m-Y', strtotime($user['User']['created'])); ?>&nbsp;</td>
				<td class="actions">
					<div class="btn-group">
					  <?php echo $this->Html->link(__('Ver'), array('action' => 'view', $user['User']['id']), array('class' => 'btn btn-default', 'role' => 'button')); ?>
						<?php echo $this->Html->link(__('Editar'), array('action' => 'edit', $user['User']['id']), array('class' => 'btn btn-default', 'role' => 'button')); ?>
						<?php if ($user['User']['can_be_deleted']) { ?>
							<?php echo $this->Form->postLink(__('Eliminar'), array('action' => 'delete', $user['User']['id']), array('class' => 'btn btn-danger', 'role' => 'button'), __('Seguro desea eliminar a %s?', $user['User']['name'])); ?>
						<?php } ?>
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