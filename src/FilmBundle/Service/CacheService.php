<?php

namespace  FilmBundle\Service;

class CacheService
{
    const SEPARATOR = ':';
    private $cache;
    private $persistence_path;

    public function __construct($persistence_path){
        $this->persistence_path = $persistence_path;
        $this->persistentData2Cache();
    }

    public function get($id, $value)
    {
        if(array_key_exists($id, $this->cache)){
            return $this->cache[$id];
        }
    }

    public function set($id,$object){
        $this->cache[$id] = $object;
        $this->persist();

    }
    private function persistentData2Cache(){
        foreach(file($this->persistence_path as $line)){
            list($id, $s_object) = explode(self::SEPARATOR,$line,1);
                $obect = unserialize($s_object);
                $this->cache[$id] = $s_object;
        }
    }

    private function persist()
    {
        foreach($this->cache as $id => $object){
            file_put_contents($this->persistence_path, $id.self::SEPARATOR.serialize($object)."\n", FILE_APPEND);
        }
    }
    public function clean()
    {
        $this->cache = [];
        $this->persist();
    }
}
