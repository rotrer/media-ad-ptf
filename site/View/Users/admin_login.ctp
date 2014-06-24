<?php
echo $this->Form->create('User', array('controller' => 'users', 'action' => 'login'));
echo $this->Form->inputs(array(
    'legend' => __('Login'),
    'email' => array('type' => 'email'),
    'password'
));
echo $this->Form->end('Entrar');
?>