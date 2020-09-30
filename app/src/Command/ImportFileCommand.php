<?php
namespace App\Command;


use App\Implementation\FileImporter;
use App\Implementation\GradeCalculator;
use App\Implementation\QuestionScoreCalculator;
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
     * @var GradeCalculator
     */
    private $gradeCalculator;
    /**
     * @var QuestionScoreCalculator
     */
    private $questionScoreCalculator;

    /**
     * ImportFileCommand constructor.
     * @param FileImporter $fileImporter
     * @param GradeCalculator $gradeCalculator
     * @param QuestionScoreCalculator $questionScoreCalculator
     */
    public function __construct(
        FileImporter $fileImporter,
        GradeCalculator $gradeCalculator,
        QuestionScoreCalculator $questionScoreCalculator
    )
    {
        Parent::__construct();

        $this->fileImporter = $fileImporter;
        $this->gradeCalculator = $gradeCalculator;
        $this->questionScoreCalculator = $questionScoreCalculator;
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

        $file = $this->fileImporter->import($filename);

        $studentResults = $this->gradeCalculator->calculateGrade($file);
        $questionResults = $this->questionScoreCalculator->calculateQuestionScores($file);

        $passedMask = "|%15.15s |%7.7s |\n";
        printf($passedMask, 'ID', 'Passed');
        foreach ($studentResults as $student => $passed) {
            printf($passedMask, $student, $passed ? 'Yes' : 'No');
        }

        // empty line for clarity
        $output->writeln('');

//        $questionMask = "|%15.15s |%10.10s |%10.10s |\n";
//        printf($questionMask, 'Question nr.', 'P-value', 'RIT-value');
//        foreach ($result['questions'] as $student){
//            printf($questionMask, '12', '0.5', '-1');
//        }


        return Command::SUCCESS;
    }

}