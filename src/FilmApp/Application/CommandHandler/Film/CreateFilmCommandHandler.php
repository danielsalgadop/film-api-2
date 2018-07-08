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

        file_put_contents("/home/dsalgado/mylogs/filelogs.log",print_r(date("Y-m-d_h:i:sa").__FILE__." ".__METHOD__." ".__LINE__." [".$command->getName()."]\n",true),FILE_APPEND);
        $film = new Film($command->getName(), $command->getDescription(), $actor);
        file_put_contents("/home/dsalgado/mylogs/filelogs.log",var_export($film,true),FILE_APPEND);
        $this->filmRepository->persist($film);
        return true;
    }
}
