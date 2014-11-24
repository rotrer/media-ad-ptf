<div>
	<legend><?php echo __('Zonas'); ?></legend>
	<table cellpadding="0" cellspacing="0" class="table table-striped">
	<tr>
			<th><?php echo $this->Paginator->sort('id'); ?></th>
			<th><?php echo $this->Paginator->sort('name', 'Nombre'); ?></th>
			<th><?php echo $this->Paginator->sort('id_tag_template', 'ID Tag Template'); ?></th>
			<th><?php echo $this->Paginator->sort('out_of_page', 'Out of Page'); ?></th>
			<th><?php echo $this->Paginator->sort('plugins_id', 'Plugin'); ?></th>
			<th><?php echo $this->Paginator->sort('created', 'Fecha Registro'); ?></th>
			<th class="actions"><?php echo __('Acciones'); ?></th>
	</tr>
	<?php foreach ($zonas as $zona): ?>
	<tr>
		<td><?php echo h($zona['Zona']['id']); ?>&nbsp;</td>
		<td><?php echo h($zona['Zona']['name']); ?>&nbsp;</td>
		<td><?php echo h($zona['Zona']['id_tag_template']); ?>&nbsp;</td>
		<td><?php echo ($zona['Zona']['out_of_page']) ? 'Sí' : 'No'; ?>&nbsp;</td>
		<td>
			<?php echo $this->Html->link($zona['Plugins']['name'], array('controller' => 'plugins', 'action' => 'view', $zona['Plugins']['id'])); ?>
		</td>
		<td><?php echo date('d-m-Y', strtotime($zona['Zona']['created'])); ?>&nbsp;</td>
		<td class="actions">
			<div class="btn-group">
				<?php echo $this->Html->link(__('Ver'), array('action' => 'view', $zona['Zona']['id']), array('class' => 'btn btn-default', 'role' => 'button')); ?>
				<?php echo $this->Html->link(__('Editar'), array('action' => 'edit', $zona['Zona']['id']), array('class' => 'btn btn-default', 'role' => 'button')); ?>
				<?php echo $this->Form->postLink(__('Eliminar'), array('action' => 'delete', $zona['Zona']['id']), array('class' => 'btn btn-danger', 'role' => 'button'), __('Seguro desea eliminar %s?', $zona['Zona']['name'] . ' / ' . $zona['Plugins']['name'])); ?>
			</div>
		</td>
	</tr>
<?php endforeach; ?>
	</table>
	<nav>
	  <ul class="pager">
	    <li><?php echo $this->Paginator->prev('< ' . __('Anterior'), array(), null, array('class' => 'prev disabled')); ?></li>
	    <!-- <li><?php #echo $this->Paginator->numbers(array('separator' => '')); ?></li> -->
	    <li><?php echo $this->Paginator->next(__('Siguiente') . ' >', array(), null, array('class' => 'next disabled')); ?></li>
	  </ul>
	</nav>
</div>