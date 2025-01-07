<?php

namespace app\libs\report;

use Dompdf\Dompdf;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Style;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

final class ReportGenerator
{
    private Dompdf $dompdf;

    public function __construct()
    {
        $this->dompdf = new Dompdf();
    }

    /**
     * Generates a PDF report.
     *
     * @param string $title The title of the report.
     * @param array $headers Column headers for the table.
     * @param array $rows Data rows for the table.
     * @param string $fileName Name of the output file.
     * @param array $options Additional options like paper size and orientation.
     */
    public function generatePDF(string $title, array $headers, array $rows, string $fileName = 'report.pdf', array $options = []): void
    {
        $html = $this->buildHtml($title, $headers, $rows);

        $this->dompdf->loadHtml($html);
        $this->dompdf->setPaper($options['paperSize'] ?? 'A4', $options['orientation'] ?? 'portrait');
        $this->dompdf->render();

        $this->streamFile($fileName);
    }

    /**
     * Builds the HTML structure for the report.
     *
     * @param string $title The title of the report.
     * @param array $headers Column headers for the table.
     * @param array $rows Data rows for the table.
     * @return string The generated HTML.
     */
    private function buildHtml(string $title, array $headers, array $rows): string
    {
        $html = "<h1>{$title}</h1>";
        $html .= '<table border="1" cellspacing="0" cellpadding="5">';
        $html .= '<thead><tr>';

        foreach ($headers as $header) {
            $html .= '<th>' . htmlspecialchars($header) . '</th>';
        }
        $html .= '</tr></thead><tbody>';

        foreach ($rows as $row) {
            $html .= '<tr>';
            foreach ($row as $cell) {
                $html .= '<td>' . htmlspecialchars($cell) . '</td>';
            }
            $html .= '</tr>';
        }
        $html .= '</tbody></table>';

        return $html;
    }

    /**
     * Streams the generated PDF file to the browser.
     *
     * @param string $fileName Name of the output file.
     */
    private function streamFile(string $fileName): void
    {
        $this->dompdf->stream($fileName, ['Attachment' => 0]);
    }

    public function generateExcel(string $title, array $headers, array $rows, string $fileName = 'report.xlsx'): void
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Set title and apply bold font
        $sheet->setCellValue('A1', $title);
        $sheet->getStyle('A1')->getFont()->setBold(true);

        // Set headers
        $column = 'A';
        foreach ($headers as $header) {
            $sheet->setCellValue($column . '2', $header);
            $column++;
        }

        // Apply borders to the header row
        $headerRange = 'A2:' . chr(64 + count($headers)) . '2'; // Based on the number of headers
        $this->applyBorders($sheet, $headerRange);

        // Set data rows
        $rowNumber = 3;
        foreach ($rows as $row) {
            $column = 'A';
            foreach ($row as $cell) {
                $sheet->setCellValue($column . $rowNumber, $cell);
                $column++;
            }
            $rowNumber++;
        }

        // Apply borders to the data rows
        $dataRange = 'A3:' . chr(64 + count($headers)) . ($rowNumber - 1); // From A3 to the last data row
        $this->applyBorders($sheet, $dataRange);

        // Adjust columns to fit content
        foreach (range('A', chr(64 + count($headers))) as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        // Write Excel file to browser
        $writer = new Xlsx($spreadsheet);
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $fileName . '"');
        header('Cache-Control: max-age=0');
        $writer->save('php://output');
    }

    /**
     * Apply borders to a given range of cells.
     * 
     * @param \PhpOffice\PhpSpreadsheet\Worksheet\Worksheet $sheet
     * @param string $range The cell range (e.g., 'A2:C5')
     */
    private function applyBorders($sheet, $range): void
    {
        $styleArray = [
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['argb' => '00000000'], // Black color for borders
                ],
            ],
        ];
        $sheet->getStyle($range)->applyFromArray($styleArray);
    }
}
