<?php

namespace App\Charts;

use ArielMejiaDev\LarapexCharts\LarapexChart;

class DashboardChart
{
    protected $chart;

    public function __construct(LarapexChart $chart)
    {
        $this->chart = $chart;
    }

    public function build(array $data)
    {
        if (array_sum($data) === 0) {
            return $this->chart->pieChart()
                ->setTitle('Rekapitulasi Tagihan')
                ->setSubtitle('Status Pembayaran')
                ->addData([0, 0])
                ->setLabels(['Lunas', 'Belum Lunas'])
                ->setColors(['#28a745', '#dc3545'])
                ->setHeight(400)
                ->setWidth(600)
                // ->setLegend(false)
                // ->setEmptyDataMessage('Tidak ada data tagihan untuk ditampilkan.')
            ;
        }

        return $this->chart->pieChart()
            ->setTitle('Rekapitulasi Tagihan')
            ->setSubtitle('Status Pembayaran')
            ->addData($data)
            ->setLabels(['Lunas', 'Belum Lunas'])
            ->setColors(['#28a745', '#dc3545'])
            ->setHeight(400)
            ->setWidth(600);
    }
}