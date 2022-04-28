<?php

namespace App\Command;

use App\Service\ClientRequestService;
use App\Service\StorageService;
use App\Storage\SqlStorage;
use App\Storage\StorageManager;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'WeatherCommand',
    description: 'Add a short description for your command',
)]
class WeatherCommand extends Command
{
    private ClientRequestService $clientRequestService;
    private StorageManager $storageManager;

    public function __construct(
        ClientRequestService $clientRequestService,
        StorageManager $storageManager,
        string $name = null
    ) {
        $this->storageManager = $storageManager;
        $this->clientRequestService = $clientRequestService;
        parent::__construct($name);
    }

    protected function configure(): void
    {
        $this
            ->addArgument('name', InputArgument::IS_ARRAY, 'Argument description')
            ->addOption('nb_pages', null, InputOption::VALUE_OPTIONAL, 'Option description')
            ->addOption('limit', null, InputOption::VALUE_OPTIONAL, 'Option description')
            ->addOption('api', null, InputOption::VALUE_OPTIONAL, 'C\'est quoi l\'api')
            ->addOption('storage', 'storage', InputOption::VALUE_NONE, 'Storage ou pas ?')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $fields = [];
        $name = $input->getArgument('name');
        $storage = $input->getOption('storage');

        foreach ($name as $argument) {
            [$key, $value] = explode('=', $argument);
            $fields[$key] = $value;
        }

        $response = $this->clientRequestService->request($fields);
        //$this->storageService->execute($response, $storage);
        $this->storageManager->getHandler(SqlStorage::NAME, SqlStorage::class)->saveArray($response);

        // itialise le helper
        $helper = $this->getHelper('question');
        // créer la question
        $question = new Question('Donne moi une date au format YYYY-mm-dd', '');

        if ($input->getOption('api')) {
            // tu fais un fetch de l'api avec un switch en fonction de l'option
        }

        // pose la question
        try {
            new \DateTimeImmutable($helper->ask($input, $output, $question));
        }  catch (\Exception $e) {
            $io->error('Et dommage !');
            return Command::FAILURE;
        }

        $io->success('C\'est pas trop mal');
        return Command::SUCCESS;
    }
}
