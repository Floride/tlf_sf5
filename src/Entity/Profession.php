<?php
// src\Entity\Profession.php
namespace App\Entity;

use App\Mapping\EntityBase;
use App\Repository\ProfessionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=ProfessionRepository::class)
 * @ORM\HasLifecycleCallbacks
 * @ORM\Table(name="profession")
 */
class Profession extends EntityBase
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @var string
     * @ORM\Column(type="text", nullable=false)
     * @Assert\NotBlank
     */
    private $description;

    /**
     * @var string
     * @ORM\Column(type="string", length=255, unique=true, nullable=false)
     * @Assert\NotBlank
     */
    private $nom;

    /**
     * @ORM\OneToMany(targetEntity=Specialite::class, mappedBy="profession", orphanRemoval=true)
     */
    private $specialites; 

    /**
     * Constructor
     */
    public function __construct()
    {
        parent::__construct();
        $this->specialites = new ArrayCollection();
    }

    /* ---------------------- Setters & Getters ---------------------- */

    /**
     * Get Id
     *
     * @return null|int
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * Get description
     *
     * @return string|null
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return self
     */
    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get nom
     *
     * @return string|null
     */
    public function getNom(): ?string
    {
        return $this->nom;
    }

    /**
     * Set nom
     *
     * @param string $nom
     * @return self
     */
    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    /**
     * Get specialités
     * 
     * @return Collection|Specialite[]
     */
    public function getSpecialites(): Collection
    {
        return $this->specialites;
    }

    /**
     * Add specialité
     *
     * @param Specialite $specialite
     * @return self
     */
    public function addSpecialite(Specialite $specialite): self
    {
        if (!$this->specialites->contains($specialite)) {
            $this->specialites[] = $specialite;
            $specialite->setProfession($this);
        }

        return $this;
    }
 
    /**
     * Remove specialité
     *
     * @param Specialite $specialite
     * @return self
     */
    public function removeSpecialite(Specialite $specialite): self
    {
        if ($this->specialites->contains($specialite)) {
            $this->specialites->removeElement($specialite);
            // set the owning side to null (unless already changed)
            if ($specialite->getProfession() === $this) {
                $specialite->setProfession(null);
            }
        }

        return $this;
    }
}
