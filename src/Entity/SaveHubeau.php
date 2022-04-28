<?php

namespace App\Entity;

use App\Repository\SaveHubeauRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SaveHubeauRepository::class)]
class SaveHubeau
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $libelle_parametre;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $code_lieu_analyse;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $analyse_numerique;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $libelle_unite;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $date_prelevement;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $code_departement;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $nom_departement;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $code_commune;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $nom_commune;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $code_parametre;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLibelleParametre(): ?string
    {
        return $this->libelle_parametre;
    }

    public function setLibelleParametre(string $libelle_parametre): self
    {
        $this->libelle_parametre = $libelle_parametre;

        return $this;
    }

    public function getCodeLieuAnalyse(): ?string
    {
        return $this->code_lieu_analyse;
    }

    public function setCodeLieuAnalyse(?string $code_lieu_analyse): self
    {
        $this->code_lieu_analyse = $code_lieu_analyse;

        return $this;
    }

    public function getAnalyseNumerique(): ?string
    {
        return $this->analyse_numerique;
    }

    public function setAnalyseNumerique(?string $analyse_numerique): self
    {
        $this->analyse_numerique = $analyse_numerique;

        return $this;
    }

    public function getLibelleUnite(): ?string
    {
        return $this->libelle_unite;
    }

    public function setLibelleUnite(?string $libelle_unite): self
    {
        $this->libelle_unite = $libelle_unite;

        return $this;
    }

    public function getDatePrelevement(): ?string
    {
        return $this->date_prelevement;
    }

    public function setDatePrelevement(?string $date_prelevement): self
    {
        $this->date_prelevement = $date_prelevement;

        return $this;
    }

    public function getCodeDepartement(): ?string
    {
        return $this->code_departement;
    }

    public function setCodeDepartement(?string $code_departement): self
    {
        $this->code_departement = $code_departement;

        return $this;
    }

    public function getNomDepartement(): ?string
    {
        return $this->nom_departement;
    }

    public function setNomDepartement(?string $nom_departement): self
    {
        $this->nom_departement = $nom_departement;

        return $this;
    }

    public function getCodeCommune(): ?string
    {
        return $this->code_commune;
    }

    public function setCodeCommune(?string $code_commune): self
    {
        $this->code_commune = $code_commune;

        return $this;
    }

    public function getNomCommune(): ?string
    {
        return $this->nom_commune;
    }

    public function setNomCommune(?string $nom_commune): self
    {
        $this->nom_commune = $nom_commune;

        return $this;
    }

    public function getCodeParametre(): ?string
    {
        return $this->code_parametre;
    }

    public function setCodeParametre(?string $code_parametre): self
    {
        $this->code_parametre = $code_parametre;

        return $this;
    }
}
