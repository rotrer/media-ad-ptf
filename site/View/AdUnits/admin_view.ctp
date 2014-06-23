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
		<li><?php echo $this->Form->postLink(__('Delete Ad Unit'), array('action' => 'delete', $adUnit['AdUnit']['id']), null, __('Are you sure you want to delete # %s?', $adUnit['AdUnit']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Ad Units'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Ad Unit'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Zonas'), array('controller' => 'zonas', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Zona'), array('controller' => 'zonas', 'action' => 'add')); ?> </li>
	</ul>
</div>
<div class="related">
	<h3><?php echo __('Related Zonas'); ?></h3>
	<?php if (!empty($adUnit['Zona'])): ?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php echo __('Id'); ?></th>
		<th><?php echo __('Name'); ?></th>
		<th><?php echo __('Id Tag Template'); ?></th>
		<th><?php echo __('Sites Id'); ?></th>
		<th><?php echo __('Created'); ?></th>
		<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php foreach ($adUnit['Zona'] as $zona): ?>
		<tr>
			<td><?php echo $zona['id']; ?></td>
			<td><?php echo $zona['name']; ?></td>
			<td><?php echo $zona['id_tag_template']; ?></td>
			<td><?php echo $zona['sites_id']; ?></td>
			<td><?php echo $zona['created']; ?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View'), array('controller' => 'zonas', 'action' => 'view', $zona['id'])); ?>
				<?php echo $this->Html->link(__('Edit'), array('controller' => 'zonas', 'action' => 'edit', $zona['id'])); ?>
				<?php echo $this->Form->postLink(__('Delete'), array('controller' => 'zonas', 'action' => 'delete', $zona['id']), null, __('Are you sure you want to delete # %s?', $zona['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>
</div>
