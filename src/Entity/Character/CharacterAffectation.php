<?php
// src\Entity\Character\CharacterAffectation.php
namespace App\Entity\Character;

use App\Entity\Game\Affectation;
use DateTimeInterface;
use App\Mapping\EntityBase;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\Character\CharacterAffectationRepository;

/**
 * Class CharacterFeature
 *
 * PHP version 7.2.5
 *
 * @package    App\Entity
 * @author     Sylvain FLORIDE <sfloride@gmail.com>
 * @version    1.0.0
 * 
 * @ORM\Entity(repositoryClass=CharacterAffectationRepository::class)
 * @ORM\HasLifecycleCallbacks
 * @ORM\Table(name="c_character_affectation")
 */
class CharacterAffectation extends EntityBase
{
    /**
     * @var int|null
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(name="id", type="integer")
     */
    private $id;

    /**
     * @var Affectation|null
     * @ORM\ManyToOne(targetEntity=Affectation::class, inversedBy="characters")
     * @ORM\JoinColumn(name="affectation_id", nullable=false)
     */
    private $affectation;

    /**
     * @var DateTimeInterface|null
     * @ORM\Column(name="begin_at", type="datetime", nullable=false)
     */
    private $beginAt;

    /**
     * @var DateTimeInterface|null
     * @ORM\Column(name="end_at", type="datetime", nullable=true, options={"default" : null})
     */
    private $endAt;

    /**
     * @ORM\ManyToOne(targetEntity=Character::class, inversedBy="affectations")
     * @ORM\JoinColumn(nullable=false)
     */
    private $character;

    /**
     * CharacterFeature Constructor
     */
    public function __construct()
    {
        parent::__construct();
    }

    /* ---------------------- Setters & Getters ---------------------- */

    /**
     * getId
     *
     * @return integer|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * getAffectation
     *
     * @return Affectation|null
     */
    public function getAffectation(): ?Affectation
    {
        return $this->affectation;
    }

    /**
     * setAffectation
     *
     * @param Affectation|null $affectation
     * @return self
     */
    public function setAffectation(?Affectation $affectation = null): self
    {
        $this->affectation = $affectation;

        return $this;
    }

    /**
     * getBeginAt
     *
     * @return DateTimeInterface|null
     */
    public function getBeginAt(): ?DateTimeInterface
    {
        return $this->beginAt;
    }

    /**
     * setBeginAt
     *
     * @param DateTimeInterface|null $beginAt
     * @return self
     */
    public function setBeginAt(?DateTimeInterface $beginAt = null): self
    {
        $this->beginAt = $beginAt;

        return $this;
    }

    /**
     * getCharacter
     *
     * @return Character|null
     */
    public function getCharacter(): ?Character
    {
        return $this->character;
    }

    /**
     * setCharacter
     *
     * @param Character|null $character
     * @return self
     */
    public function setCharacter(?Character $character = null): self
    {
        $this->character = $character;

        return $this;
    }

    /**
     * getEndAt
     *
     * @return DateTimeInterface|null
     */
    public function getEndAt(): ?DateTimeInterface
    {
        return $this->endAt;
    }

    /**
     * setEndAt
     *
     * @param DateTimeInterface|null $endAt
     * @return self
     */
    public function setEndAt(?DateTimeInterface $endAt = null): self
    {
        $this->endAt = $endAt;

        return $this;
    }
    
    /* ---------------------- Autres méthodes ---------------------- */

}
