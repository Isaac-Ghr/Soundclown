<?php

namespace App\Entity;

use App\Repository\NationaliteRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

#[ORM\Entity(repositoryClass: NationaliteRepository::class)]
#[UniqueEntity(fields: ["libelle"], message: "La nationalité {{ value }} existe déjà")]
class Nationalite
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\Length(min: 3, minMessage: "Le libelle de la nationalité doit comporter au moins {{ limit }} caractères")]
    private ?string $libelle = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $drapeau = null;

    #[ORM\OneToMany(mappedBy: 'nationalite', targetEntity: Artiste::class)]
    private Collection $artistes;

    public function __construct()
    {
        $this->artistes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLibelle(): ?string
    {
        return $this->libelle;
    }

    public function setLibelle(string $libelle): static
    {
        $this->libelle = $libelle;

        return $this;
    }

    public function getDrapeau(): ?string
    {
        return $this->drapeau;
    }

    public function setDrapeau(?string $drapeau): static
    {
        $this->drapeau = $drapeau;

        return $this;
    }

    /**
     * @return Collection<int, Artiste>
     */
    public function getArtistes(): Collection
    {
        return $this->artistes;
    }

    public function addArtiste(Artiste $artiste): static
    {
        if (!$this->artistes->contains($artiste)) {
            $this->artistes->add($artiste);
            $artiste->setNationalite($this);
        }

        return $this;
    }

    public function removeArtiste(Artiste $artiste): static
    {
        if ($this->artistes->removeElement($artiste)) {
            // set the owning side to null (unless already changed)
            if ($artiste->getNationalite() === $this) {
                $artiste->setNationalite(null);
            }
        }

        return $this;
    }

    public function __toString()
    {
        return $this->libelle;
    }
}
