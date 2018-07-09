<?php

namespace FilmBundle\Event;

use Symfony\Component\EventDispatcher\Event;

class AfterCreateFilmEvent extends Event
{
    public function __construct($cache)
    {
        $cache->clean();
    }
}
