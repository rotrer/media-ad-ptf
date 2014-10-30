<div class="sites view">
<h2><?php echo __('Sitio: '.$site['Site']['name']); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($site['Site']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Nombre'); ?></dt>
		<dd>
			<?php echo h($site['Site']['name']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Llave Pública'); ?></dt>
		<dd>
			<?php echo h($site['Site']['public_key']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Estado'); ?></dt>
		<dd>
			<?php echo h($site['Site']['state']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Fecha registro'); ?></dt>
		<dd>
			<?php echo h($site['Site']['created']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Pedidos'); ?></dt>
		<?php echo $this->Form->create(); ?>
		<?php echo $this->Form->input('site_id', array('value' => $site['Site']['id'], 'type' => 'hidden')); ?>
		<?php echo $this->Form->input('name_order', array('id' => 'name_order', 'type' => 'hidden')); ?>
		<?php echo $this->Form->input('name_lineitem', array('id' => 'name_lineitem', 'type' => 'hidden')); ?>
		<dd>
			<select name="data[Site][order_id]" id="orders">
				<option value="">Seleccione</option>
				<?php foreach ($orders as $key => $order) { ?>
				<option value="<?php echo $key; ?>"><?php echo $order; ?></option>
				<?php } ?>
			</select>
		</dd>
		<dt><?php echo __('Líneas de Pedidos'); ?></dt>
		<dd>
			<select name="data[Site][line_item_id]" id="line_items">
				<option value="">Seleccione</option>
			</select>
			<span class="load_lines loading" style="display:none;">Cargando...</span>
		</dd>
		<dt><?php echo __('Cantidad de Zonas'); ?></dt>
		<dd>
			<select name="data[Site][cantidad_zonas]" id="cantidad_zonas">
				<option value="">Seleccione</option>
				<?php for ($i=1; $i <= 20; $i++) { ?>
				<option value="<?php echo $i; ?>"><?php echo $i; ?></option>
				<?php } ?>
			</select>
		</dd>
		<?php echo $this->Form->end('Continuar'); ?>
	</dl>
</div>
<!-- <div class="actions">
	<h3><?php echo __('Acciones'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Editar Sitio'), array('action' => 'edit', $site['Site']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Eliminar Sitio'), array('action' => 'delete', $site['Site']['id']), null, __('Seguro desea eliminar %s?', $site['Site']['name'])); ?> </li>
		<li><?php echo $this->Html->link(__('Lista de Sitios'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('Nuevo Sitio'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('Lista de Usuarios'), array('controller' => 'users', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('Nuevo Usuario'), array('controller' => 'users', 'action' => 'add')); ?> </li>
	</ul>
</div>
 -->