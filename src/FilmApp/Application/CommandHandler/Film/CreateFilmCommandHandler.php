<?php

namespace FilmApp\Application\CommandHandler\Film;
use FilmApp\Domain\Film;
use FilmApp\Domain\Repository\FilmRepository;
use FilmApp\Domain\Repository\ActorRepository;


class CreateFilmCommandHandler
{
    private $filmRepository;
    private $actorRepository;

    public function __construct(FilmRepository $filmRepository, ActorRepository $actorRepository)
    {
        $this->filmRepository = $filmRepository;
        $this->actorRepository = $actorRepository;
    }

    public function handle($command)
    {
        $actor = $this->actorRepository->findActorByIdOrError($command->getActorId());
        $film = new Film($command->getName(), $command->getDescription(), $actor);
        $this->filmRepository->persist($film);
        return true;
    }
}
