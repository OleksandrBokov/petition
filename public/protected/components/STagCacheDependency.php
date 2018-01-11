<?php

/**
 * STagCacheDependency class.
 *
 * STagCacheDependency represents a dependency based on a autoincrement(timestamp) of tags
 *
 * @author Yaroslav Fedan <yaroslav.fd@gmail.com>
 * @link https://github.com/YaroslavFedan
 */
class STagCacheDependency extends CCacheDependency
{
    /**
     * @var autoincrement(timestamp) param is used to
     * check if the dependency has been changed.
     */
    public $tag;
    /**
     * Cache component, by default used - cache
     * @var CCache
     */
    public $cache;
    /**
     * Name of cache component, by default used - cache
     * @var string
     */
    public $cacheName;

    /**
     * Constructor.
     * @param string $tag value of the tag for module
     */
    public function __construct($tag=null, $cacheName='cache')
    {
        $this->tag=$tag;
        $this->cacheName = $cacheName;
    }

    /**
     * Generates the data needed to determine if dependency has been changed.
     * This method returns the integer(timestamp).
     * @return mixed the data needed to determine if dependency has been changed.
     */
    protected function generateDependentData()
    {
        if($this->tag!==null)
        {
            $this->cache = Yii::app()->getComponent($this->cacheName);
            $t = $this->cache->get($this->tag);
            if ($t === false) {
                $t = microtime(true);
                $this->cache->set($this->tag, $t);
            }
            return $t;
        }
    }
}