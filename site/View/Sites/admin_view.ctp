<div class="sites view">
<h2><?php echo __('Site'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($site['Site']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Name'); ?></dt>
		<dd>
			<?php echo h($site['Site']['name']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Public Key'); ?></dt>
		<dd>
			<?php echo h($site['Site']['public_key']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('State'); ?></dt>
		<dd>
			<?php echo h($site['Site']['state']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Created'); ?></dt>
		<dd>
			<?php echo h($site['Site']['created']); ?>
			&nbsp;
		</dd>
	</dl>
	<br>
	<h3><?php echo __('Zonas y Adunits'); ?></h3>
	<?php if ($zonasAll){ ?>
		<table cellpadding = "0" cellspacing = "0">
			<tr>
				<th><?php echo __('Nombre'); ?></th>
				<th><?php echo __('ID Tag Template'); ?></th>
				<th><?php echo __('Creado'); ?></th>
				<th><?php echo __('Adunit ID'); ?></th>
				<th><?php echo __('Adunit Nombre'); ?></th>
				<th class="actions"><?php echo __('Actions'); ?></th>
			</tr>
		<?php foreach ($zonasAll as $key => $zona) { ?>
			<tr>
				<td><?php echo $zona['Zona']['name']; ?></td>
				<td><?php echo $zona['Zona']['id_tag_template']; ?></td>
				<td><?php echo $zona['Zona']['created']; ?></td>
				<td><?php echo ($zona['AdUnit']) ? $zona['AdUnit'][0]['id'] : ''; ?></td>
				<td><?php echo ($zona['AdUnit']) ? $zona['AdUnit'][0]['name'] : ''; ?></td>
				<td class="actions">
					<?php echo $this->Html->link(__('View'), array('controller' => 'zonas', 'action' => 'view', $zona['Zona']['id'])); ?>
					<?php echo $this->Html->link(__('Edit'), array('controller' => 'zonas', 'action' => 'edit', $zona['Zona']['id'])); ?>
				</td>
			</tr>
		<?php } ?>
		</table>
	<?php } else { ?>
	<h4>Sitio no tiene zonas asignadas.</h4>
	<?php } ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Site'), array('action' => 'edit', $site['Site']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Site'), array('action' => 'delete', $site['Site']['id']), null, __('Are you sure you want to delete # %s?', $site['Site']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Sites'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Site'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Users'), array('controller' => 'users', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New User'), array('controller' => 'users', 'action' => 'add')); ?> </li>
	</ul>
</div>
<div class="related">
	<h3><?php echo __('Related Users'); ?></h3>
	<?php if (!empty($site['User'])): ?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php echo __('Id'); ?></th>
		<th><?php echo __('Name'); ?></th>
		<th><?php echo __('Username'); ?></th>
		<th><?php echo __('Password'); ?></th>
		<th><?php echo __('Email'); ?></th>
		<th><?php echo __('Role'); ?></th>
		<th><?php echo __('State'); ?></th>
		<th><?php echo __('First Login'); ?></th>
		<th><?php echo __('Can Be Deleted'); ?></th>
		<th><?php echo __('Created'); ?></th>
		<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php foreach ($site['User'] as $user): ?>
		<tr>
			<td><?php echo $user['id']; ?></td>
			<td><?php echo $user['name']; ?></td>
			<td><?php echo $user['username']; ?></td>
			<td><?php echo $user['password']; ?></td>
			<td><?php echo $user['email']; ?></td>
			<td><?php echo $user['role']; ?></td>
			<td><?php echo $user['state']; ?></td>
			<td><?php echo $user['first_login']; ?></td>
			<td><?php echo $user['can_be_deleted']; ?></td>
			<td><?php echo $user['created']; ?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View'), array('controller' => 'users', 'action' => 'view', $user['id'])); ?>
				<?php echo $this->Html->link(__('Edit'), array('controller' => 'users', 'action' => 'edit', $user['id'])); ?>
				<?php echo $this->Form->postLink(__('Delete'), array('controller' => 'users', 'action' => 'delete', $user['id']), null, __('Are you sure you want to delete # %s?', $user['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>
</div>
