<?php
namespace App\Command;


use App\Implementation\FileImporter;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class ImportFileCommand extends Command
{


    protected static $defaultName = 'hoffelijk:import';
    /**
     * @var FileImporter
     */
    private $fileImporter;

    /**
     * ImportFileCommand constructor.
     * @param FileImporter $fileImporter
     */
    public function __construct(
        FileImporter $fileImporter
    )
    {
        Parent::__construct();

        $this->fileImporter = $fileImporter;
    }

    protected function configure()
    {
        $this
            ->setName('hoffelijk:import')
            ->setDescription('Import score card and get a result.')
            ->addOption('file', 'f', InputOption::VALUE_REQUIRED, 'File to import', null);
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $filename = $input->getOption('file');
        $output->writeln('Importing file: ' . $filename);

        // empty line for clarity
        $output->writeln('');

        $result = $this->fileImporter->import($filename);

        $passedMask = "|%15.15s |%7.7s |\n";
        printf($passedMask, 'ID', 'Passed');
        foreach ($result['students'] as $student){
            printf($passedMask, 'Student 0012', 'Yes');
        }

        // empty line for clarity
        $output->writeln('');

        $questionMask = "|%15.15s |%10.10s |%10.10s |\n";
        printf($questionMask, 'Question nr.', 'P-value', 'RIT-value');
        foreach ($result['questions'] as $student){
            printf($questionMask, '12', '0.5', '-1');
        }


        return Command::SUCCESS;
    }

}