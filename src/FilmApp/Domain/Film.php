<?php

namespace FilmApp\Domain;

use FilmApp\Domain\Actor;
// use Doctrine\ORM\Mapping as ORM;
use \Exception;

class Film
{
    private $id;
    private $name;
    private $description;
    private $actor;

    public function __construct(string $name, string $description, Actor $actor)
    {
        // Sanitize
        $name = $this->cleanName($name);
        $description = $this->cleanDescription($description);

        // Validate
        $this->isValidNameOrError($name);
        // $this->isValidDescriptionOrError($description);

        $this->name = $name;
        $this->description = $description;
        $this->actor = $actor;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function setDescription($description)
    {
        $this->description = $description;
    }

    public function getActor()
    {
        return $this->actor;
    }

    public function setActor($actor)
    {
        $this->actor = $actor;
    }

    // TODO reuse this behaviour move to general Validator
    public function isValidNameOrError($name): bool
    {
        if ($name == "") {
            throw new Exception('Invalid Product Name');
        }
        return true;
    }
    public function toArray(): array
    {
        return [
            'id' => $this->getId(),
            'name' => $this->getName(),
            'description' => $this->getDescription(),
            'actor_id' => $this->actor->getId(),
        ];
    }


    // TODO reuse this behaviour  (\s* ) move to general Validator
    private function cleanName($name): string
    {
        $name = filter_var(trim($name), FILTER_SANITIZE_STRING);
        return preg_replace("/\s+/", ' ', $name);
    }

    // TODO reuse this behaviour  (\s* ) move to general Validator
    private function cleanDescription($description): string
    {
        $description = filter_var(trim($description), FILTER_SANITIZE_STRING);
        return preg_replace("/\s+/", ' ', $description);
    }
}
