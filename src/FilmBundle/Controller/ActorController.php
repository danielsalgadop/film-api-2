<?php

namespace FilmBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ActorController extends Controller
{
    public function showAction($id)
    {
        return $this->render('@FilmBundleViews/actor.html.twig', ['id' => $id]);

        // return $this->render('FilmBundle:Default:index.html.twig');
    }
}
