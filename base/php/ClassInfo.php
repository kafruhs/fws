<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 27.01.2015
 * Time: 12:41
 */

class ClassInfo 
{
    /**
     * @var string
     */
    protected $class;

    /**
     * @var string
     */
    protected $module;

    /**
     * @var string
     */
    protected $pathToClassFile;

    /**
     * @param $className
     */
    public function __construct($className)
    {
        $this->class = $className;
        $this->_setClassInformation();
    }

    /**
     *
     */
    private function _setClassInformation()
    {
        if (!class_exists($this->class)) {
            return;
        }

        if (strpos($this->class, '_') == true) {
            $pathParts = explode('_', $this->class);
            $this->module = array_shift($pathParts);
        }

        $classFile = array_pop($pathParts);
        $this->pathToClassFile = ROOT . "/modules/{$this->module}/php/" . implode('/', $pathParts) . "/$classFile.php";
    }

    /**
     * @return string
     */
    public function getClass()
    {
        return $this->class;
    }

    /**
     * @return string
     */
    public function getModule()
    {
        return $this->module;
    }

    /**
     * @return string
     */
    public function getPathToClassFile()
    {
        return $this->pathToClassFile;
    }


}