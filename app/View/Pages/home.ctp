<h1>Bienvenido</h1>

<?php #echo $this->Html->link('Login', $authLogin); ?>

<?php
echo $this->Form->create('User', array('controller' => 'users', 'action' => 'login'));
echo $this->Form->inputs(array(
    'legend' => __('Login'),
    'email' => array('type' => 'email'),
    'password',
    // 'captcha' => array('label' => 'Calcula esto para ingresar: '.$captcha)
));
// echo $this->Form->hidden('result', array('value' => $captcha_result));
echo $this->Form->end('Entrar');
?>