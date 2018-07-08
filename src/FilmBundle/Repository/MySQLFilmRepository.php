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

    public function persist(Film $actor)
    {
        $this->em->persist($actor);
    }

    public function delete(int $actor_id): void
    {
        $actor = $this->em->getReference('\FilmApp\Domain\Film', $actor_id);
        $this->em->remove($actor);
    }

    public function findAllFilms(): array
    {
        return $this->em
            ->getRepository('FilmBundle:Film')
            ->findAll();
    }

    public function findFilmByIdOrError(int $actor_id): Film
    {
        $actor = $this->em
            ->getRepository(Film::class)
            ->findOneBy(['id' => $actor_id]);

        if ($actor  === null) {
            throw new Exception('Film does not Existst');
        }

        return $actor;
    }
}

