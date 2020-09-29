<?php
namespace App\Implementation;

use PhpOffice\PhpSpreadsheet\Reader\BaseReader;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
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

    public function import(string $filename): array
    {
        /** @var Xlsx $xlsxReader */
        $xlsxReader = $this->spreadsheet->createReader('Xlsx');
        $file = $xlsxReader->load($filename);

        dump($file);
        die();

        return [
            'students' => [],
            'questions' => []
            ];
    }
}