<h1>Bienvenido a Medeiatrends Ads</h1>

<?php #echo $this->Html->link('Login', $authLogin); ?>

<?php
echo $this->Form->create('User', array('controller' => 'users', 'action' => 'login'));
echo $this->Form->inputs(array(
    'legend' => false,
    'username',
    'password'
));
echo $this->Form->end('Entrar');
?>