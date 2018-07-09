<?php

namespace FilmApp\Application\Command\Film;

class CreateFilmCommand
{
    private $name;
    private $description;
    private $actor_id;

    public function __construct(string $name, string $description, int $actor_id)
    {
        $this->name = $name;
        $this->description = $description;
        $this->actor_id = $actor_id;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function getActorId()
    {
        return $this->actor_id;
    }
}
