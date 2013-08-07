<?php
/**
 * Path of root of tree
 * change it if file is not placed on this root.
 */
define('NODE_ROOT', dirname(__FILE__));

/**
 * Separator.
 * choose between _ (compatible php 5.2) and \ (namespaces)
 */
define('NODE_SEPARATOR', '_');


/**
 * comment/remove it if autoload is already supported by another handler
 */
spl_autoload_register(array('node', 'autoload'));


/**
 * Description of node
 *
 * @author b.le
 */
class node
{
    /**
     * generate and get property on the fly
     * - from method
     * - from subclass
     * @param string $prop
     * @return mixed
     */
    public function __get($prop)
    {
        if (method_exists($this, $prop))
        {
            return $this->$prop = $this->$prop();
        }
        else if (class_exists($class = get_class().'_'.$prop))
        {
            return $this->$prop = new $class;
        }
    }
        
    /**
     * spl_autoload_register handler
     * @param string $class
     */
    public static function autoload($class)
    {
        include NODE_ROOT . DIRECTORY_SEPARATOR . str_replace('_', DIRECTORY_SEPARATOR, $class) . '.php';
        if (!class_exists($class, false)) return false;
        return true;
    }
}
