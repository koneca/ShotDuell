<?php

namespace App\Entity;

use App\Repository\ShotsTeamRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ShotsTeamRepository::class)]
class ShotsTeam
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 100)]
    private $teamName;

    #[ORM\Column(type: 'string', length: 8)]
    private $color;

    #[ORM\Column(type: 'smallint', options: ['default' => '0'])]
    private $shotsCount;

    #[ORM\Column(type: 'datetime', options: ['default'=> 'CURRENT_TIMESTAMP'])]
    private $created;

    #[ORM\Column(type: 'datetime', nullable: true)]
    private $shotTime;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTeamName(): ?string
    {
        return $this->teamName;
    }

    public function setTeamName(string $teamName): self
    {
        $this->teamName = $teamName;

        return $this;
    }

    public function getColor(): ?string
    {
        return $this->color;
    }

    public function setColor(string $color): self
    {
        $this->color = $color;

        return $this;
    }

    public function getShotsCount(): ?int
    {
        return $this->shotsCount;
    }
    
    public function increaseShotsCount(): self
    {
        $this->shotsCount++;

        return $this;
    }

    public function setShotsCount(int $shotsCount): self
    {
        $this->shotsCount = $shotsCount;

        return $this;
    }

    public function getCreated(): ?\DateTimeInterface
    {
        return $this->created;
    }

    public function setCreated(\DateTimeInterface $created): self
    {
        $this->created = $created;

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