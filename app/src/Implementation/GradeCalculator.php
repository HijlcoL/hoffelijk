<?php


namespace App\Implementation;


use PhpOffice\PhpSpreadsheet\Worksheet\Row;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class GradeCalculator
{
    /**
     * @var int
     */
    private $maxPoints;

    /**
     * @param Worksheet $sheet
     */
    public function calculateGrade(Worksheet $sheet)
    {
        $rows = [];
        foreach ($sheet->getRowIterator() as $row) {
            if ($row->getRowIndex() === 1) {
                continue;
            }

            if ($row->getRowIndex() === 2) {
                $this->calculateTestScore($row);
                continue;
            }

            $rows += $this->getValuesFromRow($row);
        }

        return $rows;

    }

    private function getValuesFromRow(Row $row)
    {
        $result = [];
        $student = null;
        $score = 0;
        $numberOfQuestion = 0;

        foreach ($row->getCellIterator() as $cell) {
            if ($cell->getColumn() === 'A') {
                $student = $cell->getValue();
                continue;
            }

            $score += $cell->getValue();
            $numberOfQuestion++;
        }

        $passed = $this->hasPassingGrade($score);

        return [$student => $passed];
    }

    private function hasPassingGrade(int $score)
    {
        $grade = ($score / $this->maxPoints) * 100;

        if ($grade >= 70) {
            return true;
        }
        return false;
    }

    private function calculateTestScore(Row $row)
    {
        $maxPoints = 0;
        $numberOfQuestion = 0;
        foreach ($row->getCellIterator() as $cell) {
            if ($cell->getColumn() === 'A') {
                continue;
            }

            $maxPoints += $cell->getValue();
        }

        $this->maxPoints = $maxPoints;
    }
}