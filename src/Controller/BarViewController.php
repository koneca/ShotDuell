<?php

namespace App\Controller;
use App\Entity\ShotsTeam;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;

class BarViewController extends AbstractController
{
    private $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    public function renderBarView(EntityManagerInterface $em): Response
    {
        $repository = $em->getRepository(ShotsTeam::class);
        $teams = $repository->findAllOrdered();

	// shorten teamnames
        foreach($teams as $team)
	{
            if(10 < strlen( $currTeam = $team->getTeamName()))
            {
                // $currTeam = substr($currTeam, 0, 10) . "...";//"<br>".substr($currTeam, 10);
                $team->setTeamName($currTeam);
	    }
        } 

        return $this->render('barView.html.twig', [
            'teams' => $teams
        ]);
    }
};
?>
