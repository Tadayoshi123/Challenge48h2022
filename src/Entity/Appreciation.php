<?php

namespace App\Entity;

use App\Repository\AppreciationRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AppreciationRepository::class)]
class Appreciation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\ManyToOne(targetEntity: Utilisateur::class, inversedBy: 'appreciations')]
    #[ORM\JoinColumn(nullable: false)]
    private $id_utilisateur;

    #[ORM\ManyToOne(targetEntity: Evenement::class, inversedBy: 'appreciations')]
    #[ORM\JoinColumn(nullable: false)]
    private $id_evenement;

    #[ORM\Column(type: 'integer')]
    private $note;

    #[ORM\Column(type: 'string', length: 255)]
    private $commentaires;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdUtilisateur(): ?Utilisateur
    {
        return $this->id_utilisateur;
    }

    public function setIdUtilisateur(?Utilisateur $id_utilisateur): self
    {
        $this->id_utilisateur = $id_utilisateur;

        return $this;
    }

    public function getIdEvenement(): ?Evenement
    {
        return $this->id_evenement;
    }

    public function setIdEvenement(?Evenement $id_evenement): self
    {
        $this->id_evenement = $id_evenement;

        return $this;
    }

    public function getNote(): ?int
    {
        return $this->note;
    }

    public function setNote(int $note): self
    {
        $this->note = $note;

        return $this;
    }

    public function getCommentaires(): ?string
    {
        return $this->commentaires;
    }

    public function setCommentaires(string $commentaires): self
    {
        $this->commentaires = $commentaires;

        return $this;
    }
}
