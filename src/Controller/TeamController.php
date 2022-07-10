<?php

namespace App\Controller;
use App\Entity\SaufiTeam;
use App\Form\TeamFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\Mercure\HubInterface;

class TeamController extends AbstractController
{
    private $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }
    public function renderNewTeam(Request $request, EntityManagerInterface $em): Response
    {
        $team = new SaufiTeam();
        $newTeamForm = $this->createForm(TeamFormType::class, $team);

        $newTeamForm->handleRequest($request);

        if ($newTeamForm->isSubmitted() && $newTeamForm->isValid()) {

            $data = $newTeamForm->getData();
            $team->setTeamName($data->getTeamName());
            $team->setColor(strval($data->getColor()));
            $team->setCreated(new \DateTime());
            $team->setShotsCount(0);

            $repository = $em->getRepository(SaufiTeam::class);
            $repository->add($team);

            return $this->redirectToRoute('home',
                ['message' => $team->getTeamName(), 'created' => $team->getCreated()]);
        }

        return $this->render('newTeamForm.html.twig', ['newTeam_form' => $newTeamForm->createView()]);
    }
    
    public function increaseShotsOfTeam(SaufiTeam $teamName, EntityManagerInterface $em)
    {
        $teamName->increaseShotsCount();
        $repository = $em->getRepository(SaufiTeam::class);
        $repository->update($teamName);
        $this->logger->warning("got some team increase: ".$teamName->getShotsCount());
        return $this->redirectToRoute('home');
    }

    /**
     * @throws \JsonException
     */
    #[Route("auctions/{id}/bid", name: "make-bid", methods: ["POST"])]
    public function __invoke(Request $request, HubInterface $hub): Response
    {
        $auctionId = $request->attributes->get('id');
        $body = json_decode($request->getContent(), true, 512, JSON_THROW_ON_ERROR);

        Assert::keyExists($body, 'bid');
        $winnerBid = $body['bid'];

        try {
            $update = new Update(
                'auctions-' . $auctionId,
                json_encode([
                    'winnerBid' => $winnerBid
                ], JSON_THROW_ON_ERROR)
            );

            $hub->publish($update);
        } catch (\Exception $e) {
            die($e->getMessage());
        }

        return new Response('published!');
    }
}
?>