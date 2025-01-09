<?php

namespace App\Controller;
use App\Entity\ShotsTeam;
use App\Entity\ShotsStatistics;
use App\Form\TeamFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class TeamController extends AbstractController
{
    private $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    public function renderNewTeam(Request $request, EntityManagerInterface $em): Response
    {
        $team = new ShotsTeam();
        $repository = $em->getRepository(ShotsTeam::class);
        $teams = $repository->findAll();
        $newTeamForm = $this->createForm(TeamFormType::class, $team);

        $newTeamForm->handleRequest($request);

        if ($newTeamForm->isSubmitted() && $newTeamForm->isValid()) {

            $data = $newTeamForm->getData();
            $team->setTeamName($data->getTeamName());

 
            $team->setColor($this->determineTeamColor(strval($data->getColor()), $teams));
            $team->setCreated(new \DateTime());
            $team->setShotsCount(0);

            $repository->add($team);

	    //return $this->redirect($request->headers->get('referer'));
            return $this->redirectToRoute('bar_view', [
                'message' => $team->getTeamName(),
                'created' => $team->getCreated()
            ],);
        }

        return $this->render('newTeamForm.html.twig', [
            'newTeam_form' => $newTeamForm->createView(),
            'teams' => $teams
        ]);
    }

    private function determineTeamColor(string $color, $teams) : string
    {
        if( "#000000" == $color)
        {
            $rColor = strval(dechex(rand(0,255)));
            $gColor = strval(dechex(rand(0,255)));
            $bColor = strval(dechex(rand(0,255)));
            $color = "#".$rColor.$gColor.$bColor;
        }

        return $color;
    }

    public function renderDeleteTeam(Request $request, ShotsTeam $team, EntityManagerInterface $em)
    {
        $repository = $em->getRepository(ShotsTeam::class);
        $teamId = $team->getId();
        $repository->remove($team);
        $em->flush();

        $repository = $em->getRepository(ShotsStatistics::class);
        $repository->remove($teamId);
        $em->flush();
        return $this->redirect($request->headers->get('referer'));
    }
    
    public function increaseShotsOfTeam(ShotsTeam $team, EntityManagerInterface $em)
    {
        $team->increaseShotsCount();
        $team->setShotTime(new \DateTime());
        $repository = $em->getRepository(ShotsTeam::class);
        $repository->update($team);

        $stat = new ShotsStatistics();
        $stat->setShotsTeamId($team->getId());
        $stat->setShotTime(new \DateTime());
        $stat->setShotsCount($team->getShotsCount());
        $repository = $em->getRepository(ShotsStatistics::class);
        $repository->add($stat);
        
        $this->logger->warning("got some team increase: ".$team->getShotsCount());
        return $this->redirectToRoute('home');
    }

    public function getUpdatedTeams(Request $request, EntityManagerInterface $em) : response
    {
        $repository = $em->getRepository(ShotsTeam::class);
        $teams = $repository->findAllOrdered();
	$teamsArray = [];
	$count = 0;

        foreach($teams as $team)
	{
	//    if($count == 10)
	    {
	//        break;
	    }
	    array_push($teamsArray, [$team->getId(), $team->getShotsCount()]);
	//    $count++;
        }
        return new JsonResponse($teamsArray);
    }
}
?>
