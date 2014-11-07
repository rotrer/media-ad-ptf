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
	<legend><?php echo __('Plugins'); ?></legend>
	<?php if ($pluginsAll){ ?>
	<div class="table-responsive">
		<table cellpadding = "0" cellspacing = "0" class="table table-striped">
			<thead>
				<tr>
					<th><?php echo __('Nombre'); ?></th>
					<th><?php echo __('Creado'); ?></th>
					<th class="actions"><?php echo __('Actions'); ?></th>
				</tr>
			</thead>
			<tbody>
			<?php foreach ($pluginsAll as $key => $plugin) { ?>
			<tr>
				<td><?php echo $plugin['Plugin']['name']; ?></td>
				<td><?php echo $plugin['Plugin']['created']; ?></td>
				<td class="actions">
					<div class="btn-group">
						<?php echo $this->Html->link(__('Ver'), array('controller' => 'zonas', 'action' => 'view', $plugin['Plugin']['id']), array('class' => 'btn btn-default', 'role' => 'button')); ?>
						<?php echo $this->Html->link(__('Editar'), array('controller' => 'zonas', 'action' => 'edit', $plugin['Plugin']['id']), array('class' => 'btn btn-default', 'role' => 'button')); ?>
					</div>
				</td>
			</tr>
			<?php } ?>
			</tbody>
		</table>
	</div>
	<?php } else { ?>
	<h4>Sitio no tiene plugins asignados.</h4>
	<div class="btn-group">
		<?php echo $this->Html->link(__('Agregar Plugin'), array('controller' => 'plugins', 'action' => 'add'), array('class' => 'btn btn-default', 'role' => 'button')); ?>
	</div>
	<?php } ?>
</div>