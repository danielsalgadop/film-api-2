<?php

namespace FilmBundle\Repository;

use Doctrine\ORM\EntityRepository;
use FilmApp\Domain\Film;
use FilmApp\Domain\Repository\FilmRepository;
use Doctrine\ORM\EntityManagerInterface;

use \Exception;

class MySQLFilmRepository implements FilmRepository
{
    private $em;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->em = $entityManager;
    }

    public function persist(Film $film)
    {
        $this->em->persist($film);
    }

    public function delete(int $film_id): void
    {
        $film = $this->em->getReference('\FilmApp\Domain\Film', $film_id);
        $this->em->remove($film);
    }

    public function findAllFilms(): array
    {
        return $this->em
            ->getRepository('FilmBundle:Film')
            ->findAll();
    }

    public function findFilmByIdOrError(int $film_id): Film
    {
        $film = $this->em
            ->getRepository(Film::class)
            ->findOneBy(['id' => $film_id]);

        if ($film  === null) {
            throw new Exception('Film does not Exist');
        }

        return $film;
    }
}

