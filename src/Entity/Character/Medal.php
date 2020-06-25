<?php

namespace App\Entity\Character;

use DateTimeInterface;
use App\Mapping\EntityBase;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use App\Helper\ORM\TypeableTrait;
use App\Helper\ORM\CategoriableTrait;
use App\Helper\ORM\IsObsoletableTrait;
use App\Helper\ORM\UniqueNameableTrait;
use App\Helper\ORM\DescriptionableTrait;
use App\Helper\ORM\AbbreviationableTrait;
use App\Repository\Character\MedalRepository;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * @ORM\Entity(repositoryClass=MedalRepository::class)
 * @ORM\HasLifecycleCallbacks
 * @ORM\Table(name="c_medal")
 * @Vich\Uploadable
 */
class Medal extends EntityBase
{
    use AbbreviationableTrait;
    use CategoriableTrait;
    use DescriptionableTrait;
    use IsObsoletableTrait;
    use TypeableTrait;
    use UniqueNameableTrait;

    const TYPE = [
        0 => 'Not specified',
        1 => 'Personal',
        2 => 'Unit',
        3 => 'Mixte',
    ];
    
    const CATEGORY = [
        0 => 'Not specified',
        1 => 'Achivment',
        2 => 'Honor',
        3 => 'Valor',
        4 => 'Regimental',
        5 => 'Federal',
        6 => 'Other'
    ];

    /**
     * @var int|null Table id
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(name="id", type="integer")
     */
    private $id;

    /**
     * @var Collection|CharacterMedal[]|null
     * @ORM\OneToMany(targetEntity=CharacterMedal::class, mappedBy="medal", orphanRemoval=true)
     */
    private $characters;

    /**
     * @var float|null
     * @ORM\Column(name="coef_xp", type="float", options={"default" : 0})
     */
    private $coeficientXp;

    /**
     * @var string|null Picture name
     * @ORM\Column(name="picture", type="string", length=255, nullable=true)
     */
    private $picture;

    /**
     * @var File|null
     * @Vich\UploadableField(mapping="character_medal_picture", fileNameProperty="picture")
     */
    private $pictureFile;

    /**
     * @var string|null Ribbon name
     * @ORM\Column(name="ribbon", type="string", length=255, nullable=true)
     */
    private $ribbon;

    /**
     * @var File|null
     * @Vich\UploadableField(mapping="character_medal_ribbon_picture", fileNameProperty="ribbon")
     */
    private $ribbonFile;

    /**
     * @var int|null
     * @ORM\Column(name="value", type="integer", options={"default" : 0})
     */
    private $value;
    
    /**
     * Medal Constructor
     */
    public function __construct()
    {
        parent::__construct();
        $this->setCoeficientXp();
        $this->setObsolete();
        $this->setType();
        $this->setValue();
        $this->characters = new ArrayCollection();
    }

    /* ---------------------- Setters & Getters ---------------------- */

    /**
     * getId()
     *
     * @return integer|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * getCharacters
     * 
     * @return Collection|CharacterMedal[]|null
     */
    public function getCharacters(): Collection
    {
        return $this->characters;
    }

    /**
     * addCharacter
     *
     * @param CharacterMedal $characters
     * @return self
     */
    public function addCharacter(CharacterMedal $characters): self
    {
        if (!$this->characters->contains($characters)) {
            $this->characters[] = $characters;
            $characters->setMedal($this);
        }

        return $this;
    }

    /**
     * removeCharacter
     *
     * @param CharacterMedal $characters
     * @return self
     */
    public function removeCharacter(CharacterMedal $characters): self
    {
        if ($this->characters->contains($characters)) {
            $this->characters->removeElement($characters);
            // set the owning side to null (unless already changed)
            if ($characters->getMedal() === $this) {
                $characters->setMedal(null);
            }
        }

        return $this;
    }

    /**
     * getCoeficientXp
     *
     * @return float|null
     */
    public function getCoeficientXp(): ?float
    {
        return $this->coeficientXp;
    }

    /**
     * setCoeficientXp
     *
     * @param float|null $coeficientXp
     * @return self
     */
    public function setCoeficientXp(?float $coeficientXp = 0): self
    {
        $this->coeficientXp = $coeficientXp;

        return $this;
    }

    /**
     * Get picture name
     *
     * @return string|null
     */
    public function getPicture(): ?string
    {
        return $this->picture;
    }

    /**
     * Set picture name
     *
     * @param string|null $picture
     * @return self
     */
    public function setPicture(?string $picture = null): self
    {
        $this->picture = $picture;
        return $this;
    }
    
    /**
     * Get picture file
     *
     * @return File|null
     */
    public function getPictureFile(): ?File
    {
        return $this->pictureFile;
    }

    /**
     * Set picture file
     *
     * @param  File|UploadedFile|null $file
     * @return self
     */
    public function setPictureFile(?File $file = null): self
    {
        $this->pictureFile = $file;
        if (null !== $file) {
            $this->setUpdatedAt(new DateTimeInterface('now'));
        }

        return $this;
    }
    
    /**
     * Get ribbon name
     *
     * @return string|null
     */
    public function getRibbon(): ?string
    {
        return $this->ribbon;
    }

    /**
     * Set ribbon name
     *
     * @param string|null $ribbon
     * @return self
     */
    public function setRibbon(?string $ribbon = null): self
    {
        $this->ribbon = $ribbon;
        return $this;
    }
    
    /**
     * Get RibbonFile
     *
     * @return File|null
     */
    public function getRibbonFile(): ?File
    {
        return $this->ribbonFile;
    }

    /**
     * Set RibbonFile
     *
     * @param  File|UploadedFile|null $file
     * @return self
     */
    public function setRibbonFile(?File $file = null): self
    {
        $this->ribbonFile = $file;
        if (null !== $file) {
            $this->setUpdatedAt(new DateTimeInterface('now'));
        }

        return $this;
    }
    
    /**
     * Get value
     *
     * @return int|null
     */
    public function getValue(): ?int
    {
        return $this->value;
    }

    /**
     * Set type
     *
     * @param int|null $value
     * @return self
     */
    public function setValue(?int $value = 0): self
    {
        $this->value = $value;

        return $this;
    }
}
