<?php

namespace App\Charts;

use ArielMejiaDev\LarapexCharts\DonutChart;
use ArielMejiaDev\LarapexCharts\LarapexChart;
use ArielMejiaDev\LarapexCharts\PieChart;

class DashboardChart
{
    protected $chart;

    public function __construct(LarapexChart $chart)
    {
        $this->chart = $chart;
    }

    public function build(array $data): PieChart
    {
        return $this->chart->pieChart()
            ->setDataLabels(true)
            ->setWidth(300)
            ->setHeight(300)
            ->setSparkline(true)
            ->addData($data)
            ->setLabels(['Lunas', 'Belum Lunas'])
            ->setColors(['#28a745', '#dc3545']);
    }
}