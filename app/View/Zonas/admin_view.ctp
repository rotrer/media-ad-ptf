<div>
<legend><?php echo __('Zona'); ?></legend>
	<dl class="dl-horizontal">
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
			<?php echo date('d-m-Y H:i:s', strtotime($zona['Zona']['created'])); ?>
			&nbsp;
		</dd>
	</dl>
	<br>
	<div class="related">
		<legend><?php echo __('Ad Units'); ?></legend>
		<?php if (!empty($zona['AdUnit'])): ?>
		<div class="table-responsive">
			<table cellpadding = "0" cellspacing = "0" class="table table-striped">
			<tr>
				<th><?php echo __('Id'); ?></th>
				<th><?php echo __('Nombre'); ?></th>
				<th><?php echo __('Fecha Resgistro'); ?></th>
				<!--th class="actions"><?php echo __('Actions'); ?></th-->
			</tr>
			<?php foreach ($zona['AdUnit'] as $adUnit): ?>
				<tr>
					<td><?php echo $adUnit['id']; ?></td>
					<td><?php echo $adUnit['name']; ?></td>
					<td><?php echo date('d-m-Y H:i:s', strtotime($adUnit['created'])); ?></td>
					<!--td class="actions">
						<?php echo $this->Html->link(__('View'), array('controller' => 'ad_units', 'action' => 'view', $adUnit['id'])); ?>
						<?php echo $this->Html->link(__('Edit'), array('controller' => 'ad_units', 'action' => 'edit', $adUnit['id'])); ?>
						<?php echo $this->Form->postLink(__('Delete'), array('controller' => 'ad_units', 'action' => 'delete', $adUnit['id']), null, __('Are you sure you want to delete # %s?', $adUnit['id'])); ?>
					</td-->
				</tr>
			<?php endforeach; ?>
			</table>
		</div>
	<?php endif; ?>
	</div>
</div>