<?php

namespace FilmApp\Application\CommandHandler\Film;
use FilmApp\Domain\Film;
use FilmApp\Domain\Repository\FilmRepository;
use FilmApp\Domain\Repository\ActorRepository;
use FilmBundle\Service\CacheService;
use FilmBundle\Event\AfterCreateFilmEvent;

class CreateFilmCommandHandler
{
    private $filmRepository;
    private $actorRepository;
    private $cache;

    public function __construct(FilmRepository $filmRepository, ActorRepository $actorRepository, CacheService $cache)
    {
        $this->filmRepository = $filmRepository;
        $this->actorRepository = $actorRepository;
        $this->cache = $cache;
    }

    public function handle($command)
    {
        $actor = $this->actorRepository->findActorByIdOrError($command->getActorId());
        $film = new Film($command->getName(), $command->getDescription(), $actor);
        $this->filmRepository->persist($film);
        $event = new AfterCreateFilmEvent($this->cache);
        return true;
    }
}
