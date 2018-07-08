<?php

namespace FilmBundle\Repository;

use Doctrine\ORM\EntityRepository;
use FilmApp\Domain\Actor;
use FilmApp\Domain\Repository\ActorRepository;
use Doctrine\ORM\EntityManagerInterface;

use \Exception;

class MySQLActorRepository implements ActorRepository
{
    private $em;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->em = $entityManager;
    }

    public function save(Actor $actor)
    {
        $this->em->persist($actor);
    }

    public function delete(int $actor_id): void
    {
        $actor = $this->em->getReference('\FilmApp\Domain\Actor', $actor_id);
        $this->em->remove($actor);
    }

    public function findAllActors(): array
    {
        return $this->em
            ->getRepository('FilmBundle:Actor')
            ->findAll();
    }

    public function findActorByIdOrError(int $actor_id): Actor
    {
        $actor = $this->em
            ->getRepository(Actor::class)
            ->findOneBy(['id' => $actor_id]);

        if ($actor  === null) {
            throw new Exception('Actor does not Exist');
        }

        return $actor;
    }
}

