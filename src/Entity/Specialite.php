<?php
// src\Entity\Specialite.php
namespace App\Entity;

use App\Mapping\EntityBase;
use App\Repository\ProfessionRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=SpecialiteRepository::class)
 * @ORM\HasLifecycleCallbacks
 * @ORM\Table(name="specialite")
 */
class Specialite extends EntityBase
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @var string
     * @ORM\Column(name="description", type="text", nullable=false)
     * @Assert\NotBlank
     */
    private $description;

    /**
     * @var string
     * @ORM\Column(name="name", type="string", length=255, unique=true, nullable=false)
     * @Assert\NotBlank
     */
    private $nom;

    /**
     * @var bool Spétialité par defaut ?
     * @ORM\Column(name="is_primae", type="boolean", nullable=false, options={"default" : false})
     */
    private $primae;

    /**
     * @ORM\ManyToOne(targetEntity=Profession::class, inversedBy="specialites")
     * @ORM\JoinColumn(name="profession", nullable=false)
     */
    private $profession;

    /**
     * Constructor
     */
    public function __construct()
    {
        parent::__construct();
        $this->setPrimae();
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
     * Get primae
     *
     * @return boolean|null
     */
    public function getPrimae(): ?bool
    {
        return $this->primae;
    }

    /**
     * Set primae
     *
     * @param boolean $bool
     * @return self
     */
    public function setPrimae(?bool $bool = false): self
    {
        $this->primae = $bool;

        return $this;
    }

    /**
     * Get profession
     *
     * @return Profession|null
     */
    public function getProfession(): ?Profession
    {
        return $this->profession;
    }

    /**
     * Set profession
     *
     * @param Profession|null $profession
     * @return self
     */
    public function setProfession(?Profession $profession): self
    {
        $this->profession = $profession;

        return $this;
    }
}
