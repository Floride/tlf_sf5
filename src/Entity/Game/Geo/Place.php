<?php
// src\Entity\Game\Geo\Place.php
namespace App\Entity\Game\Geo;

use App\Entity\BirthPlace\BirthPlace;
use App\Entity\Character\Character;
use App\Mapping\EntityBase;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\Game\Geo\Luminary;
use App\Helper\ORM\NameableTrait;
use App\Entity\Game\Geo\PlaceType;
use App\Helper\ORM\IsObsoletableTrait;
use App\Helper\ORM\DescriptionableTrait;
use Doctrine\Common\Collections\Collection;
use App\Repository\Game\Geo\PlaceRepository;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Class Place
 *
 * PHP version 7.2.5
 *
 * @package    App\Entity
 * @author     Sylvain FLORIDE <sfloride@gmail.com>
 * @version    1.0.0
 * 
 * @ORM\Entity(repositoryClass=PlaceRepository::class)
 * @ORM\HasLifecycleCallbacks
 * @ORM\Table(name="g_geo_place")
 */
class Place extends EntityBase
{
    use IsObsoletableTrait;
    use NameableTrait;
    use DescriptionableTrait;

    /**
     * @var int|null Table id
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @var Collection|Character[]|null
     * @ORM\OneToMany(targetEntity=Character::class, mappedBy="birthPlace")
     */
    private $birthCharacters;

    /**
     * @var bool|null
     * @ORM\Column(name="is_birth_place", type="boolean", options={"default" : false})
     */
    private $birthPlace;

    /**
     * @var Collection|Place[]|null
     * @ORM\OneToMany(targetEntity=Place::class, mappedBy="parent")
     */
    private $childs;

    /**
     * @ORM\ManyToOne(targetEntity=Luminary::class, inversedBy="places")
     * @ORM\JoinColumn(name="luminary_id", referencedColumnName="id", onDelete="SET NULL")
     */
    private $luminary;

    /**
     * @var Place|null
     * @ORM\ManyToOne(targetEntity=Place::class, inversedBy="childs")
     * @ORM\JoinColumn(name="parent_id", referencedColumnName="id", onDelete="SET NULL")
     */
    private $parent;

    /**
     * @var Collection|Character[]|null
     * @ORM\OneToMany(targetEntity=Character::class, mappedBy="recruitmentPlace")
     */
    private $recruitmentCharacters;

    /**
     * @var bool|null
     * @ORM\Column(name="is_recruitment_place", type="boolean", options={"default" : false})
     */
    private $recruitmentPlace;

    /**
     * @var PlaceType|null
     * @ORM\ManyToOne(targetEntity=PlaceType::class, inversedBy="places")
     * @ORM\JoinColumn(name="type_id", referencedColumnName="id", onDelete="SET NULL")
     */
    private $type;

    /**
     * Place Constructor
     */
    public function __construct()
    {
        parent::__construct();
        $this->setObsolete();
        $this->setType();
        $this->childs = new ArrayCollection();
        $this->birthPlaces = new ArrayCollection();
        $this->birthCharacters = new ArrayCollection();
        $this->recruitmentCharacters = new ArrayCollection();
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
     * getBirthCharacters
     * 
     * @return Collection|Character[]|null
     */
    public function getBirthCharacters(): Collection
    {
        return $this->birthCharacters;
    }

    /**
     * addBirthCharacter
     *
     * @param Character $birthCharacter
     * @return self
     */
    public function addBirthCharacter(Character $birthCharacter): self
    {
        if (!$this->birthCharacters->contains($birthCharacter)) {
            $this->birthCharacters[] = $birthCharacter;
            $birthCharacter->setBirthPlace($this);
        }

        return $this;
    }

    /**
     * removeBirthCharacter
     *
     * @param Character $birthCharacter
     * @return self
     */
    public function removeBirthCharacter(Character $birthCharacter): self
    {
        if ($this->birthCharacters->contains($birthCharacter)) {
            $this->birthCharacters->removeElement($birthCharacter);
            // set the owning side to null (unless already changed)
            if ($birthCharacter->getBirthPlace() === $this) {
                $birthCharacter->setBirthPlace(null);
            }
        }

        return $this;
    }

    /**
     * getBirthPlace
     *
     * @return boolean|null
     */
    public function getBirthPlace(): ?bool
    {
        return $this->birthPlace;
    }

    /**
     * setBirthPlace
     *
     * @param boolean|null $bool
     * @return self
     */
    public function setBirthPlace(?bool $bool = false): self
    {
        $this->birthPlace = $bool;

        return $this;
    }

    /**
     * getChilds
     * 
     * @return Collection|Place[]|null
     */
    public function getChilds(): ?Collection
    {
        return $this->childs;
    }

    /**
     * addChild
     *
     * @param Place $child
     * @return self
     */
    public function addChild(Place $child): self
    {
        if (!$this->childs->contains($child)) {
            $this->childs[] = $child;
            $child->setParent($this);
        }

        return $this;
    }

    /**
     * removeChild
     *
     * @param Place $child
     * @return self
     */
    public function removeChild(Place $child): self
    {
        if ($this->childs->contains($child)) {
            $this->childs->removeElement($child);
            // set the owning side to null (unless already changed)
            if ($child->getParent() === $this) {
                $child->setParent(null);
            }
        }

        return $this;
    }
    
    /**
     * getLuminary
     *
     * @return Luminary|null
     */
    public function getLuminary(): ?Luminary
    {
        return $this->luminary;
    }

    /**
     * setLuminary
     *
     * @param Luminary|null $luminary
     * @return self
     */
    public function setLuminary(?Luminary $luminary = null): self
    {
        $this->luminary = $luminary;

        return $this;
    }

    /**
     * getParent
     *
     * @return Place|null
     */
    public function getParent(): ?Place
    {
        return $this->parent;
    }

    public function setParent(?Place $parent = null): Place
    {
        $this->parent = $parent;

        return $this;
    }

    /**
     * getRecruitmentCharacters
     * 
     * @return Collection|Character[]
     */
    public function getRecruitmentCharacters(): Collection
    {
        return $this->recruitmentCharacters;
    }

    /**
     * addRecruitmentCharacter
     *
     * @param Character $recruitmentCharacter
     * @return self
     */
    public function addRecruitmentCharacter(Character $recruitmentCharacter): self
    {
        if (!$this->recruitmentCharacters->contains($recruitmentCharacter)) {
            $this->recruitmentCharacters[] = $recruitmentCharacter;
            $recruitmentCharacter->setRecruitmentPlace($this);
        }

        return $this;
    }

    /**
     * removeRecruitmentCharacter
     *
     * @param Character $recruitmentCharacter
     * @return self
     */
    public function removeRecruitmentCharacter(Character $recruitmentCharacter): self
    {
        if ($this->recruitmentCharacters->contains($recruitmentCharacter)) {
            $this->recruitmentCharacters->removeElement($recruitmentCharacter);
            // set the owning side to null (unless already changed)
            if ($recruitmentCharacter->getRecruitmentPlace() === $this) {
                $recruitmentCharacter->setRecruitmentPlace(null);
            }
        }

        return $this;
    }

    /**
     * getRecruitmentPlace
     *
     * @return boolean|null
     */
    public function getRecruitmentPlace(): ?bool
    {
        return $this->recruitmentPlace;
    }

    /**
     * setRecruitmentPlace
     *
     * @param boolean|null $bool
     * @return self
     */
    public function setRecruitmentPlace(?bool $bool = false): self
    {
        $this->recruitmentPlace = $bool;

        return $this;
    }

    /**
     * getType
     *
     * @return PlaceType|null
     */
    public function getType(): ?PlaceType
    {
        return $this->type;
    }

    /**
     * setType
     *
     * @param PlaceType|null $type
     * 
     * @return self
     */
    public function setType(?PlaceType $type = null): self
    {
        $this->type = $type;

        return $this;
    }

    /* ---------------------- Autres méthodes ---------------------- */

}
