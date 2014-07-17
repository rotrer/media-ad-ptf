<?php
echo $this->Form->create('User', array('controller' => 'users', 'action' => 'changepassword'));
echo $this->Form->inputs(array(
    'legend' => __('Cambiar Contraseña'),
    'nueva_pass' => array('type' => 'password', 'required', 'label' => 'Nueva Contraseña', 'autoComplete' => 'off'),
    'nueva_pass_r' => array('type' => 'password', 'required', 'label' => 'Repetir Nueva Contraseña', 'autoComplete' => 'off')
));
echo $this->Form->end('Actualizar');
?>