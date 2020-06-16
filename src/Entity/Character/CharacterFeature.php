<?php
// src\Entity\Character\CharacterFeature.php
namespace App\Entity\Character;

use App\Mapping\EntityBase;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\Character\Feature;
use App\Entity\Character\Character;
use App\Repository\Character\CharacterFeatureRepository;

/**
 * Class CharacterFeature
 *
 * PHP version 7.2.5
 *
 * @package    App\Entity
 * @author     Sylvain FLORIDE <sfloride@gmail.com>
 * @version    1.0.0
 * 
 * @ORM\Entity(repositoryClass=CharacterFeatureRepository::class)
 * @ORM\HasLifecycleCallbacks
 * @ORM\Table(name="c_character_feature")
 */
class CharacterFeature extends EntityBase
{
    /**
     * @var int|null
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @var int|null
     * @ORM\Column(type="smallint", nullable=true, options={"default" : null})
     */
    private $experienceUpgrade;

    /**
     * @var Feature|null
     * @ORM\ManyToOne(targetEntity=feature::class, inversedBy="characters")
     * @ORM\JoinColumn(name="feature_id", referencedColumnName="id", nullable=false)
     */
    private $feature;

    /**
     * @var Character|null
     * @ORM\ManyToOne(targetEntity=Character::class, inversedBy="features")
     * @ORM\JoinColumn(name="character_id", referencedColumnName="id", nullable=false)
     */
    private $character;

    /**
     * @var int|null
     * @ORM\Column(name="value", type="smallint")
     */
    private $value;

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
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
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
    public function setCharacter(?Character $character): self
    {
        $this->character = $character;

        return $this;
    }


    /**
     * getExperienceUpgrade
     *
     * @return int|null
     */
    public function getExperienceUpgrade(): ?int
    {
        return $this->experienceUpgrade;
    }

    /**
     * setExperienceUpgrade
     *
     * @param int|null $experienceUpgrade
     * @return self
     */
    public function setExperienceUpgrade(?int $experienceUpgrade = null): self
    {
        $this->experienceUpgrade = $experienceUpgrade;

        return $this;
    }

    /**
     * getFeature
     *
     * @return Feature|null
     */
    public function getFeature(): ?Feature
    {
        return $this->feature;
    }

    /**
     * setFeature
     *
     * @param Feature|null $feature
     * @return self
     */
    public function setFeature(?Feature $feature = null): self
    {
        $this->feature = $feature;

        return $this;
    }

    /**
     * getValue
     *
     * @return int|null
     */
    public function getValue(): ?int
    {
        return $this->value;
    }

    /**
     * setValue
     *
     * @param int|null $value
     * @return self
     */
    public function setValue(?int $value = null): self
    {
        $this->value = $value;

        return $this;
    }
    
    /* ---------------------- Autres méthodes ---------------------- */

}
