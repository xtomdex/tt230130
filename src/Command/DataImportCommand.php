<?php

declare(strict_types=1);

namespace App\Command;

use App\Exception\CharacterAlreadyExists;
use App\Exception\MovieAlreadyExists;
use App\Service\DataImport\CharacterView;
use App\Service\DataImport\DataImportServiceInterface;
use App\Service\DataImport\MovieView;
use Psr\Log\LoggerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use App\UseCase\Movie\Create as MovieCreate;
use App\UseCase\Character\Create as CharacterCreate;

final class DataImportCommand extends Command
{
    public function __construct(
        private readonly DataImportServiceInterface $dataImportService,
        private readonly MovieCreate\Handler $movieCreator,
        private readonly CharacterCreate\Handler $characterCreator,
        private readonly LoggerInterface $logger
    ) {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->setName('starwars:import')
            ->setDescription('Imports movies and characters');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $movies = $this->dataImportService->getMovies();
        /** @var MovieView $movie */
        foreach ($movies as $movie) {
            try {
                $command = new MovieCreate\Command($movie->id, $movie->name);
                $this->movieCreator->handle($command);
            } catch (MovieAlreadyExists $e) {
                $this->logger->notice($e->getMessage());
            }
        }

        $characters = $this->dataImportService->getCharacters();
        /** @var CharacterView $character */
        foreach ($characters as $character) {
            try {
                $command = new CharacterCreate\Command(
                    $character->id,
                    $character->name,
                    $character->height,
                    $character->mass,
                    $character->gender,
                    $character->movies
                );
                $this->characterCreator->handle($command);
            } catch (CharacterAlreadyExists $e) {
                $this->logger->notice($e->getMessage());
            }
        }

        $output->writeln('<info>Data is imported!</info>');

        return Command::SUCCESS;
    }
}
