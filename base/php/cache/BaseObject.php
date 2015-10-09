<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 05.03.2015
 * Time: 12:41
 */

class base_cache_BaseObject 
{
    static private $_instance = array();

    /**
     * @var array
     */
    protected $cache;

    protected $class;

    /**
     * return a cache object for the given class
     *
     * @param $class
     * @return base_cache_BaseObject
     */
    public static function get($class)
    {
        if (!isset(self::$_instance[$class])) {
            self::$_instance[$class] = new self($class);
        }
        return self::$_instance[$class];
    }

    private function __construct($class)
    {
        $cacheFile = ROOT . "/files/cache/$class";
        if (file_exists($cacheFile)) {
            $handle = fopen($cacheFile, 'r');
            while ($content = fgets($handle)) {
                $this->setCacheEntry(unserialize($content));
            }
        }
        $this->class = $class;
    }

    public function __destruct()
    {
        if (empty($this->cache)) {
            return;
        }
        $fieldinfoCacheFile = ROOT . "/files/cache/{$this->class}";
        $handle = fopen($fieldinfoCacheFile, 'w+');
        foreach (array_values($this->cache) as $object) {
            fputs($handle, $object . "\n");
        }
        fclose($handle);
    }

    public function setCacheEntry(BaseObject $obj)
    {
        $this->cache[$obj->getLogicalKey()] = serialize($obj);
    }

    /**
     * @param int       $key    LK of the object stored in the cache
     * @return BaseObject
     */
    public function getCacheEntry($key)
    {
        if (isset($this->cache[$key])) {
            return unserialize($this->cache[$key]);
        }
        return null;
    }

    /**
     * delete cache obj
     *
     * @param BaseObject $obj
     */
    public function deleteCacheEntry(BaseObject $obj)
    {
        unset($this->cache[$obj->getLogicalKey()]);
    }
}