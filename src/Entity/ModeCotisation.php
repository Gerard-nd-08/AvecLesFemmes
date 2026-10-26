<?php

namespace App\Entity;

use App\Repository\ModeCotisationRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ModeCotisationRepository::class)]
class ModeCotisation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?bool $isLibre = null;

    /**
     * @var Collection<int, Member>
     */
    #[ORM\OneToMany(targetEntity: Member::class, mappedBy: 'modeCotisation')]
    private Collection $membres;

    /**
     * @var Collection<int, Campagne>
     */
    #[ORM\OneToMany(targetEntity: Campagne::class, mappedBy: 'modeCotisation')]
    private Collection $Campagnes;

    public function __construct()
    {
        $this->membres = new ArrayCollection();
        $this->Campagnes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function isLibre(): ?bool
    {
        return $this->isLibre;
    }

    public function setIsLibre(bool $isLibre): static
    {
        $this->isLibre = $isLibre;

        return $this;
    }

    /**
     * @return Collection<int, Member>
     */
    public function getMembres(): Collection
    {
        return $this->membres;
    }

    public function addMembre(Member $membre): static
    {
        if (!$this->membres->contains($membre)) {
            $this->membres->add($membre);
            $membre->setModeCotisation($this);
        }

        return $this;
    }

    public function removeMembre(Member $membre): static
    {
        if ($this->membres->removeElement($membre)) {
            // set the owning side to null (unless already changed)
            if ($membre->getModeCotisation() === $this) {
                $membre->setModeCotisation(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Campagne>
     */
    public function getCampagnes(): Collection
    {
        return $this->Campagnes;
    }

    public function addCampagne(Campagne $campagne): static
    {
        if (!$this->Campagnes->contains($campagne)) {
            $this->Campagnes->add($campagne);
            $campagne->setModeCotisation($this);
        }

        return $this;
    }

    public function removeCampagne(Campagne $campagne): static
    {
        if ($this->Campagnes->removeElement($campagne)) {
            // set the owning side to null (unless already changed)
            if ($campagne->getModeCotisation() === $this) {
                $campagne->setModeCotisation(null);
            }
        }

        return $this;
    }
}
