<?php

namespace App\Http\Controllers;

use App\Services\DashboardReportService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use PhpOffice\PhpPresentation\PhpPresentation;
use PhpOffice\PhpPresentation\IOFactory;
use PhpOffice\PhpPresentation\Style\Alignment;
use PhpOffice\PhpPresentation\Style\Color;
use PhpOffice\PhpPresentation\Shape\Chart\Type\Bar;
use PhpOffice\PhpPresentation\Shape\Chart\Series;

class DashboardExportController extends Controller
{
    private const BRAND = '163A5F';
    private const ACCENT = '20A486';
    private const TEXT = '243447';

    public function exportPpt(
        Request $request,
        DashboardReportService $reportService
    ) {
        // Sesuaikan dengan sistem autentikasi dan otorisasi Anda.
        // Gate::authorize('view-dashboard');

        $validated = $request->validate([
            'start' => ['required', 'date_format:Y-m-d'],
            'end' => [
                'required',
                'date_format:Y-m-d',
                'after_or_equal:start',
            ],
        ]);

        $data = $reportService->getData(
            $validated['start'],
            $validated['end']
        );

        $ppt = new PhpPresentation();

        $ppt->getLayout()->setDocumentLayout(
            \PhpOffice\PhpPresentation\DocumentLayout::LAYOUT_SCREEN_16X9
        );

        $ppt->getDocumentProperties()
            ->setCreator(config('app.name'))
            ->setTitle('Dashboard Report')
            ->setSubject('Laporan statistik dashboard');

        // SLIDE 1: Sampul
        $slide = $ppt->getActiveSlide();

        $this->addText(
            $slide,
            config('app.name'),
            60, 55, 800, 45,
            18, self::ACCENT, true
        );

        $this->addText(
            $slide,
            'DASHBOARD REPORT',
            60, 150, 850, 65,
            32, self::BRAND, true
        );

        $this->addText(
            $slide,
            'Periode: ' .
                Carbon::parse($data['start'])->format('d/m/Y') .
                ' - ' .
                Carbon::parse($data['end'])->format('d/m/Y'),
            60, 230, 850, 40,
            18, self::TEXT
        );

        $this->addFooter($slide);

        // SLIDE 2: Statistik utama
        $slide = $ppt->createSlide();

        $this->addHeader($slide, 'Ringkasan Statistik');

        $stats = [
            ['Total Data', $data['total']],
            ['Selesai', $data['selesai']],
            ['Dalam Proses', $data['proses']],
            ['Rata-rata Nilai', $data['rata_rata']],
        ];

        $xPositions = [55, 280, 505, 730];

        foreach ($stats as $index => $stat) {
            $x = $xPositions[$index];

            $this->addText(
                $slide,
                $stat[0],
                $x, 135, 200, 35,
                14, self::TEXT
            );

            $this->addText(
                $slide,
                (string) $stat[1],
                $x, 180, 200, 55,
                28, self::ACCENT, true
            );
        }

        $this->addText(
            $slide,
            'Data berdasarkan periode laporan yang dipilih.',
            55, 300, 850, 35,
            14, self::TEXT
        );

        $this->addFooter($slide);

        // SLIDE 3: Grafik tren bulanan
        $slide = $ppt->createSlide();

        $this->addHeader($slide, 'Tren Data Bulanan');

        if (count($data['labels']) > 0) {
            $chart = $slide->createChartShape();

            $chart->setName('Grafik Tren Bulanan')
                ->setOffsetX(70)
                ->setOffsetY(120)
                ->setWidth(820)
                ->setHeight(370);

            $series = new Series(
                'Jumlah Data',
                array_combine($data['labels'], $data['values'])
            );

            $series->setShowValue(true);

            $bar = new Bar();
            $bar->addSeries($series);

            $chart->getPlotArea()->setType($bar);
        } else {
            $this->addText(
                $slide,
                'Tidak ada data pada periode ini.',
                70, 170, 800, 40,
                18, self::TEXT
            );
        }

        $this->addFooter($slide);

        $writer = IOFactory::createWriter(
            $ppt,
            'PowerPoint2007'
        );

        $filename = 'dashboard-' .
            $data['start'] . '-' . $data['end'] . '.pptx';

        return response()->streamDownload(
            function () use ($writer) {
                $writer->save('php://output');
            },
            $filename,
            [
                'Content-Type' =>
                    'application/vnd.openxmlformats-officedocument.presentationml.presentation',
            ]
        );
    }

    private function addText(
        $slide,
        string $text,
        int $x,
        int $y,
        int $width,
        int $height,
        int $fontSize,
        string $color,
        bool $bold = false
    ): void {
        $shape = $slide->createRichTextShape()
            ->setOffsetX($x)
            ->setOffsetY($y)
            ->setWidth($width)
            ->setHeight($height);

        $shape->createTextRun($text)
            ->getFont()
            ->setName('Arial')
            ->setSize($fontSize)
            ->setBold($bold)
            ->setColor(new Color($color));
    }

    private function addHeader($slide, string $title): void
    {
        $this->addText(
            $slide,
            config('app.name'),
            45, 25, 400, 30,
            12, self::ACCENT, true
        );

        $this->addText(
            $slide,
            $title,
            45, 65, 850, 45,
            25, self::BRAND, true
        );
    }

    private function addFooter($slide): void
    {
        $this->addText(
            $slide,
            'CONFIDENTIAL | ' . config('app.name'),
            45, 500, 850, 25,
            9, self::TEXT
        );
    }
}