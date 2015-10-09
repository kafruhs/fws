<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 05.02.2015
 * Time: 16:32
 */

class base_cache_Fieldinfo implements base_interface_Singleton
{
    static private $_instance = null;

    /**
     * @var array
     */
    protected $cache;

    public static function get()
    {
        if (is_null(self::$_instance)) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    private function __construct()
    {
        $fieldinfoCacheFile = ROOT . '/files/cache/fieldinfo';
        if (file_exists($fieldinfoCacheFile)) {
            $handle = fopen($fieldinfoCacheFile, 'r');
            while ($content = fgets($handle)) {
                $this->setFieldinfo(unserialize($content));
            }
        }
    }

    public function __destruct()
    {
        $fieldinfoCacheFile = ROOT . '/files/cache/fieldinfo';
        $handle = fopen($fieldinfoCacheFile, 'w+');
        foreach ($this->cache as $fieldInfoArrayByClass) {
            foreach ($fieldInfoArrayByClass as $fi) {
                fputs($handle, serialize($fi) . "\n");
            }
        }
        fclose($handle);
    }

    public function setFieldinfo(Fieldinfo $fi)
    {
        $this->cache[$fi->getClass()][$fi->getFieldName()] = $fi;
    }

    /**
     * @param $class
     * @param $fieldName
     * @return Fieldinfo|null
     */
    public function getFieldinfo($class, $fieldName)
    {
        $class = strtolower($class);
        if (isset($this->cache[$class][$fieldName])) {
            return $this->cache[$class][$fieldName];
        }
        return null;
    }
}