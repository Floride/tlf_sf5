<?php
// src\Entity\Game\Geo\Luminary.php
namespace App\Entity\Game\Geo;

use App\Mapping\EntityBase;
use Doctrine\ORM\Mapping as ORM;
use App\Helper\ORM\NameableTrait;
use App\Entity\Game\Geo\LuminaryType;
use App\Helper\ORM\IsObsoletableTrait;
use App\Helper\ORM\DescriptionableTrait;
use Doctrine\Common\Collections\Collection;
use App\Repository\Game\Geo\LuminaryRepository;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Class Luminary
 *
 * PHP version 7.2.5
 *
 * @package    App\Entity
 * @author     Sylvain FLORIDE <sfloride@gmail.com>
 * @version    1.0.0
 * 
 * @ORM\Entity(repositoryClass=LuminaryRepository::class)
 * @ORM\HasLifecycleCallbacks
 * @ORM\Table(name="g_geo_luminary")
 */
class Luminary extends EntityBase
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
     * @var Luminary|null
     * @ORM\ManyToOne(targetEntity=Luminary::class, inversedBy="dependencies")
     * @ORM\JoinColumn(name="around", onDelete="SET NULL")
     */
    private $around;

    /**
     * @var Collection|Luminary[]|null
     * @ORM\OneToMany(targetEntity=Luminary::class, mappedBy="around")
     */
    private $dependencies;

    /**
     * @var LuminaryType|null
     * @ORM\ManyToOne(targetEntity=LuminaryType::class, inversedBy="luminaries")
     * @ORM\JoinColumn(name="type", onDelete="SET NULL")
     */
    private $type;

    /**
     * @ORM\OneToMany(targetEntity=Place::class, mappedBy="luminary")
     */
    private $places;
    
    /**
     * Luminary Constructor
     */
    public function __construct()
    {
        parent::__construct();
        $this->setObsolete();
        $this->setType();
        $this->dependencies = new ArrayCollection();
        $this->places = new ArrayCollection();
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
     * getAround
     *
     * @return self|null
     */
    public function getAround(): ?self
    {
        return $this->around;
    }

    /**
     * setAround
     *
     * @param self|null $around
     * @return self
     */
    public function setAround(?self $around): self
    {
        $this->around = $around;

        return $this;
    }

    /**
     * getDependencies
     * 
     * @return Collection|Luminary[]|null
     */
    public function getDependencies(): ?Collection
    {
        return $this->dependencies;
    }

    /**
     * addDependency
     *
     * @param self $dependency
     * @return self
     */
    public function addDependency(self $dependency): self
    {
        if (!$this->dependencies->contains($dependency)) {
            $this->dependencies[] = $dependency;
            $dependency->setAround($this);
        }

        return $this;
    }

    /**
     * removeDependency
     *
     * @param self $dependency
     * @return self
     */
    public function removeDependency(self $dependency): self
    {
        if ($this->dependencies->contains($dependency)) {
            $this->dependencies->removeElement($dependency);
            // set the owning side to null (unless already changed)
            if ($dependency->getAround() === $this) {
                $dependency->setAround(null);
            }
        }

        return $this;
    }
    /**
     * getPlaces
     * 
     * @return Collection|Place[]
     */
    public function getPlaces(): Collection
    {
        return $this->places;
    }

    /**
     * addPlace
     *
     * @param Place $place
     * @return self
     */
    public function addPlace(Place $place): self
    {
        if (!$this->places->contains($place)) {
            $this->places[] = $place;
            $place->setLuminary($this);
        }

        return $this;
    }

    /**
     * removePlace
     *
     * @param Place $place
     * @return self
     */
    public function removePlace(Place $place): self
    {
        if ($this->places->contains($place)) {
            $this->places->removeElement($place);
            // set the owning side to null (unless already changed)
            if ($place->getLuminary() === $this) {
                $place->setLuminary(null);
            }
        }

        return $this;
    }

    /**
     * getType
     *
     * @return LuminaryType|null
     */
    public function getType(): ?LuminaryType
    {
        return $this->type;
    }

    /**
     * setType
     *
     * @param LuminaryType|null $type
     * @return self
     */
    public function setType(?LuminaryType $type = null): self
    {
        $this->type = $type;

        return $this;
    }
    
    /* ---------------------- Autres méthodes ---------------------- */


}
