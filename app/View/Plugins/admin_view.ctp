<div>
<legend><?php echo __('Plugin'); ?></legend>
	<dl class="dl-horizontal">
		<dt><?php echo __('Nombre'); ?></dt>
		<dd>
			<?php echo h($plugin['Plugin']['name']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Sites'); ?></dt>
		<dd>
			<?php echo $this->Html->link($plugin['Sites']['name'], array('controller' => 'sites', 'action' => 'view', $plugin['Sites']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Created'); ?></dt>
		<dd>
			<?php echo h($plugin['Plugin']['created']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="related">
	<legend><?php echo __('Zonas'); ?></legend>
	<div class="table-responsive">
		<?php if (!empty($zonasLineInfo)): ?>
		<table cellpadding = "0" cellspacing = "0" class="table table-striped">
		<tr>
			<th><?php echo __('Zona Nombre'); ?></th>
			<th><?php echo __('Zona Tag'); ?></th>
			<th><?php echo __('Adunit Nombre'); ?></th>
			<th><?php echo __('Línea Pedido Nombre'); ?></th>
			<th><?php echo __('Fecha Registro'); ?></th>
			<th class="actions"><?php echo __('Acciones'); ?></th>
		</tr>
		<?php foreach ($zonasLineInfo as $info): ?>
			<tr>
				<td><?php echo $info['Zona']['name']; ?></td>
				<td><?php echo $info['Zona']['id_tag_template']; ?></td>
				<td><?php echo $info['AdUnits']['name']; ?></td>
				<td><?php echo $info['LineItems']['name']; ?></td>
				<td><?php echo date('m-d-Y', strtotime($info['Zona']['created'])); ?></td>
				<td class="actions">
					<div class="btn-group">
						<?php echo $this->Html->link(__('Ver'), array('controller' => 'zonas', 'action' => 'view', $info['Zona']['id']), array('class' => 'btn btn-default', 'role' => 'button')); ?>
						<?php echo $this->Html->link(__('Editar'), array('controller' => 'zonas', 'action' => 'edit', $info['Zona']['id']), array('class' => 'btn btn-default', 'role' => 'button')); ?>
						<?php echo $this->Form->postLink(__('Eliminar'), array('controller' => 'zonas', 'action' => 'delete', $info['Zona']['id']), array('class' => 'btn btn-danger', 'role' => 'button'), __('Seguro desea eliminar %s?', $info['Zona']['name'])); ?>
					</div>
				</td>
			</tr>
		<?php endforeach; ?>
		</table>
		<?php endif; ?>
	</div>
</div>
