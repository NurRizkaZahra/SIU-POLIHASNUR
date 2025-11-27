<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Exam;
use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

class AdminResultController extends Controller
{
    private function getUniqueExams()
    {
        // Ambil hanya 1 hasil per user (hasil terbaru)
        return Exam::with(['user', 'answers.question.group'])
            ->where('status', 'completed')
            ->orderBy('created_at', 'desc')
            ->get()
            ->unique('user_id') // inilah kuncinya
            ->values()          // reset index
            ->map(function($exam) {

                $scorePU = 0;
                $scorePSI = 0;

                foreach ($exam->answers as $answer) {
                    $type = $answer->question->group ? $answer->question->group->type : 'PU';

                    if ($type == 'PU') {
                        $scorePU += $answer->score;
                    } else {
                        $scorePSI += $answer->score;
                    }
                }

                return [
                    'name' => $exam->user->name,
                    'pu'   => number_format($scorePU, 1),
                    'psi'  => number_format($scorePSI, 1),
                ];
            });
    }

    public function index()
    {
        $exams = $this->getUniqueExams();
        return view('admin.result', compact('exams'));
    }

    public function print()
    {
        $exams = $this->getUniqueExams();
        return view('admin.result-print', compact('exams'));
    }

    public function exportExcel()
    {
        $exams = $this->getUniqueExams();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Title
        $sheet->mergeCells('A1:D1');
        $sheet->setCellValue('A1', 'HASIL UJIAN PMB POLIHASNUR 2026');
        $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(14);
        $sheet->getStyle('A1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        // Header
        $sheet->setCellValue('A3', 'No');
        $sheet->setCellValue('B3', 'Nama Peserta');
        $sheet->setCellValue('C3', 'Nilai PU');
        $sheet->setCellValue('D3', 'Nilai Psikotes');

        // Style header
        $headerStyle = [
            'font' => ['bold' => true, 'color' => ['argb' => 'FFFFFFFF']],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['argb' => 'FF1E5A96']
            ],
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER]
        ];
        $sheet->getStyle('A3:D3')->applyFromArray($headerStyle);

        // Data
        $row = 4;
        foreach ($exams as $index => $exam) {
            $sheet->setCellValue('A' . $row, $index + 1);
            $sheet->setCellValue('B' . $row, $exam['name']);
            $sheet->setCellValue('C' . $row, $exam['pu']);
            $sheet->setCellValue('D' . $row, $exam['psi']);

            $sheet->getStyle('A' . $row . ':D' . $row)
                ->getAlignment()
                ->setHorizontal(Alignment::HORIZONTAL_CENTER);

            $row++;
        }

        // Auto size
        foreach(range('A','D') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        // Borders
        $styleArray = [
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                ],
            ],
        ];
        $sheet->getStyle('A3:D' . ($row - 1))->applyFromArray($styleArray);

        // Download
        $writer = new Xlsx($spreadsheet);
        $filename = 'Hasil_Ujian_' . date('Ymd_His') . '.xlsx';

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
        exit;
    }
}
