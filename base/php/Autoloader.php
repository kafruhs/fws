<?php
/**
 * Created by PhpStorm.
 * User: Mediacenter
 * Date: 01.08.2014
 * Time: 07:06
 */

class Autoloader
{
    const CLASS_NOT_FOUND = 2;

    private static $_instance = null;

    /**
     * create an autoloader instance
     *
     * @return Autoloader
     */
    public static function singleton()
    {
        if (self::$_instance instanceof self === true) {
            return self::$_instance;
        }
        self::$_instance = new self();
        return self::$_instance;
    }

    /**
     * try to load the class definition of a given class name
     *
     * @param $className
     * @throws base_exception_Autoloader
     */
    public function loadClass($className)
    {
        if (strpos($className, '_') == true) {
            $filePath = $this->getClassFileByFolderStructure($className);
            if ($filePath !== self::CLASS_NOT_FOUND) {
                require_once($filePath);
                return;
            }
        }

        $filePath = $this->getClassFileFromPHPFolder($className);
        if ($filePath !== self::CLASS_NOT_FOUND) {
            require_once($filePath);
        } else {
            throw new base_exception_Autoloader(TMS(base_exception_Autoloader::CLASS_NOT_FOUND, array('class' => $className)));
        }
    }

    /**
     * try to get the path name by its class name
     *
     * @param $className
     * @return string
     */
    private function getClassFileByFolderStructure($className)
    {
        $pathParts = explode('_', $className);
        $module = array_shift($pathParts);
        $classFile = ucfirst(array_pop($pathParts));
        $filePath = ROOT . "/modules/$module/php/" . implode('/', $pathParts) . "/$classFile.php";
        if (file_exists($filePath) === true) {
            return $filePath;
        }
        $filePath = ROOT . "/modules/$module/php/$classFile.php";
        if (file_exists($filePath) === true) {
            return $filePath;
        }
        return self::CLASS_NOT_FOUND;
    }

    /**
     * get all module folders
     *
     * @return array
     */
    private function getModuleFolders()
    {
        $modules = [];
        $folder = ROOT . '/modules';
        $handle = opendir($folder);
        while ($fileName = readdir($handle)) {
            if ($fileName == '.' || $fileName == '..') {
                continue;
            }
            $folderPath = $folder . '/' . $fileName;
            if (is_file($folderPath) === true) {
                continue;
            }
            if (is_dir($folderPath) === true) {
                $modules[] = $fileName;
            }
        }
        closedir($handle);
        return $modules;
    }

    /**
     * try to get the class file by searching the php folder of the different modules
     *
     * @param $className
     * @return int|string
     */
    private function getClassFileFromPHPFolder($className)
    {
        $modules = $this->getModuleFolders();
        $className = ucfirst($className);
        foreach ($modules as $module) {
            $fileName = ROOT . "/modules/$module/php/$className.php";
            if (file_exists($fileName) === true) {
                return $fileName;
            }
        }
        return self::CLASS_NOT_FOUND;
    }


} 