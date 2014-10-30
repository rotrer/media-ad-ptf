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
		          	<?php foreach ($networksAds as $key => $net) { ?>
		          	<li>
		          		<?php echo $this->Html->link($net, array('controller' => 'pages', 'action' => 'setnetwork', $key)); ?>
		          	</li>
		          	<?php } ?>
		          </ul>
<!-- 
$networksAds
$networksAdsSelected
-->
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
						<li class="<?php echo ((isset($activeUsersMenu)) && $activeUsersMenu === true) ? 'active' : ''; ?>"><?php echo (isset($menuAdminAccess) && $menuAdminAccess['users']) ? $this->Html->link(__('Usuarios'), array('controller' => 'users', 'action' => 'index')) : ''; ?></li>
						<li class="<?php echo ((isset($activeSitesMenu)) && $activeSitesMenu === true) ? 'active' : ''; ?>"><?php echo (isset($menuAdminAccess) && $menuAdminAccess['sites']) ? $this->Html->link(__('Sitios'), array('controller' => 'sites', 'action' => 'index')) : ''; ?></li>
						<li class="<?php echo ((isset($activeZonasMenu)) && $activeZonasMenu === true) ? 'active' : ''; ?>"><?php echo (isset($menuAdminAccess) && $menuAdminAccess['zonas']) ? $this->Html->link(__('Zonas'), array('controller' => 'zonas', 'action' => 'index')) : ''; ?></li>
						<li class="<?php echo ((isset($activeAdunitsMenu)) && $activeAdunitsMenu === true) ? 'active' : ''; ?>"><?php echo (isset($menuAdminAccess) && $menuAdminAccess['adunits']) ? $this->Html->link(__('Ad-units'), array('controller' => 'adUnits', 'action' => 'index')) : ''; ?></li>
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