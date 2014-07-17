<?php
echo $this->Form->create('User', array('controller' => 'users', 'action' => 'login'));
echo $this->Form->inputs(array(
    'legend' => __('Login'),
    'email' => array('type' => 'email'),
    'password',
    'captcha' => array('label' => 'Eres un robot?, calcula esto: '.$captcha)
));
echo $this->Form->hidden('result', array('value' => $captcha_result));
echo $this->Form->end('Entrar');
?>