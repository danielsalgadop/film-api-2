<?php

namespace  FilmBundle\Service;
use Symfony\Component\Filesystem\Filesystem;

class CacheService
{
    const SEPARATOR = ':';
    private $cache;
    private $persistence_file;

    public function __construct($persistence_path){
        $this->persistence_file = $persistence_path.'/cache';

        $fileSystem = new Filesystem();
        $fileSystem->mkdir($persistence_path, 0777);
        $fileSystem->touch($this->persistence_file, 0777);
        $this->persistentData2Cache();
    }

    public function get(int $id)
    {
        if(array_key_exists($id, $this->cache)){
            return $this->cache[$id];
        }
        return null;
    }

    public function set($film){
        $this->cache[$film->getId()] = $film;
        $this->persist();
    }

    private function persistentData2Cache(){

        $arr = file($this->persistence_file);
        $this->cache = [];

        if(count($arr) > 0){
            foreach($arr as $line){
                list($id, $s_film) = explode(self::SEPARATOR,$line,2);
                    $film = unserialize($s_film);
                    $this->cache[$id] = $film;
            }
        }
    }

    private function persist()
    {
        foreach($this->cache as $id => $film){
            file_put_contents($this->persistence_file, $id.self::SEPARATOR.serialize($film)."\n", FILE_APPEND);
        }
    }
    public function clean()
    {
        $this->cache = [];
        $this->persist();
    }
}
