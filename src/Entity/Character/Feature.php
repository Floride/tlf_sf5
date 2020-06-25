<?php
// src\Entity\Character\Feature.php
namespace App\Entity\Character;

use DateTimeInterface;
use App\Mapping\EntityBase;
use App\Entity\Character\Skill;
use Doctrine\ORM\Mapping as ORM;
use App\Helper\ORM\TypeableTrait;
use App\Helper\ORM\IsObsoletableTrait;
use App\Helper\ORM\UniqueNameableTrait;
use App\Helper\ORM\DescriptionableTrait;
use App\Helper\ORM\AbbreviationableTrait;
use Doctrine\Common\Collections\Collection;
use App\Repository\Character\FeatureRepository;
use Symfony\Component\HttpFoundation\File\File;
use Doctrine\Common\Collections\ArrayCollection;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * Class Feature
 *
 * PHP version 7.2.5
 *
 * @package    App\Entity
 * @author     Sylvain FLORIDE <sfloride@gmail.com>
 * @version    1.1.0
 *
 * @ORM\Entity(repositoryClass=FeatureRepository::class)
 * @ORM\HasLifecycleCallbacks
 * @ORM\Table(name="c_feature")
 * @Vich\Uploadable
 */
class Feature extends EntityBase
{
    use AbbreviationableTrait;
    use DescriptionableTrait;
    use IsObsoletableTrait;
    use TypeableTrait;
    use UniqueNameableTrait;

    const TYPE = [
        0 => 'Not specified',
        1 => 'Physical',
        2 => 'Mental'
    ];

    /**
     * @var int|null Table id
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(name="id", type="integer")
     */
    private $id;

    /**
     * @var Collection|CharacterFeature[]|null
     * @ORM\OneToMany(targetEntity=CharacterFeature::class, mappedBy="feature", orphanRemoval=true)
     */
    private $characters;

    /**
     * @var Collection|Skill[]|null
     * @ORM\OneToMany(targetEntity=Skill::class, mappedBy="featurePrimae")
     */
    private $skillPrimae;

    /**
     * @var Collection|Skill[]|null
     * @ORM\OneToMany(targetEntity=Skill::class, mappedBy="featureSecundae")
     */
    private $skillSecundae;

    /**
     * @var Collection|Skill[]|null
     * @ORM\OneToMany(targetEntity=Skill::class, mappedBy="featureTertiae")
     */
    private $skillTertiae;

    /**
     * @var Collection|Skill[]|null
     * @ORM\OneToMany(targetEntity=Skill::class, mappedBy="featureQuartae")
     */
    private $skillQuartae;

    /**
     * @var string|null Picture name
     * @ORM\Column(name="picture", type="string", length=255, nullable=true)
     */
    private $picture;

    /**
     * @var File|null
     * @Vich\UploadableField(mapping="character_feature_picture", fileNameProperty="picture")
     */
    private $pictureFile;

    /**
     * @var int
     * @ORM\Column(name="value_min", type="integer", nullable=false, options={"default" : 0})
     * @Assert\NotBlank
     */
    private $valueMin;

    /**
     * @var int
     * @ORM\Column(name="value_max", type="integer", nullable=false, options={"default" : 100})
     * @Assert\NotBlank
     */
    private $valueMax;

    /**
     * @var int
     * @ORM\Column(name="value_Average", type="integer", nullable=false, options={"default" : 50})
     * @Assert\NotBlank
     */
    private $valueAverage;
    
    /**
     * Feature Constructor
     */
    public function __construct()
    {
        parent::__construct();
        $this->setType();
        $this->setObsolete();
        $this->skillPrimae = new ArrayCollection();
        $this->skillSecundae = new ArrayCollection();
        $this->skillTertiae = new ArrayCollection();
        $this->skillQuartae = new ArrayCollection();
        $this->characters = new ArrayCollection();
    }

    /* ---------------------- Setters & Getters ---------------------- */

    /**
     * Get id
     *
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * getCharacters
     * 
     * @return Collection|CharacterFeature[]
     */
    public function getCharacters(): Collection
    {
        return $this->characters;
    }

    /**
     * addCharacter
     *
     * @param CharacterFeature $character
     * @return self
     */
    public function addCharacter(CharacterFeature $character): self
    {
        if (!$this->characters->contains($character)) {
            $this->characters[] = $character;
            $character->setFeature($this);
        }

        return $this;
    }

    /**
     * removeCharacter
     *
     * @param CharacterFeature $character
     * @return self
     */
    public function removeCharacter(CharacterFeature $character): self
    {
        if ($this->characters->contains($character)) {
            $this->characters->removeElement($character);
            // set the owning side to null (unless already changed)
            if ($character->getFeature() === $this) {
                $character->setFeature(null);
            }
        }

        return $this;
    }

    /**
     * Get Compétences Primaires
     * 
     * @return Collection|Skill[]|null
     */
    public function getSkillPrimae(): ?Collection
    {
        return $this->skillPrimae;
    }

    /**
     * Add Skillétence Primaire
     *
     * @param Skill $skill
     * 
     * @return self
     */
    public function addSkillPrimae(Skill $skill): self
    {
        if (!$this->skillPrimae->contains($skill)) {
            $this->skillPrimae[] = $skill;
            $skill->setFeaturePrimae($this);
        }

        return $this;
    }

    /**
     * Remove Skillétence Primaire
     *
     * @param Skill $skill
     * 
     * @return self
     */
    public function removeSkillPrimae(Skill $skill): self
    {
        if ($this->skillPrimae->contains($skill)) {
            $this->skillPrimae->removeElement($skill);
            if ($skill->getFeaturePrimae() === $this) {
                $skill->setFeaturePrimae(null);
            }
        }

        return $this;
    }

    /**
     * Get Compétences Secondaires
     * 
     * @return Collection|Skill[]|null
     */
    public function getSkillSecundae(): ?Collection
    {
        return $this->skillSecundae;
    }

    /**
     * Add Skillétence Secondaire
     *
     * @param Skill $skill
     * 
     * @return self
     */
    public function addSkillSecundae(Skill $skill): self
    {
        if (!$this->skillSecundae->contains($skill)) {
            $this->skillSecundae[] = $skill;
            $skill->setFeatureSecundae($this);
        }

        return $this;
    }

    /**
     * Remove Skillétence Secondaire
     *
     * @param Skill $skill
     * 
     * @return self
     */
    public function removeSkillSecundae(Skill $skill): self
    {
        if ($this->skillSecundae->contains($skill)) {
            $this->skillSecundae->removeElement($skill);
            if ($skill->getFeatureSecundae() === $this) {
                $skill->setFeatureSecundae(null);
            }
        }

        return $this;
    }

    /**
     * Get Compétences Tertiaires
     * 
     * @return Collection|Skill[]|null
     */
    public function getSkillTertiae(): ?Collection
    {
        return $this->skillTertiae;
    }

    /**
     * Add Skillétence Tertiaire
     *
     * @param Skill $skill
     * 
     * @return self
     */
    public function addSkillTertiae(Skill $skill): self
    {
        if (!$this->skillTertiae->contains($skill)) {
            $this->skillTertiae[] = $skill;
            $skill->setFeatureTertiae($this);
        }

        return $this;
    }

    /**
     * Remove Skillétence Tertiaire
     *
     * @param Skill $skill
     * 
     * @return self
     */
    public function removeSkillTertiae(Skill $skill): self
    {
        if ($this->skillTertiae->contains($skill)) {
            $this->skillTertiae->removeElement($skill);
            if ($skill->getFeatureTertiae() === $this) {
                $skill->setFeatureTertiae(null);
            }
        }

        return $this;
    }

    /**
     * Get Compétences Quaternaires
     * 
     * @return Collection|Skill[]|null
     */
    public function getSkillQuartae(): ?Collection
    {
        return $this->skillQuartae;
    }

    /**
     * Add Skillétence Quaternaire
     *
     * @param Skill $skill
     * 
     * @return self
     */
    public function addSkillQuartae(Skill $skill): self
    {
        if (!$this->skillQuartae->contains($skill)) {
            $this->skillQuartae[] = $skill;
            $skill->setFeatureQuartae($this);
        }

        return $this;
    }

    /**
     * Remove Skillétence Quaternaire
     *
     * @param Skill $skill
     * 
     * @return self
     */
    public function removeSkillQuartae(Skill $skill): self
    {
        if ($this->skillQuartae->contains($skill)) {
            $this->skillQuartae->removeElement($skill);
            if ($skill->getFeatureQuartae() === $this) {
                $skill->setFeatureQuartae(null);
            }
        }

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
     * @param string|null $pictureName
     * @return self
     */
    public function setPicture(?string $pictureName = null): self
    {
        $this->picture = $pictureName;
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
     * Get valueMax
     *
     * @return int|null
     */
    public function getValueMax(): ?int
    {
        return $this->valueMax;
    }

    /**
     * Set valueMax
     *
     * @param int|null $valueMax
     * @return self
     */
    public function setValueMax(?int $value = 100): self
    {
        $this->valueMax = $value;

        return $this;
    }

    /**
     * Get valueMin
     *
     * @return int|null
     */
    public function getValueMin(): ?int
    {
        return $this->valueMin;
    }
    
    /**
     * Set valueMin
     *
     * @param int $valueMin
     * @return self
     */
    public function setValueMin(int $value = 0): self
    {
        $this->valueMin = $value;

        return $this;
    }

    /**
     * Get valueAverage
     *
     * @return int|null
     */
    public function getValueAverage(): ?int
    {
        return $this->valueAverage;
    }

    /**
     * Set valueAverage
     *
     * @param int|null $valueAverage
     * @return self
     */
    public function setValueAverage(?int $value = 50): self
    {
        $this->valueAverage = $value;

        return $this;
    }
    
    /* ---------------------- Autres méthodes ---------------------- */

    public function getSkillsAssociation() 
    {
        $skillsAssociation = new ArrayCollection();

        foreach ($this->skillPrimae as $skill) {
            if (!$skillsAssociation->contains($skill)) {
                $skillsAssociation[] = $skill;
            }
        }

        foreach ($this->skillSecundae as $skill) {
            if (!$skillsAssociation->contains($skill)) {
                $skillsAssociation[] = $skill;
            }
        }

        foreach ($this->skillTertiae as $skill) {
            if (!$skillsAssociation->contains($skill)) {
                $skillsAssociation[] = $skill;
            }
        }

        foreach ($this->skillQuartae as $skill) {
            if (!$skillsAssociation->contains($skill)) {
                $skillsAssociation[] = $skill;
            }
        }

        return $skillsAssociation;
    }
}
