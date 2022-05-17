<?php

namespace App\Entity;

use App\Repository\EvenementRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EvenementRepository::class)]
class Evenement
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 30)]
    private $nom;

    #[ORM\Column(type: 'string', length: 30)]
    private $ville;

    #[ORM\Column(type: 'datetime')]
    private $date_debut;

    #[ORM\Column(type: 'datetime')]
    private $date_fin;

    #[ORM\Column(type: 'text')]
    private $description;

    #[ORM\ManyToOne(targetEntity: Categorie::class, inversedBy: 'evenements')]
    #[ORM\JoinColumn(nullable: false)]
    private $id_categorie;

    #[ORM\OneToMany(mappedBy: 'id_evenement', targetEntity: Appreciation::class)]
    private $appreciations;

    #[ORM\Column(type: 'string', length: 255)]
    private $image;

    public function __construct()
    {
        $this->id_utilisateur = new ArrayCollection();
        $this->appreciations = new ArrayCollection();
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

    public function getVille(): ?string
    {
        return $this->ville;
    }

    public function setVille(string $ville): self
    {
        $this->ville = $ville;

        return $this;
    }

    public function getDateDebut(): ?\DateTimeInterface
    {
        return $this->date_debut;
    }

    public function setDateDebut(\DateTimeInterface $date_debut): self
    {
        $this->date_debut = $date_debut;

        return $this;
    }

    public function getDateFin(): ?\DateTimeInterface
    {
        return $this->date_fin;
    }

    public function setDateFin(\DateTimeInterface $date_fin): self
    {
        $this->date_fin = $date_fin;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getIdCategorie(): ?Categorie
    {
        return $this->id_categorie;
    }

    public function setIdCategorie(?Categorie $id_categorie): self
    {
        $this->id_categorie = $id_categorie;

        return $this;
    }


    /**
     * @return Collection<int, Appreciation>
     */
    public function getAppreciations(): Collection
    {
        return $this->appreciations;
    }

    public function addAppreciation(Appreciation $appreciation): self
    {
        if (!$this->appreciations->contains($appreciation)) {
            $this->appreciations[] = $appreciation;
            $appreciation->setIdEvenement($this);
        }

        return $this;
    }

    public function removeAppreciation(Appreciation $appreciation): self
    {
        if ($this->appreciations->removeElement($appreciation)) {
            // set the owning side to null (unless already changed)
            if ($appreciation->getIdEvenement() === $this) {
                $appreciation->setIdEvenement(null);
            }
        }

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(string $image): self
    {
        $this->image = $image;

        return $this;
    }
}
