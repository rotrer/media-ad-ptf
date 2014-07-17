<div class="adUnits view">
<h2><?php echo __('Ad Unit'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($adUnit['AdUnit']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Name'); ?></dt>
		<dd>
			<?php echo h($adUnit['AdUnit']['name']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Status'); ?></dt>
		<dd>
			<?php echo h($adUnit['AdUnit']['status']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Created'); ?></dt>
		<dd>
			<?php echo h($adUnit['AdUnit']['created']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Form->postLink(__('Eliminar Ad Unit'), array('action' => 'delete', $adUnit['AdUnit']['id']), null, __('Seguro desea eliminar # %s?', $adUnit['AdUnit']['name'])); ?> </li>
		<li><?php echo $this->Html->link(__('Lista Ad Units'), array('action' => 'index')); ?> </li>
		<!--<li><?php echo $this->Html->link(__('New Ad Unit'), array('action' => 'add')); ?> </li>-->
		<li><?php echo $this->Html->link(__('Lista Zonas'), array('controller' => 'zonas', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('Nueva Zona'), array('controller' => 'zonas', 'action' => 'add')); ?> </li>
	</ul>
</div>
<div class="related">
	<h3><?php echo __('Zonas Relacionadas'); ?></h3>
	<?php if (!empty($adUnit['Zona'])): ?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php echo __('Nombre'); ?></th>
		<th><?php echo __('Id Tag Template'); ?></th>
		<th><?php echo __('Sitio'); ?></th>
		<th><?php echo __('Fecha Registro'); ?></th>
		<th class="actions"><?php echo __('Acciones'); ?></th>
	</tr>
	<?php foreach ($adUnit['Zona'] as $zona): ?>
		<tr>
			<td><?php echo $this->Html->link($zona['name'], array('controller' => 'zonas', 'action' => 'view', $zona['id'], 'admin' => true)); ?></td>
			<td><?php echo $zona['id_tag_template']; ?></td>
			<td><?php echo $this->Html->link($zona['sites_name'], array('controller' => 'sites', 'action' => 'view', $zona['sites_id'], 'admin' => true)); ?></td>
			<td><?php echo date('d-m-Y', strtotime($zona['created'])); ?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('Ver'), array('controller' => 'zonas', 'action' => 'view', $zona['id'])); ?>
				<?php echo $this->Html->link(__('Editar'), array('controller' => 'zonas', 'action' => 'edit', $zona['id'])); ?>
				<?php echo $this->Form->postLink(__('Eliminar'), array('controller' => 'zonas', 'action' => 'delete', $zona['id']), null, __('Seguro desea eliminar %s?', $zona['name'] . ' / ' . $zona['sites_name'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>
</div>
