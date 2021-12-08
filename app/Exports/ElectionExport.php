<?php

namespace App\Exports;

use App\Models\Election;
use App\Models\Vote;
use App\Models\Configuration\Section;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithCharts;
use PhpOffice\PhpSpreadsheet\Chart\Chart;
use PhpOffice\PhpSpreadsheet\Chart\DataSeries;
use PhpOffice\PhpSpreadsheet\Chart\DataSeriesValues;
use PhpOffice\PhpSpreadsheet\Chart\Legend;
use PhpOffice\PhpSpreadsheet\Chart\PlotArea;
use PhpOffice\PhpSpreadsheet\Chart\Title;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class ElectionExport implements FromView, WithStyles, ShouldAutoSize/* , WithCharts */
{
    public function __construct($electionID)
    {
        $this->election = Election::find($electionID);
    }
    /**
    * @return \Illuminate\Support\Collection
    */
    /* public function collection()
    {
        return Election::all();
    } */

    /* public function charts()
    {
        $evaluationClass = EvaluationClasses::find($this->evaluationClassID);
        $label = [
            new DataSeriesValues('String', 'Worksheet!$B$1', null, 1),
            new DataSeriesValues('String', 'Worksheet!$C$1', null, 1),
            new DataSeriesValues('String', 'Worksheet!$D$1', null, 1),
            new DataSeriesValues('String', 'Worksheet!$E$1', null, 1)
        ];
        $categories = [
            new DataSeriesValues('String', 'Worksheet!$A$2:$A$6', null, 5),
            new DataSeriesValues('String', 'Worksheet!$A$2:$A$6', null, 5),
            new DataSeriesValues('String', 'Worksheet!$A$2:$A$6', null, 5),
            new DataSeriesValues('String', 'Worksheet!$A$2:$A$6', null, 5),
            new DataSeriesValues('String', 'Worksheet!$A$2:$A$6', null, 5)
        ];
        $values = [
            new DataSeriesValues('Number', 'Worksheet!$B$2:$B$6', null, 5),
            new DataSeriesValues('Number', 'Worksheet!$C$2:$C$6', null, 5),
            new DataSeriesValues('Number', 'Worksheet!$D$2:$D$6', null, 5),
            new DataSeriesValues('Number', 'Worksheet!$E$2:$E$6', null, 5)
        ];

        $series = new DataSeries(DataSeries::TYPE_BARCHART, DataSeries::GROUPING_STANDARD,
            range(0, \count($values) - 1), $label, $categories, $values);
        $plot   = new PlotArea(null, [$series]);

        $legend = new Legend();
        $chart  = new Chart($evaluationClass->class->faculty->fullname('').' Evaluation Chart', new Title($evaluationClass->class->faculty->fullname('').' | '.$evaluationClass->class->course->course_code.' - '.$evaluationClass->class->course->title), $legend, $plot);

        $chart->setTopLeftPosition('G8');
        $chart->setBottomRightPosition('W25');

        return $chart;
    } */

    public function styles(Worksheet $sheet)
    {
        /* $election = $this->election;
        $votes = Vote::where('election_id', $this->election->id)->get();
        $colums = "BCDEFGHIJKLMNOPQRSTUVWXYZ"; */
        $gradeLevels = Section::get()->groupBy('grade_level');
        $sheet->getStyle('1')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('1')->getFont()->setBold(true);
        $sheet->getStyle('1')->getFont()->setSize(14);
        $sheet->getStyle('A1')->getFont()->setSize(11);
        $sheet->getColumnDimension('A')->setAutoSize(false);
        $sheet->getColumnDimension('A')->setWidth(2.7,'px');
        $rowCount = 2;
        foreach ($gradeLevels as $gradeLevel => $sections){
            // grade levels row
            $sheet->getStyle('A'.$rowCount)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle('A'.$rowCount)->getFont()->setBold(true);
            $rowCount += 1;
            foreach ($sections as $section) {
                // sections row
                // students row B:3-B:4....
                $sheet->getStyle('A'.$rowCount)->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
                $sheet->getStyle('A'.$rowCount)->getAlignment()->setTextRotation(90);
                $sheet->getStyle('A'.$rowCount)->getFont()->setBold(true);
                // $sheet->getStyle('A'.$rowCount)->getFont()->setSize();
                $rowCount += $section->students->count();
                /* foreach ($section->students as $student){
                } */
            }
        }
        /* $sheet->getStyle('1')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('2')->getFont()->setBold(true);
        $sheet->getStyle('2')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER); */
        /* $colums = "BCDEFGHIJKLMNOPQRSTUVWXYZ";
        return [
            // Style the first row as bold text.
            1    => [
                'font' => [
                    'bold' => true,
                    'size' => 14
                ],
                'alignment' => [
                    'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                ]
            ],
            2    => [
                'font' => [
                    'bold' => true
                ],
                'alignment' => [
                    'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                ]
            ],
            // Styling an entire column.
            // 'A'  => ['font' => ['bold' => true]],
        ]; */
    }

    public function view(): View
    {
        return view('elections.export', [
            'election' => $this->election,
            'votes' => Vote::where('election_id', $this->election->id)->get(),
            'gradeLevels' => Section::get()->groupBy('grade_level'),
        ]);
    }
}
