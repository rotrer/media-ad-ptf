<!DOCTYPE html>
<html lang="en">
	<head>
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta name="description" content="">
		<meta name="author" content="">
		<?php echo $this->Html->charset(); ?>
		<title>
			Montana:
			<?php echo $title_for_layout; ?>
		</title>
		<?php
			echo $this->Html->meta('icon');

			echo $this->Html->css(array('../bootstrap/css/bootstrap.min', '../bootstrap/css/bootstrap-theme.min', 'dashboard'));
			echo $this->Html->script(array('jquery-1.11.0.min.js', 'admin', '../bootstrap/js/bootstrap.min'));

			echo $this->fetch('meta');
			echo $this->fetch('css');
			echo $this->fetch('script');
		?>

	</head>

	<body>

		<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
			<div class="container-fluid">
				<div class="navbar-header">
					<?php echo $this->Html->link(__('Montana'), array('controller' => 'sites', 'action' => 'index'), array('class' => 'navbar-brand')); ?>
				</div>
				<div id="navbar" class="navbar-collapse collapse">
					<ul class="nav navbar-nav navbar-right">
						<?php if (isset($menuAdminAccess) && $menuAdminAccess['sites'] && isset($networksAds)) { ?>
						<li class="dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown">Network <span class="caret"></span></a>
		          <ul class="dropdown-menu" role="menu">
		          	<?php foreach ($networksAds as $key => $net) { $selectedNet = ($key == $networksAdsSelected) ? '&nbsp<span class="glyphicon glyphicon-ok-sign"></span>' : ''; ?>
		          	<li>
		          		<?php echo $this->Html->link($net . $selectedNet, array('controller' => 'pages', 'action' => 'setnetwork', $key), array('escape' => false)); ?>
		          	</li>
		          	<?php } ?>
		          </ul>
						</li>
						<?php } ?>
						<li>&nbsp;</li>
						<li><?php echo (isset($menuAdminAccess)) ? $this->Html->link("Salir", array("controller" => "users", "action" => "logout", "admin" => true)) : ''; ?></li>
					</ul>
				</div>
			</div>
		</nav>

		<div class="container-fluid">
			<div class="row">
				<div class="col-sm-3 col-md-2 sidebar">
					<ul class="nav nav-sidebar">
						<?php if (isset($menuAdminAccess) && $menuAdminAccess['plugin']) { ?>
						<li class="<?php echo ((isset($activePluginsMenu)) && $activePluginsMenu === true) ? 'active' : ''; ?>">
							<?php echo $this->Html->link(__('Plugins'), array('controller' => 'plugins', 'action' => 'index')); ?>
							<?php if ((isset($activePluginsMenu)) && $activePluginsMenu === true) { ?>
							<ul>
								<li><?php echo $this->Html->link(__('Todos'), array('action' => 'index')); ?></li>
								<li><?php echo $this->Html->link(__('Nuevo Plugin'), array('action' => 'add')); ?></li>
							</ul>
							<?php } ?>
						</li>
						<?php } ?>

						<?php if (isset($menuAdminAccess) && $menuAdminAccess['users']) { ?>
						<li class="<?php echo ((isset($activeUsersMenu)) && $activeUsersMenu === true) ? 'active' : ''; ?>">
							<?php echo $this->Html->link(__('Usuarios'), array('controller' => 'users', 'action' => 'index')); ?>
							<?php if ((isset($activeUsersMenu)) && $activeUsersMenu === true) { ?>
							<ul>
								<li><?php echo $this->Html->link(__('Todos'), array('action' => 'index')); ?></li>
								<li><?php echo $this->Html->link(__('Nuevo Usuario'), array('action' => 'add')); ?></li>
							</ul>
							<?php } ?>
						</li>
						<?php } ?>

						<?php if (isset($menuAdminAccess) && $menuAdminAccess['sites']) { ?>
						<li class="<?php echo ((isset($activeSitesMenu)) && $activeSitesMenu === true) ? 'active' : ''; ?>">
							<?php echo $this->Html->link(__('Sitios'), array('controller' => 'sites', 'action' => 'index')); ?>
							<?php if ((isset($activeSitesMenu)) && $activeSitesMenu === true) { ?>
							<ul>
								<li><?php echo $this->Html->link(__('Todos'), array('action' => 'index')); ?></li>
								<li><?php echo $this->Html->link(__('Nuevo Sitio'), array('action' => 'add')); ?></li>
							</ul>
							<?php } ?>
						</li>
						<?php } ?>

						<?php if (isset($menuAdminAccess) && $menuAdminAccess['zonas']) { ?>
						<li class="<?php echo ((isset($activeZonasMenu)) && $activeZonasMenu === true) ? 'active' : ''; ?>">
							<?php echo $this->Html->link(__('Zonas'), array('controller' => 'zonas', 'action' => 'index')); ?>
							<?php if ((isset($activeZonasMenu)) && $activeZonasMenu === true) { ?>
							<ul>
								<li><?php echo $this->Html->link(__('Todas'), array('action' => 'index')); ?></li>
								<li><?php echo $this->Html->link(__('Nueva Zona'), array('action' => 'add')); ?></li>
							</ul>
							<?php } ?>
						</li>
						<?php } ?>

					</ul>
				</div>
				<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
					<?php echo $this->Session->flash(); ?>
					<?php echo $this->fetch('content'); ?>
				</div>
			</div>
		</div>
		<?php #echo $this->element('sql_dump'); ?>
		<script>
			var APP_JQ = '<?php echo $this->base; ?>';
		</script>
	</body>
</html>