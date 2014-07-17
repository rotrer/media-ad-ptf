<div class="zonas view">
<h2><?php echo __('Zona'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($zona['Zona']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Nombre'); ?></dt>
		<dd>
			<?php echo h($zona['Zona']['name']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Id Tag Template'); ?></dt>
		<dd>
			<?php echo h($zona['Zona']['id_tag_template']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Sitio'); ?></dt>
		<dd>
			<?php echo $this->Html->link($zona['Sites']['name'], array('controller' => 'sites', 'action' => 'view', $zona['Sites']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Fecha Registro'); ?></dt>
		<dd>
			<?php echo h($zona['Zona']['created']); ?>
			&nbsp;
		</dd>
	</dl>
	<br>
	<div class="related">
		<h3><?php echo __('Ad Units'); ?></h3>
		<?php if (!empty($zona['AdUnit'])): ?>
		<table cellpadding = "0" cellspacing = "0">
		<tr>
			<th><?php echo __('Id'); ?></th>
			<th><?php echo __('Nombre'); ?></th>
			<th><?php echo __('Estado'); ?></th>
			<th><?php echo __('Fecha Resgistro'); ?></th>
			<!--th class="actions"><?php echo __('Actions'); ?></th-->
		</tr>
		<?php foreach ($zona['AdUnit'] as $adUnit): ?>
			<tr>
				<td><?php echo $adUnit['id']; ?></td>
				<td><?php echo $adUnit['name']; ?></td>
				<td><?php echo $adUnit['status']; ?></td>
				<td><?php echo $adUnit['created']; ?></td>
				<!--td class="actions">
					<?php echo $this->Html->link(__('View'), array('controller' => 'ad_units', 'action' => 'view', $adUnit['id'])); ?>
					<?php echo $this->Html->link(__('Edit'), array('controller' => 'ad_units', 'action' => 'edit', $adUnit['id'])); ?>
					<?php echo $this->Form->postLink(__('Delete'), array('controller' => 'ad_units', 'action' => 'delete', $adUnit['id']), null, __('Are you sure you want to delete # %s?', $adUnit['id'])); ?>
				</td-->
			</tr>
		<?php endforeach; ?>
		</table>
	<?php endif; ?>
	</div>
</div>
<div class="actions">
	<h3><?php echo __('Acciones'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Editar Zona'), array('action' => 'edit', $zona['Zona']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Eliminar Zona'), array('action' => 'delete', $zona['Zona']['id']), null, __('Seguro desea eliminar %s?', $zona['Zona']['name'])); ?> </li>
		<li><?php echo $this->Html->link(__('Lista Zonas'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('Nueva Zona'), array('action' => 'add')); ?> </li>
		<li>&nbsp;</li>
		<li><?php echo $this->Html->link(__('Lista Sitios'), array('controller' => 'sites', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('Nuevo Sitio'), array('controller' => 'sites', 'action' => 'add')); ?> </li>
		<!--<li>&nbsp;</li>
		<li><?php echo $this->Html->link(__('Lista Ad Units'), array('controller' => 'ad_units', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Ad Unit'), array('controller' => 'ad_units', 'action' => 'add')); ?> </li>-->
	</ul>
</div>
