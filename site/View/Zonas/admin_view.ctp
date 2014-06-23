<div class="zonas view">
<h2><?php echo __('Zona'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($zona['Zona']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Name'); ?></dt>
		<dd>
			<?php echo h($zona['Zona']['name']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Id Tag Template'); ?></dt>
		<dd>
			<?php echo h($zona['Zona']['id_tag_template']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Sites'); ?></dt>
		<dd>
			<?php echo $this->Html->link($zona['Sites']['name'], array('controller' => 'sites', 'action' => 'view', $zona['Sites']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Created'); ?></dt>
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
			<th><?php echo __('Name'); ?></th>
			<th><?php echo __('Status'); ?></th>
			<th><?php echo __('Created'); ?></th>
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
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Zona'), array('action' => 'edit', $zona['Zona']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Zona'), array('action' => 'delete', $zona['Zona']['id']), null, __('Are you sure you want to delete # %s?', $zona['Zona']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Zonas'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Zona'), array('action' => 'add')); ?> </li>
		<li>&nbsp;</li>
		<li><?php echo $this->Html->link(__('List Sites'), array('controller' => 'sites', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Sites'), array('controller' => 'sites', 'action' => 'add')); ?> </li>
		<li>&nbsp;</li>
		<li><?php echo $this->Html->link(__('List Ad Units'), array('controller' => 'ad_units', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Ad Unit'), array('controller' => 'ad_units', 'action' => 'add')); ?> </li>
	</ul>
</div>
