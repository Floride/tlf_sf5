<?php
// src\Entity\Game\Geo\PlaceType.php
namespace App\Entity\Game\Geo;

use App\Mapping\EntityBase;
use App\Entity\Game\Geo\Place;
use Doctrine\ORM\Mapping as ORM;
use App\Helper\ORM\NameableTrait;
use App\Helper\ORM\IsObsoletableTrait;
use App\Helper\ORM\DescriptionableTrait;
use Doctrine\Common\Collections\Collection;
use App\Repository\Game\Geo\PlaceTypeRepository;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Class PlaceType
 *
 * PHP version 7.2.5
 *
 * @package    App\Entity
 * @author     Sylvain FLORIDE <sfloride@gmail.com>
 * @version    1.0.0
 * 
 * @ORM\Entity(repositoryClass=PlaceTypeRepository::class)
 * @ORM\HasLifecycleCallbacks
 * @ORM\Table(name="g_geo_place_type")
 */
class PlaceType extends EntityBase
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
     * @var Collection|Place[]|null
     * @ORM\OneToMany(targetEntity=Place::class, mappedBy="type")
     */
    private $places;

    /**
     * PlaceType Constructor
     */
    public function __construct()
    {
        parent::__construct();
        $this->setObsolete();
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
     * getPlaces
     * 
     * @return Collection|Place[]|null
     */
    public function getPlaces(): ?Collection
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
            $place->setType($this);
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
            if ($place->getType() === $this) {
                $place->setType(null);
            }
        }

        return $this;
    }
    
    /* ---------------------- Autres méthodes ---------------------- */
}
