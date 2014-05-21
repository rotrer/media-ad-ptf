<div class="zonas form">
<?php echo $this->Form->create('Zona'); ?>
	<?php #echo $this->Form->input('sites_id', array('type' => 'hidden', 'value' => $sites['Site']['id'])); ?>
	<fieldset>
		<legend><?php echo __('Agregar Zona a un Sitio'); ?></legend>
		<dl>
			<dt><?php echo __('Nombre'); ?></dt>
			<dd>
				<?php echo h($sites['Site']['name']); ?>
				&nbsp;
			</dd>
			<dt><?php echo __('Url'); ?></dt>
			<dd>
				<?php echo h($sites['Site']['domain']); ?>
				&nbsp;
			</dd>
		</dl>
		<table>
			<tr>
				<th>Zona nombre<span>*</span></th>
				<th>Ad unit<span>*</span></th>
				<th>ID Tag Template<span>*</span></th>
			</tr>
			<?php for ($i=0; $i < 3; $i++) { ?>
			<tr>
				<td><?php echo $this->Form->input('name'.$i, array('div' => false, 'label' => false, 'required')); ?></td>
				<td>
					<?php echo $this->Form->select('adunit'.$i, $adunits, array('div' => false, 'label' => false, 'required', 'empty' => 'Seleccione')); ?>
					<?php #foreach ($adunits as $key => $adunit) { ?>
						
					<?php #} ?>
					<?php #echo $this->Form->input('ads'.$i, array('div' => false, 'label' => false, 'required')); ?>
				</td>
				<td><?php echo $this->Form->input('id_tag_template'.$i, array('div' => false, 'label' => false, 'required')); ?></td>
			</tr>
			<?php } ?>
		</table>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('List Zonas'), array('action' => 'index')); ?></li>
		<li><?php echo $this->Html->link(__('List Sites'), array('controller' => 'sites', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Sites'), array('controller' => 'sites', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Ad Units'), array('controller' => 'ad_units', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Ad Unit'), array('controller' => 'ad_units', 'action' => 'add')); ?> </li>
	</ul>
</div>
