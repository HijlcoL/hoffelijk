<?php


namespace App\Implementation;


use PhpOffice\PhpSpreadsheet\Worksheet\Column;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class QuestionScoreCalculator
{

    /**
     * @var int
     */
    private $highestRow;

    public function calculateQuestionScores(Worksheet $file)
    {
        $this->highestRow = $file->getHighestDataRow() - 2;

        foreach ($file->getColumnIterator() as $column) {
            if ($column->getColumnIndex() === "A") {
                continue;
            }

            $this->getScoresPerQuestion($column);


        }
        die();
    }

    private function getScoresPerQuestion(Column $column)
    {
        $question = null;
        foreach ($column->getCellIterator() as $cell) {
            if ($cell->getRow() === 1) {
                $question = $cell->getValue();
                break;
            }
        }
        dump($question);
        $pValue = $this->calculatePValue($column);
        dump($pValue);
    }

    private function calculatePValue(Column $column)
    {
        $maxScore = 0;
        $studentResults = 0;
        foreach ($column->getCellIterator() as $cell) {
            if ($cell->getRow() === 1) {
                continue;
            }

            if ($cell->getRow() === 2) {
                $maxScore = $cell->getValue();
                continue;
            }

            $studentResults += $cell->getValue();
        }

        $maxResult = ($maxScore * $this->highestRow);
        $averageScore = ($studentResults / $this->highestRow);
        $pValue = ($averageScore / $maxResult);

        return $pValue;


    }
}