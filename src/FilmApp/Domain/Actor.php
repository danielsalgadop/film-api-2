<?php

namespace FilmApp\Domain;

use \Exception;

/**
 * Actor
 */
class Actor
{
    private $id;
    private $name;

    public function __construct(string $name)
    {
        $name = $this->cleanName($name);
        $this->isValidNameOrError($name);
        $this->name = $name;
    }

    // TODO reuse this behaviour  move to general Validator
    private function isValidNameOrError($name): bool
    {
        if ($name == "") {
            throw new Exception('empty Actor Name');
        }
        return true;
    }

    // TODO reuse this behaviour  (\s* ) move to general Validator
    private function cleanName($name): string
    {
        $name = filter_var(trim($name), FILTER_SANITIZE_STRING);
        return preg_replace("/\s+/", ' ', $name);
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function toArray(): array
    {
        return [
            'id' => $this->getId(),
            'name' => $this->getName()
        ];
    }
}
