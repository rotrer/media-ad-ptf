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
		<dt><?php echo __('Plugin'); ?></dt>
		<dd>
			<?php echo $this->Html->link($zona['Plugins']['name'], array('controller' => 'plugins', 'action' => 'view', $zona['Plugins']['id'])); ?>
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
		<legend><?php echo __('Ad Unit'); ?></legend>
		<div class="table-responsive">
			<table cellpadding = "0" cellspacing = "0" class="table table-striped">
			<tr>
				<th><?php echo __('Nombre'); ?></th>
				<th><?php echo __('Línea Pedido'); ?></th>
				<th><?php echo __('Fecha Resgistro'); ?></th>
			</tr>
			<tr>
				<td><?php echo $lineItemInfo['AdUnits']['name']; ?></td>
				<td><?php echo $lineItemInfo['LineItems']['name']; ?></td>
				<td><?php echo date('d-m-Y H:i:s', strtotime($zona['Zona']['created'])); ?></td>
			</tr>
			</table>
		</div>
	</div>
</div>