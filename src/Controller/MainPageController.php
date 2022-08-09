<?php

namespace App\Controller;
use App\Entity\ShotsTeam;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;

class MainPageController extends AbstractController
{
    private $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    public function renderMainPage(EntityManagerInterface $em): Response
    {
        $repository = $em->getRepository(ShotsTeam::class);
        $teams = $repository->findAll();

        // shorten teamnames
        foreach($teams as $team)
        {
            if(10 < strlen( $currTeam = $team->getTeamName()))
            {
                // $currTeam = substr($currTeam, 0, 10) . "...";//"<br>".substr($currTeam, 10);
                $team->setTeamName($currTeam);
            }
             
        } 

        return $this->render('mainPage.html.twig', [
            'teams' => $teams
        ]);
    }
};
?>