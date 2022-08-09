<?php

namespace App\Entity;

use App\Repository\ShotsStatisticsRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ShotsStatisticsRepository::class)]
class ShotsStatistics
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'smallint', nullable: false)]
    private $teamId;

    #[ORM\Column(type: 'smallint', options: ['default' => '0'])]
    private $shotsCount;

    #[ORM\Column(type: 'datetime', nullable: true)]
    private $shotTime;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getShotsTeamId(): ?int
    {
        return $this->steamId;
    }

    public function setShotsTeamId(int $teamId): self
    {
        $this->teamId = $teamId;
        return $this;
    }

    public function getShotsCount(): ?int
    {
        return $this->shotsCount;
    }

    public function setShotsCount(int $shotsCount): self
    {
        $this->shotsCount = $shotsCount;

        return $this;
    }

    public function getShotTime(): ?\DateTimeInterface
    {
        return $this->shotTime;
    }

    public function setShotTime(?\DateTimeInterface $shotTime): self
    {
        $this->shotTime = $shotTime;
        return $this;
    }

}

?>