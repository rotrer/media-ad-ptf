<div>
<legend><?php echo __('Site'); ?></legend>
	<dl class="dl-horizontal">
		<dt><p><?php echo __('Name'); ?></p></dt>
		<dd>
			<p><?php echo h($site['Site']['name']); ?></p>
		</dd>
		<dt><p><?php echo __('Public Key'); ?></p></dt>
		<dd>
			<p><?php echo h($site['Site']['public_key']); ?></p>
		</dd>
		<dt><p><?php echo __('State'); ?></p></dt>
		<dd>
			<p><?php echo h($site['Site']['state']); ?></p>
		</dd>
		<dt><p><?php echo __('Created'); ?></p></dt>
		<dd>
			<p><?php echo h($site['Site']['created']); ?></p>
		</dd>
	</dl>
	<br>
	<legend><?php echo __('Zonas y Adunits'); ?></legend>
	<?php if ($zonasAll){ ?>
	<div class="table-responsive">
		<table cellpadding = "0" cellspacing = "0" class="table table-striped">
			<thead>
				<tr>
					<th><?php echo __('Nombre'); ?></th>
					<th><?php echo __('ID Tag Template'); ?></th>
					<th><?php echo __('Creado'); ?></th>
					<th><?php echo __('Adunit ID'); ?></th>
					<th><?php echo __('Adunit Nombre'); ?></th>
					<th class="actions"><?php echo __('Actions'); ?></th>
				</tr>
			</thead>
			<tbody>
			<?php foreach ($zonasAll as $key => $zona) { ?>
			<tr>
				<td><?php echo $zona['Zona']['name']; ?></td>
				<td><?php echo $zona['Zona']['id_tag_template']; ?></td>
				<td><?php echo $zona['Zona']['created']; ?></td>
				<td><?php echo ($zona['AdUnit']) ? $zona['AdUnit'][0]['id'] : ''; ?></td>
				<td><?php echo ($zona['AdUnit']) ? $zona['AdUnit'][0]['name'] : ''; ?></td>
				<td class="actions">
					<div class="btn-group">
						<?php echo $this->Html->link(__('Ver'), array('controller' => 'zonas', 'action' => 'view', $zona['Zona']['id']), array('class' => 'btn btn-default', 'role' => 'button')); ?>
						<?php echo $this->Html->link(__('Editar'), array('controller' => 'zonas', 'action' => 'edit', $zona['Zona']['id']), array('class' => 'btn btn-default', 'role' => 'button')); ?>
					</div>
				</td>
			</tr>
			<?php } ?>
			</tbody>
		</table>
	</div>
	<?php } else { ?>
	<h4>Sitio no tiene zonas asignadas.</h4>
	<?php } ?>
</div>