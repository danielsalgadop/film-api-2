<?php

namespace FilmApp\Application\CommandHandler\Actor;

// use FilmApp\Application\Command\Actor\CreateActorCommand;
use FilmApp\Domain\Actor;
use FilmApp\Domain\Repository\ActorRepository;

class CreateActorCommandHandler
{
    private $actorRepository;

    public function __construct(ActorRepository $actorRepository)
    {
        $this->actorRepository = $actorRepository;
    }

    public function handle($command): Actor
    {
        $actor = new Actor($command->getName());
        $this->actorRepository->save($actor);
        return $actor;
    }
}
