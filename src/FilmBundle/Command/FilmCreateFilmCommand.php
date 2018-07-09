<?php

namespace FilmBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use FilmApp\Application\Command\Film\CreateFilmCommand;
// use Symfony\Component\Console\Command\Command;
use \Exception;

class FilmCreateFilmCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('film:create-film')
            ->setDescription('Insert a Film')
            ->addArgument('name', InputArgument::REQUIRED, 'Title')
            ->addArgument('actor_id', InputArgument::REQUIRED, 'Actor ID in database')
            ->addArgument('descirption', InputArgument::REQUIRED, 'Actor ID in database')

        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $name = $input->getArgument('name');
        $actor_id = $input->getArgument('actor_id');
        $description = $this->cleanDescription($input->getArgument('actor_id'));
        try {
            $this->isValidActorIdOrError($actor_id);
            $this->isValidNameOrError($actor_id);
        } catch (Exception $e) {
            $output->writeln('ERROR: '.$e->getMessage());
            exit;
        }


        $command = new CreateFilmCommand((string)$name, (string)$description, (int)$actor_id);
        $handler = $this->getContainer()->get('film.command.handler.create.film');

        try {
            $handler->handle($command);
            $this->getContainer()->get('doctrine.orm.default_entity_manager')->flush();
        } catch (Exception $e) {
            $output->writeln('ERROR: '.$e->getMessage());
            exit;
        }

        $output->writeln('Film Created correctly');
    }


    // TODO reuse this behaviour move to general Validator
    public function isValidNameOrError($name): bool
    {
        if ($name == "") {
            throw new Exception('Invalid Product Name');
        }
        return true;
    }

    // TODO reuse this behaviour move to general Validator
    public function isValidActorIdOrError($actor_id): bool
    {
        $actorsEm = $this->getContainer()->get('film.repository.actor');
        if (!$actorsEm->findActorByIdOrError($actor_id)) {
            throw new Exception('Invalid Actor');
        }
        return true;
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
