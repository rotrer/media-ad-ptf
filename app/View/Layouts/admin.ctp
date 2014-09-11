<?php
/**
 *
 *
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.View.Layouts
 * @since         CakePHP(tm) v 0.10.0.1076
 */

$cakeDescription = __d('cake_dev', 'Media AdServer');
?>
<!DOCTYPE html>
<html>
<head>
	<?php echo $this->Html->charset(); ?>
	<title>
		<?php echo $cakeDescription ?>:
		<?php echo $title_for_layout; ?>
	</title>
	<?php
		echo $this->Html->meta('icon');

		echo $this->Html->css('cake.generic');
		echo $this->Html->script(array('jquery-1.11.0.min.js', 'admin'));

		echo $this->fetch('meta');
		echo $this->fetch('css');
		echo $this->fetch('script');
	?>
</head>
<body>
	<div id="container">
		<div id="header">
			<!--h1><?php echo $this->Html->link($cakeDescription, 'http://cakephp.org'); ?></h1-->
			<?php echo (isset($menuAdminAccess)) ? $this->Html->link("Salir", array("controller" => "users", "action" => "logout", "admin" => true), array("style" => "float: right; color: #fff !important")) : ''; ?>
			<div class="menu">
				<?php echo (isset($menuAdminAccess) && $menuAdminAccess['users']) ? $this->Html->link(__('Usuarios'), array('controller' => 'users', 'action' => 'index')) : ''; ?>
				<?php echo (isset($menuAdminAccess) && $menuAdminAccess['sites']) ? $this->Html->link(__('Sitios'), array('controller' => 'sites', 'action' => 'index')) : ''; ?>
				<?php echo (isset($menuAdminAccess) && $menuAdminAccess['zonas']) ? $this->Html->link(__('Zonas'), array('controller' => 'zonas', 'action' => 'index')) : ''; ?>
				<?php echo (isset($menuAdminAccess) && $menuAdminAccess['adunits']) ? $this->Html->link(__('Ad-units'), array('controller' => 'adunits', 'action' => 'index')) : ''; ?>
				<?php if (isset($menuAdminAccess) && $menuAdminAccess['sites']) { ?>
					<?php echo $this->Form->create('Pages', array('controller' => 'pages', 'action' => 'setnetwork', 'admin' => true, 'name' => 'changenetwork')); ?>
						<?php
							echo $this->Form->input('network', array(
								'options' => $networksAds,
								'empty' => 'Network',
								'label' => false,
								'div' => false,
								'style' => 'float: right;',
								'onchange' => 'javascript:document.changenetwork.submit();'
							));
						?>
					<?php echo $this->Form->end(); ?>
				<?php } ?>
			</div>
		</div>
		<div id="content">

			<?php echo $this->Session->flash(); ?>

			<?php echo $this->fetch('content'); ?>
		</div>
		<div id="footer">
		</div>
	</div>
	<?php echo $this->element('sql_dump'); ?>
	<script>
		var APP_JQ = '<?php echo $this->base; ?>';
	</script>
</body>
</html>
