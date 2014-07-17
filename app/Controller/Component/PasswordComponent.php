<?php  
class PasswordComponent extends Object { 
  
  public function initialize(){}
  public function startup(){}
  public function beforeRender(){}
  public function beforeRedirect(){}
  public function shutdown(){}
/** 
 * Password generator function 
 * 
 */ 
    public function generatePassword ($length = 8){ 
        // inicializa variables 
        $password = ""; 
        $i = 0; 
        $possible = "0123456789bcdfghjkmnpqrstvwxyz";  
         
        // agrega random 
        while ($i < $length){ 
            $char = substr($possible, mt_rand(0, strlen($possible)-1), 1); 
             
            if (!strstr($password, $char)) {  
                $password .= $char; 
                $i++; 
            } 
        } 
        return $password; 
    } 
} 