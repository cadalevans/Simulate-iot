<?php

namespace App\Controller;

use App\Repository\ModuleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use Symfony\UX\Chartjs\Builder\ChartBuilderInterface;
use Symfony\UX\Chartjs\Model\Chart;

class ChartjsController extends AbstractController
{
    #[Route('/chartjs', name: 'app_chartjs')]
    public function __invoke(ModuleRepository $moduleRepository, ChartBuilderInterface $chartBuilder): Response
    {
        // Retrieve the current user
        $currentUser = $this->getUser();
        if (!$currentUser) {
            // Handle case where user is not logged in
            // For example, redirect to login page
        }
        
        // Retrieve the modules created by the current user
        $modules = $moduleRepository->findBy(['user' => $currentUser]);
    
        // Prepare data for the charts
        $charts = [];
    
        // Iterate through each module to retrieve data and create charts
        foreach ($modules as $module) {
            // Retrieve data associated with the module
            $moduleData = $module->getData();
    
            // Prepare data points for the chart
            $dataPoints = [];
            $measuredValues = [];
            $temperatures = [];
            $speeds = [];
    
            // Extract data for y-axis
            foreach ($moduleData as $data) {
                $dataPoints[] = $data->getWorkingTime()->format('Y-m-d H:i:s'); // Keep as datetime
                $measuredValues[] = $data->getMeasuredValue(); // Measured value data
                $temperatures[] = $data->getTemperature(); // Temperature data
                $speeds[] = $data->getSpeed(); // Speed data
            }
    
            // Create chart for the module
            $chart = $chartBuilder->createChart(Chart::TYPE_LINE);
            $chart->setData([
                'labels' => $dataPoints, // X-axis labels (timestamps)
                'datasets' => [
                    [
                        'label' => 'Measured Value',
                        'backgroundColor' => 'rgba(100, 90, 96, 0.4)',
                        'borderColor' => 'rgb(123, 110, 75)',
                        'data' => $measuredValues, // Measured value data
                        'tension' => 0.25,
                    ],
                    [
                        'label' => 'Temperature',
                        'backgroundColor' => 'rgba(203, 76, 132, 0.4)',
                        'borderColor' => 'rgb(255, 99, 132)',
                        'data' => $temperatures, // Temperature data
                        'tension' => 0.25,
                    ],
                    [
                        'label' => 'Speed',
                        'backgroundColor' => 'rgba(45, 220, 126, .4)',
                        'borderColor' => 'rgba(45, 220, 126)',
                        'data' => $speeds, // Speed data
                        'tension' => 0.25,
                    ],
                ],
            ]);
    
            $chart->setOptions([
                // set title plugin
                'plugins' => [
                    'title' => [
                        'display' => true,
                        'text' => sprintf(
                            'Modules statistic chart from %dmya to %dmya',
                            abs($data->getTemperature()),
                            abs($data->getSpeed())
                        ),
                    ],
                    'legend' => [
                        'labels' => [
                            'boxHeight' => 20,
                            'boxWidth' => 50,
                            'padding' => 20,
                            'font' => [
                                'size' => 14,
                            ],
                        ],
                    ],
                ],
                'elements' => [
                    'line' => [
                        'borderWidth' => 5,
                        'tension' => 0.25,
                        'borderCapStyle' => 'round',
                        'borderJoinStyle' => 'round',
                    ],
                ],
                'maintainAspectRatio' => false,
            ]);
            // Add the chart to the list
            $charts[] = $chart;
        }
    
        return $this->render('chartjs/index.html.twig', [
            'charts' => $charts,
        ]);
    }
    
    
}