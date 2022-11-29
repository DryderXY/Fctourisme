<?php

namespace App\Entity;

use App\Repository\VilleRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: VilleRepository::class)]
class Ville
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nom = null;

    #[ORM\Column(length: 5)]
    private ?string $CP_ville = null;

    #[ORM\Column(length: 255)]
    private ?string $departement = null;

    #[ORM\Column]
    private ?int $no_departement = null;

    #[ORM\Column(length: 255)]
    private ?string $region = null;

    #[ORM\OneToMany(mappedBy: 'ville', targetEntity: Etablissement::class)]
    private Collection $etablissements;

    public function __construct()
    {
        $this->etablissements = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getCPVille(): ?string
    {
        return $this->CP_ville;
    }

    public function setCPVille(string $CP_ville): self
    {
        $this->CP_ville = $CP_ville;

        return $this;
    }

    public function getDepartement(): ?string
    {
        return $this->departement;
    }

    public function setDepartement(string $departement): self
    {
        $this->departement = $departement;

        return $this;
    }

    public function getNoDepartement(): ?int
    {
        return $this->no_departement;
    }

    public function setNoDepartement(int $no_departement): self
    {
        $this->no_departement = $no_departement;

        return $this;
    }

    public function getRegion(): ?string
    {
        return $this->region;
    }

    public function setRegion(string $region): self
    {
        $this->region = $region;

        return $this;
    }

    /**
     * @return Collection<int, Etablissement>
     */
    public function getEtablissements(): Collection
    {
        return $this->etablissements;
    }

    public function addEtablissement(Etablissement $etablissement): self
    {
        if (!$this->etablissements->contains($etablissement)) {
            $this->etablissements->add($etablissement);
            $etablissement->setVille($this);
        }

        return $this;
    }

    public function removeEtablissement(Etablissement $etablissement): self
    {
        if ($this->etablissements->removeElement($etablissement)) {
            // set the owning side to null (unless already changed)
            if ($etablissement->getVille() === $this) {
                $etablissement->setVille(null);
            }
        }

        return $this;
    }

}
