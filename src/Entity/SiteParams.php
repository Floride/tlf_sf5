<?php
// src\Entity\SiteParams.php
namespace App\Entity;

use App\Mapping\EntityBase;
use App\Repository\SiteParamsRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class SiteParams
 *
 * PHP version 7.2
 *
 * @package    App\Entity
 * @author     Sylvain FLORIDE <sfloride@gmail.com>
 * @version    1.0.0
 *
 * @ORM\Entity(repositoryClass=SiteParamsRepository::class)
 * @ORM\HasLifecycleCallbacks
 * @ORM\Table(name="site_params")
 */
class SiteParams extends EntityBase
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(name="id", type="integer")
     */
    private $id;

    /**
     * @var string
     * @ORM\Column(name="name", type="string", length=128, unique=true, nullable=false)
     * @Assert\NotBlank
     */
    private $nom;

    /**
     * @var string
     * @ORM\Column(name="value", type="text", nullable=false)
     * @Assert\NotBlank
     */
    private $valeur;

    /**
     * Constructor
     */
    public function __construct()
    {
        parent::__construct();
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
     * Get Nom
     *
     * @return null|string
     */
    public function getNom(): ?string
    {
        return $this->nom;
    }

    /**
     * Set Nom
     *
     * @param string|null $nom
     * @return self
     */
    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }


    /**
     * Get Valeur
     *
     * @return null|string
     */
    public function getValeur(): ?string
    {
        return $this->valeur;
    }

    /**
     * Set Valeur
     *
     * @param string|null $valeur
     * @return self
     */
    public function setValeur(string $valeur): self
    {
        $this->valeur = $valeur;

        return $this;
    }
    
    /* ---------------------- Autres méthodes ---------------------- */
}
