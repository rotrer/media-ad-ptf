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
					<?php echo $this->Html->link(__('Ver'), array('controller' => 'zonas', 'action' => 'view', $zona['Zona']['id'])); ?>
					<?php echo $this->Html->link(__('Editar'), array('controller' => 'zonas', 'action' => 'edit', $zona['Zona']['id'])); ?>
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
		<li><?php echo $this->Html->link(__('Editar Sitio'), array('action' => 'edit', $site['Site']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Eliminar Sitio'), array('action' => 'delete', $site['Site']['id']), null, __('Seguro desea eliminar %s?', $site['Site']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('Listar Sitios'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('Nuevo Sitio'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('Lista Usuarios'), array('controller' => 'users', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('Nuevo Ususario'), array('controller' => 'users', 'action' => 'add')); ?> </li>
	</ul>
</div>
<div class="related">
	<h3><?php echo __('Usuarios Relacionados'); ?></h3>
	<?php if (!empty($site['User'])): ?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php echo __('Id'); ?></th>
		<th><?php echo __('Nombre'); ?></th>
		<th><?php echo __('Email'); ?></th>
		<th><?php echo __('Rol'); ?></th>
		<th><?php echo __('Estado'); ?></th>
		<th><?php echo __('Fecha Registro'); ?></th>
		<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php foreach ($site['User'] as $user): ?>
		<tr>
			<td><?php echo $user['id']; ?></td>
			<td><?php echo $user['name']; ?></td>
			<td><?php echo $user['email']; ?></td>
			<td><?php echo $user['role']; ?></td>
			<td><?php echo $user['state']; ?></td>
			<td><?php echo date('d-m-Y', strtotime($user['created'])); ?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('Ver'), array('controller' => 'users', 'action' => 'view', $user['id'])); ?>
				<?php echo $this->Html->link(__('Editar'), array('controller' => 'users', 'action' => 'edit', $user['id'])); ?>
				<?php echo $this->Form->postLink(__('Eliminar'), array('controller' => 'users', 'action' => 'delete', $user['id']), null, __('Seguro desea eliminar a %s?', $user['name'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>
</div>
