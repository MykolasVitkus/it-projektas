<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TicketRepository")
 */
class Ticket
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=0)
     */
    private $price;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="tickets")
     * @ORM\JoinColumn(nullable=false)
     */
    private $owner;

    /**
     * @ORM\ManyToOne(targetEntity="FilmShow", inversedBy="tickets")
     * @ORM\JoinColumn(nullable=false)
     */
    private $filmShow;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $refunded;

    public function __toString()
    {
        return (string)$this->id;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPrice(): ?string
    {
        return $this->price;
    }

    public function setPrice(string $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getOwner(): ?User
    {
        return $this->owner;
    }

    public function setOwner(?User $owner): self
    {
        $this->owner = $owner;

        return $this;
    }

    public function getFilmShow(): ?FilmShow
    {
        return $this->filmShow;
    }

    public function setFilmShow(?FilmShow $filmShow): self
    {
        $this->filmShow = $filmShow;

        return $this;
    }

    public function getRefunded(): ?bool
    {
        return $this->refunded;
    }

    public function setRefunded(?bool $refunded): self
    {
        $this->refunded = $refunded;

        return $this;
    }
}
