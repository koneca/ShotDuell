<?php
//src/EveltListener/TeamChangedListener.php
namespace App\EventListener;

use App\Entity\SaufiTeam;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Symfony\Component\HttpFoundation\Response;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Mercure\HubInterface;
use Symfony\Component\Mercure\Update;

class TeamChangedNotifier
{
    private $logger;
    private $hub;

    public function __construct(LoggerInterface $logger, HubInterface $hub)
    {
        $this->logger = $logger;
        $this->hub = $hub;
    }

    public function teamUpdated(SaufiTeam $team, LifecycleEventArgs $event )
    {
        $this->logger->error("got some Event11".get_class($event));

        // $update = new Update(
        //     'home',
        //     json_encode(['team' => 'noumba1'])
        // );

        // $this->hub->publish($update);


        // return new RedirectResponse($this->urlGenerator->generate('new_team'));
    }
}

?>