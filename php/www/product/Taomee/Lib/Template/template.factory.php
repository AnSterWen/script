<?php

class TemplateFactory
{

    function TemplateFactory()
    {
    }

    /**
     * Get a reference to the only instance of database class and connects to DB
     * 
     * if the class has not been instantiated yet, this will also take 
     * care of that
     * 
     * @static
     * @staticvar   object  The only instance of database class
     * @return      object  Reference to the only instance of database class
     */
    static function getTemplateCompiler($params = array('compiler' => 'compiler'))
    {
        static $instance;
        
        if (! isset($instance)) {
            $file = TAOMEE_TPL_PATH . 'compilers/compiler.class.php';
            require_once $file;
            
            $class = ucfirst($params['compiler']);
            $instance = new $class($params);
        }
        return $instance;
    }


}
?>