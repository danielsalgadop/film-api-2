<?php

namespace FilmBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class FilmController extends Controller
{
    public function showAction($id)
    {
        return $this->render('@FilmBundleViews/film.html.twig', ['id' => $id]);
    }
}
