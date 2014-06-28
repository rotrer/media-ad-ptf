<h1>Instalar Media Ads</h1>
<?php 
	echo $this->Form->create('Install', array('controller' => 'install', 'action' => 'create'));
		echo $this->Form->inputs(array(
			'legend' => __('Crear Adminsitrador'),
		    'name',
		    'email',
		    #'username',
		    #'password'
		));
	echo $this->Form->end('Entrar');
?>