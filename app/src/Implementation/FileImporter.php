<?php
namespace App\Implementation;

use PhpOffice\PhpSpreadsheet\Reader\Xlsx;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Yectep\PhpSpreadsheetBundle\Factory;

class FileImporter
{
    /**
     * @var Factory
     */
    private $spreadsheet;

    /**
     * FileImporter constructor.
     * @param Factory $spreadsheet
     */
    public function __construct(
        Factory $spreadsheet
    )
    {
        $this->spreadsheet = $spreadsheet;
    }

    /**
     * @param string $filename
     * @return Worksheet
     */
    public function import(string $filename): Worksheet
    {
        /** @var Xlsx $xlsxReader */
        $xlsxReader = $this->spreadsheet->createReader('Xlsx');

        return $xlsxReader->load($filename)->getActiveSheet();
    }
}