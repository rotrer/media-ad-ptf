<div class="plugins view">
<h2><?php echo __('Plugin'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($plugin['Plugin']['id']); ?>
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
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Plugin'), array('action' => 'edit', $plugin['Plugin']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Plugin'), array('action' => 'delete', $plugin['Plugin']['id']), array(), __('Are you sure you want to delete # %s?', $plugin['Plugin']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Plugins'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Plugin'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Sites'), array('controller' => 'sites', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Sites'), array('controller' => 'sites', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Ad Orders'), array('controller' => 'ad_orders', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Ad Order'), array('controller' => 'ad_orders', 'action' => 'add')); ?> </li>
	</ul>
</div>
<div class="related">
	<h3><?php echo __('Related Ad Orders'); ?></h3>
	<?php if (!empty($plugin['AdOrder'])): ?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php echo __('Id'); ?></th>
		<th><?php echo __('Name'); ?></th>
		<th><?php echo __('Status'); ?></th>
		<th><?php echo __('Created'); ?></th>
		<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php foreach ($plugin['AdOrder'] as $adOrder): ?>
		<tr>
			<td><?php echo $adOrder['id']; ?></td>
			<td><?php echo $adOrder['name']; ?></td>
			<td><?php echo $adOrder['status']; ?></td>
			<td><?php echo $adOrder['created']; ?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View'), array('controller' => 'ad_orders', 'action' => 'view', $adOrder['id'])); ?>
				<?php echo $this->Html->link(__('Edit'), array('controller' => 'ad_orders', 'action' => 'edit', $adOrder['id'])); ?>
				<?php echo $this->Form->postLink(__('Delete'), array('controller' => 'ad_orders', 'action' => 'delete', $adOrder['id']), array(), __('Are you sure you want to delete # %s?', $adOrder['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New Ad Order'), array('controller' => 'ad_orders', 'action' => 'add')); ?> </li>
		</ul>
	</div>
</div>
