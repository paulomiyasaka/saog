<?php

class auto_load{
    

        public function __construct() {
        	set_include_path(get_include_path().PATH_SEPARATOR."controle/");
			spl_autoload_extensions('.class.php');
            spl_autoload_register(array($this, 'loader'));
        }
        private function loader($className) {
        	
            //echo 'Tentando carregar a classe:  ', $className, ' pelo Método: ', __METHOD__, "()<br>";
            include $className . '.class.php';
            
        }
    


}


?>