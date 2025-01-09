<?php

namespace App\Controller;
use Symfony\UX\Chartjs\Builder\ChartBuilderInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\UX\Chartjs\Model\Chart;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\ShotsStatistics;
use App\Entity\ShotsTeam;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;

class ChartController extends AbstractController
{
    private $logger;

    public function chartShow(ChartBuilderInterface $chartBuilder, EntityManagerInterface $em, LoggerInterface $logger): Response
    {
        $this->logger = $logger;
        $data = $this->generateData($em);
        $chart = $chartBuilder->createChart(Chart::TYPE_LINE);

        $chart->setData([
            // 'labels' => $labels,
            'datasets' => $data]);

        $chart->setOptions([
            'scales' => [
                'y' => [
                    'suggestedMin' => 0,
                    'suggestedMax' => 60,
                    'ticks' => [
                        'font' => [
                            'size' => 40,
                            'color' => 'rgb(255, 255, 255)',
                        ],
                    ],
                ],
                'xAxes' => [
                    'ticks' => [
                        'font' => [
                            'size' => 40,
                        ],
                    ],
                    ['type' => 'time'],
                    ['time' =>
                        [
                        'unit' => 'hour',
                        'unitStepSize' => 1,
                        'displayFormats' =>
                            [
                                'minute' => 'HH mm',
                                'hour' => 'MMM DD',
                            ]
                        ],
                    ],
                ],
            ],
            'plugins' => [
                'legend' => [
                    'labels' => [
                        'font' => [
                            'size' => 24,
                        ],
                        ['color' => 'white'],
                    ],
                ],
            ],
        ]);

        return $this->render('chartShow.html.twig', [
            'chart' => $chart,
        ]);
    }

    private function generateData(EntityManagerInterface $em)
    {
        
        $repository = $em->getRepository(ShotsTeam::class);
        $teams = $repository->findAll();

        $result = [];

        foreach($teams as $team)
        {
            $teamArray = [
                'label' => $team->getTeamName(),
                'backgroundColor' => $team->getColor(),
                'borderColor' => $team->getColor(),
                'borderWidth' => '4',
                'pointRadius' => '5',
                'data' => []
            ];

            $repository = $em->getRepository(ShotsStatistics::class);
            $shots = $repository->findByTeamId($team->getId());
    
            foreach($shots as $shot)
            {
                array_push($teamArray['data'], ['x' => $shot->getShotTime()->format('H:m-i'), 'y' => $shot->getShotsCount()]);
            }
            array_push($result, $teamArray);
        } 

       //var_dump($result);

        return $result;
    }
}


?>