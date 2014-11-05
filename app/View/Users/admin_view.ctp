<div>
	<legend><?php echo __('Usuario'); ?></legend>
	<dl class="dl-horizontal">
		<dt><p><?php echo __('Nombre'); ?></p></dt>
		<dd>
			<p><?php echo h($user['User']['name']); ?></p>
		</dd>
		<dt><p><?php echo __('Contraseña'); ?></p></dt>
		<dd>
			<p>-----------</p>
		</dd>
		<dt><p><?php echo __('Email'); ?></p></dt>
		<dd>
			<p><?php echo h($user['User']['email']); ?></p>
		</dd>
		<dt><p><?php echo __('Rol'); ?></p></dt>
		<dd>
			<p><?php echo h($user['User']['role']); ?></p>
		</dd>
		<dt><p><?php echo __('Estado'); ?></p></dt>
		<dd>
			<p><?php echo h($user['User']['state']); ?></p>
		</dd>
		<dt><p><?php echo __('Primer login'); ?></p></dt>
		<dd>
			<p><?php echo ($user['User']['first_login']) ? 'SÍ' : 'NO'; ?></p>
		</dd>
		<dt><p><?php echo __('Fecha Registro'); ?></p></dt>
		<dd>
			<p><?php echo h($user['User']['created']); ?></p>
		</dd>
	</dl>
</div>