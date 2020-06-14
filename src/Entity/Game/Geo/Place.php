<?php
// src\Entity\Game\Geo\Place.php
namespace App\Entity\Game\Geo;

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
     * @var PlaceType|null
     * @ORM\ManyToOne(targetEntity=PlaceType::class, inversedBy="places")
     * @ORM\JoinColumn(name="type", onDelete="SET NULL")
     */
    private $type;

    /**
     * @ORM\ManyToOne(targetEntity=Luminary::class, inversedBy="places")
     * @ORM\JoinColumn(name="luminary", onDelete="SET NULL")
     */
    private $luminary;

    /**
     * @ORM\ManyToOne(targetEntity=Place::class, inversedBy="childs")
     * @ORM\JoinColumn(name="parent", onDelete="SET NULL")
     */
    private $parent;

    /**
     * @ORM\OneToMany(targetEntity=Place::class, mappedBy="parent")
     */
    private $childs;

    /**
     * Place Constructor
     */
    public function __construct()
    {
        parent::__construct();
        $this->setObsolete();
        $this->setType();
        $this->childs = new ArrayCollection();
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
