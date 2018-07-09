<?php

namespace FilmApp\Application\CommandHandler\Film;

use FilmApp\Domain\Film;
use FilmApp\Domain\Repository\FilmRepository;
use FilmApp\Domain\Repository\ActorRepository;

class ReadFilmCommandHandler
{
    private $filmRepository;

    public function __construct(FilmRepository $filmRepository)
    {
        $this->filmRepository = $filmRepository;
    }

    public function handle(int $id)
    {
        return $this->filmRepository->findFilmByIdOrError($id);
    }
}
