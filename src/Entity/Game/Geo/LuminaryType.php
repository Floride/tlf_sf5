<?php
// src\Entity\Game\Geo\LuminaryType.php
namespace App\Entity\Game\Geo;

use App\Mapping\EntityBase;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\Game\Geo\Luminary;
use App\Helper\ORM\NameableTrait;
use App\Helper\ORM\IsObsoletableTrait;
use App\Helper\ORM\DescriptionableTrait;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use App\Repository\Game\Geo\LuminaryTypeRepository;

/**
 * Class LuminaryType
 *
 * PHP version 7.2.5
 *
 * @package    App\Entity
 * @author     Sylvain FLORIDE <sfloride@gmail.com>
 * @version    1.0.0
 * 
 * @ORM\Entity(repositoryClass=LuminaryTypeRepository::class)
 * @ORM\HasLifecycleCallbacks
 * @ORM\Table(name="g_geo_luminary_type")
 */
class LuminaryType extends EntityBase
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
     * @var Collection|Luminary[]|null
     * @ORM\OneToMany(targetEntity=Luminary::class, mappedBy="type")
     */
    private $luminaries;

    /**
     * LuminaryType Constructor
     */
    public function __construct()
    {
        parent::__construct();
        $this->setObsolete();
        $this->luminaries = new ArrayCollection();
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
     * getLuminaries
     * 
     * @return Collection|Luminary[]|null
     */
    public function getLuminaries(): ?Collection
    {
        return $this->luminaries;
    }

    /**
     * addLuminary
     *
     * @param Luminary $luminary
     * @return self
     */
    public function addLuminary(Luminary $luminary): self
    {
        if (!$this->luminaries->contains($luminary)) {
            $this->luminaries[] = $luminary;
            $luminary->setType($this);
        }

        return $this;
    }

    /**
     * removeLuminary
     *
     * @param Luminary $luminary
     * @return self
     */
    public function removeLuminary(Luminary $luminary): self
    {
        if ($this->luminaries->contains($luminary)) {
            $this->luminaries->removeElement($luminary);
            // set the owning side to null (unless already changed)
            if ($luminary->getType() === $this) {
                $luminary->setType(null);
            }
        }

        return $this;
    }
    
    /* ---------------------- Autres méthodes ---------------------- */
}
