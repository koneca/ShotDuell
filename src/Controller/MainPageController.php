<?php

namespace App\Controller;
use App\Entity\SaufiTeam;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;
use App\EventListener\TeamChangedNotifier;

class MainPageController extends AbstractController
{
    private $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    public function renderMainPage(EntityManagerInterface $em): Response
    {
        $number = random_int(0, 100);

        $repository = $em->getRepository(SaufiTeam::class);
        $teams = $repository->findAll();

        foreach($teams as $team)
        {
            if(10 < strlen( $currTeam = $team->getTeamName()))
            {
                $currTeam = substr($currTeam, 0, 10) . "...";//"<br>".substr($currTeam, 10);
                $team->setTeamName($currTeam);
            }
             
        } 

        return $this->render('mainPage.html.twig', [
            'number' => $number,
            'teams' => $teams
        ]);
    }

    public function reload()
    {
        $messageGenerator = $this->get(TeamChangedNotifier::class);
        $this->logger->warning("got some team increase: düüüt");
    }
};
?>