<div class="sites view">
<h2><?php echo __('Sitio: '.$site['Site']['name']); ?></h2>
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
		<dt><?php echo __('Pedidos'); ?></dt>
		<dd>
			<select name="orders" id="orders">
				<option value="">Seleccione</option>
				<?php foreach ($orders as $key => $order) { ?>
				<option value="<?php echo $key; ?>"><?php echo $order; ?></option>
				<?php } ?>
			</select>
		</dd>
		<dt><?php echo __('Líneas de Pedidos'); ?></dt>
		<dd>
			<select name="line_items" id="line_items">
				<option value="">Seleccione</option>
			</select>
			<span class="load_lines loading" style="display:none;">Cargando...</span>
		</dd>
	</dl>
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
