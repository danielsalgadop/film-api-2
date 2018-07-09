<?php

namespace FilmBundle\Repository;

use Doctrine\ORM\EntityRepository;
use FilmApp\Domain\Film;
use FilmApp\Domain\Repository\FilmRepository;
use Doctrine\ORM\EntityManagerInterface;
use FilmBundle\Service\CacheService;

use \Exception;

class MySQLFilmRepository implements FilmRepository
{
    private $em;
    private $cache;

    public function __construct(EntityManagerInterface $entityManager, CacheService $cache)
    {
        $this->em = $entityManager;
        $this->cache = $cache;
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
        if ($this->cache->get($film_id) == null) {
            $film = $this->em
                ->getRepository(Film::class)
                ->findOneBy(['id' => $film_id]);
            if ($film  === null) {
                throw new Exception('Film does not Exist');
            }
        } else {
            return $this->cache->get($film_id);
        }

        $this->cache->set($film);
        return $film;
    }
}
