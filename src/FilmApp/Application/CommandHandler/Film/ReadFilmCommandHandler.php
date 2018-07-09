<?php

namespace FilmApp\Application\CommandHandler\Film;
use FilmApp\Domain\Film;
use FilmApp\Domain\Repository\FilmRepository;
use FilmApp\Domain\Repository\ActorRepository;
use FilmBundle\Service\CacheService;


class ReadFilmCommandHandler
{
    private $filmRepository;
    private $cache;

    public function __construct(FilmRepository $filmRepository, CacheService $cache)
    {
        $this->filmRepository = $filmRepository;
        $this->cache = $cache;
    }

    public function handle(int $id)
    {
        if($this->cache->get($id) == null){
            $film = $this->filmRepository->findFilmByIdOrError($id);
            $this->cache->set($film);
        }
        return $this->cache->get($id);
    }
}
