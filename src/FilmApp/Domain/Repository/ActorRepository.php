<?php

namespace FilmApp\Domain\Repository;

use FilmApp\Domain\Actor;

interface ActorRepository
{
    public function save(Actor $actor);
    public function delete(int $actor_id): void;
    public function findActorByIdOrError(int $actor_id): Actor;
}
