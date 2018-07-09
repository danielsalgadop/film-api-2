<?php

namespace FilmBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use FilmApp\Application\Command\Film\CreateFilmCommand;
use FilmApp\Application\CommandHandler\Film\CreateFilmCommandHandler;
use FilmApp\Application\CommandHandler\Film\ReadFilmCommandHandler;
use FilmBundle\Repository\MySQLFilmRepository;

use \Exception;

class ApiFilmController extends Controller
{
    public function createAction(Request $request): JsonResponse
    {
        $json = json_decode($request->getContent(), true);

        $command = new CreateFilmCommand((string)$json['name'], (string)$json['description'], (int)$json['actor_id']);
        $handler = $this->get('film.command.handler.create.film');

        try {
            $handler->handle($command);
            $this->get('doctrine.orm.default_entity_manager')->flush();
        } catch (Exception $e) {
            return new JsonResponse(['error' => $e->getMessage()], 400);
        }
        return new JsonResponse(['success' => "Film Created Correctly"], 200);
    }

    public function readAction(int $id)
    {
        $handler = $this->get('film.command.handler.read.film');
        try {
            $film = $handler->handle($id);
        } catch (Exception $e) {
            return new JsonResponse(['error' => $e->getMessage()], 400);
        }
        return new JsonResponse($film->toArray());
    }
}
