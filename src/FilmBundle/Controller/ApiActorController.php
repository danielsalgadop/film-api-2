<?php

namespace FilmBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use FilmApp\Application\Command\Actor\CreateActorCommand;
use FilmApp\Application\CommandHandler\Actor\CreateActorCommandHandler;
use FilmBundle\Repository\MySQLActorRepository;

use \Exception;

class ApiActorController extends Controller
{
    public function createAction(Request $request): JsonResponse
    {
        $json = json_decode($request->getContent(), true);

        $command = new CreateActorCommand((string)$json['name']);
        $handler = $this->get('film.command.handler.create.owner');

        try {
            $handler->handle($command);
            $this->get('doctrine.orm.default_entity_manager')->flush();
        } catch (Exception $e) {
            return new JsonResponse(['error' => $e->getMessage()], 400);
        }
        return new JsonResponse(['success' => "Actor Created Correctly"], 200);
    }
}
