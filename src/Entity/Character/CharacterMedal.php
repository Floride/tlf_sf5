<?php
// src\Entity\Character\CharacterMedal.php
namespace App\Entity\Character;

use DateTimeImmutable;
use App\Mapping\EntityBase;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\Character\CharacterMedalRepository;

/**
 * Class CharacterMedal
 *
 * PHP version 7.2.5
 *
 * @package    App\Entity
 * @author     Sylvain FLORIDE <sfloride@gmail.com>
 * @version    1.0.0
 * 
 * @ORM\Entity(repositoryClass=CharacterMedalRepository::class)
 * @ORM\HasLifecycleCallbacks
 * @ORM\Table(name="c_character_medal")
 */
class CharacterMedal extends EntityBase
{
    /**
     * @var int|null
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(name="id", type="integer")
     */
    private $id;

    /**
     * @var DateTimeImmutable|null
     * @ORM\Column(name="attribute_at", type="datetime_immutable", nullable=false)
     */
    private $attributeAt;

    /**
     * @var string|null
     * @ORM\Column(name="comment", type="text", nullable=true)
     */
    private $comment;

    /**
     * @var Character|null
     * @ORM\ManyToOne(targetEntity=Character::class, inversedBy="medals")
     * @ORM\JoinColumn(name="character_id", referencedColumnName="id", nullable=false)
     */
    private $character;

    /**
     * @ORM\ManyToOne(targetEntity=Medal::class, inversedBy="characters")
     * @ORM\JoinColumn(name="medal_id", referencedColumnName="id", nullable=false)
     */
    private $medal;

    /**
     * CharacterMedal Constructor
     */
    public function __construct()
    {
        parent::__construct();
        $this->setAttributeAt(new DateTimeImmutable());
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
     * getAttributeAt
     *
     * @return DateTimeImmutable|null
     */
    public function getAttributeAt(): ?DateTimeImmutable
    {
        return $this->attributeAt;
    }

    /**
     * setAttributeAt
     *
     * @param DateTimeImmutable|null $date
     * 
     * @return self
     */
    public function setAttributeAt(?DateTimeImmutable $date = null): self
    {
        $this->attributeAt = $date;

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
     * 
     * @return self
     */
    public function setCharacter(?Character $character = null): self
    {
        $this->character = $character;

        return $this;
    }

    /**
     * getComment
     *
     * @return string|null
     */
    public function getComment(): ?string
    {
        return $this->comment;
    }

    /**
     * setComment
     *
     * @param string|null $comment
     * 
     * @return self
     */
    public function setComment(?string $comment = null): self
    {
        $this->comment = $comment;

        return $this;
    }
    
    /**
     * getMedal
     *
     * @return Medal|null
     */
    public function getMedal(): ?Medal
    {
        return $this->medal;
    }

    /**
     * setMedal
     *
     * @param Medal|null $medal
     * 
     * @return self
     */
    public function setMedal(?Medal $medal = null): self
    {
        $this->medal = $medal;

        return $this;
    }
    
    /* ---------------------- Autres méthodes ---------------------- */

}
