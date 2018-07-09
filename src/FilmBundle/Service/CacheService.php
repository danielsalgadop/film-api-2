<?php

namespace  FilmBundle\Service;
use Symfony\Component\Filesystem\Filesystem;

class CacheService
{
    const SEPARATOR = 'X';
    private $cache;
    private $persistence_file;
    private $fileSystem;

    public function __construct($persistence_path)
    {
        $this->persistence_path = $persistence_path;
        $this->persistence_file = $persistence_path.'/cache';

        $this->fileSystem = new Filesystem();
        $this->preparePath();

        $this->persistentData2Cache();
    }

    public function get(int $id): ? Film
    {
        $this->persistentData2Cache();
        if(array_key_exists($id, $this->cache)){
            return $this->cache[$id];
        }
        return null;
    }

    public function set($film): void
    {
        $this->cache[$film->getId()] = $film;
        $this->persist();
    }

    public function clean()
    {
        $this->cache = [];
        $this->persist();
    }

    private function persistentData2Cache(): void
    {
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

    private function persist(): void
    {
        $this->fileSystem->remove([$this->persistence_file]);
        $this->preparePath();
        foreach($this->cache as $id => $film){
            file_put_contents($this->persistence_file, $id.self::SEPARATOR.serialize($film)."\n", FILE_APPEND);
        }
    }

    private function preparePath(): void
    {
        $this->fileSystem->mkdir($this->persistence_path, 0777);
        $this->fileSystem->touch($this->persistence_file, 0777);
    }
}
