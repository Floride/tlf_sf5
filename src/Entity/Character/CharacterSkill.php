<?php
// src\Entity\Character\CharacterSkill.php
namespace App\Entity\Character;

use App\Mapping\EntityBase;
use App\Repository\Character\CharacterSkillRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class CharacterSkill
 *
 * PHP version 7.2.5
 *
 * @package    App\Entity
 * @author     Sylvain FLORIDE <sfloride@gmail.com>
 * @version    1.0.0
 * 
 * @ORM\Entity(repositoryClass=CharacterSkillRepository::class)
 * @ORM\HasLifecycleCallbacks
 * @ORM\Table(name="c_character_skill")
 */
class CharacterSkill extends EntityBase
{
    /**
     * @var int|null
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Character::class, inversedBy="skills")
     * @ORM\JoinColumn(name="character_id", nullable=false)
     */
    private $character;

    /**
     * @var int|null
     * @ORM\Column(type="smallint", nullable=true, options={"default" : null})
     */
    private $experienceUpgrade;

    /**
     * @ORM\ManyToOne(targetEntity=Skill::class, inversedBy="characters")
     * @ORM\JoinColumn(nullable=false)
     */
    private $skill;

    /**
     * CharacterMedal Constructor
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
     * @return integer|null
     */
    public function getExperienceUpgrade(): ?int
    {
        return $this->experienceUpgrade;
    }

    /**
     * setExperienceUpgrade
     *
     * @param integer|null $experienceUpgrade
     * @return self
     */
    public function setExperienceUpgrade(?int $experienceUpgrade = null): self
    {
        $this->experienceUpgrade = $experienceUpgrade;

        return $this;
    }
    
    /**
     * getSkill
     *
     * @return Skill|null
     */
    public function getSkill(): ?Skill
    {
        return $this->skill;
    }

    /**
     * setSkill
     *
     * @param Skill|null $skill
     * @return self
     */
    public function setSkill(?Skill $skill = null): self
    {
        $this->skill = $skill;

        return $this;
    }

    /* ---------------------- Autres méthodes ---------------------- */

}
