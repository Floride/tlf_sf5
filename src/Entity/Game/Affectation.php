<?php
// src\Entity\Game\Affectation.php
namespace App\Entity\Game;

use App\Mapping\EntityBase;
use Doctrine\ORM\Mapping as ORM;
use App\Helper\ORM\NameableTrait;
use App\Helper\ORM\TypeableTrait;
use App\Helper\ORM\IsDefaultableTrait;
use App\Helper\ORM\IsObsoletableTrait;
use App\Helper\ORM\AbbreviationableTrait;
use Doctrine\Common\Collections\Collection;
use App\Helper\ORM\NeededDescriptionableTrait;
use App\Repository\Game\AffectationRepository;
use Doctrine\ORM\Mapping\HasLifecycleCallbacks;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Class Affectation
 *
 * PHP version 7.2.5
 *
 * @package    App\Entity
 * @author     Sylvain FLORIDE <sfloride@gmail.com>
 * @version    1.0.0
 * 
 * @ORM\Entity(repositoryClass=AffectationRepository::class)
 * @ORM\HasLifecycleCallbacks
 * @ORM\Table(name="g_affectation")
 */
class Affectation extends EntityBase
{
    use AbbreviationableTrait;
    use IsDefaultableTrait;
    use IsObsoletableTrait;
    use NameableTrait;
    use NeededDescriptionableTrait;
    use TypeableTrait;

    const TYPE = [
        0 => 'Not specified',
        1 => 'Operational',
        2 => 'Administrative',
        3 => 'Logistic'
    ];

    /**
     * @var int|null Table id
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(name="id", type="integer")
     */
    private $id;

    /**
     * @var Collection|Affectation[]|null
     * @ORM\OneToMany(targetEntity=Affectation::class, mappedBy="parent")
     */
    private $childs;

    /**
     * @var Affectation|null
     * @ORM\ManyToOne(targetEntity=Affectation::class, inversedBy="childs")
     * @ORM\JoinColumn(name="parent", onDelete="SET NULL")
     */
    private $parent;

    /**
     * Affectation Constructor
     */
    public function __construct()
    {
        parent::__construct();
        $this->setDefault();
        $this->setObsolete();
        $this->childs = new ArrayCollection();
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
     * getChilds
     * 
     * @return Collection|Affectation[]|null
     */
    public function getChilds(): ?Collection
    {
        return $this->childs;
    }

    /**
     * addChild
     *
     * @param Affectation $child
     * @return self
     */
    public function addChild(Affectation $child): self
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
     * @param Affectation $child
     * @return self
     */
    public function removeChild(Affectation $child): self
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
     * getParent
     *
     * @return self|null
     */
    public function getParent(): ?self
    {
        return $this->parent;
    }

    /**
     * setParent
     *
     * @param Affectation|null $parent
     * @return self
     */
    public function setParent(?Affectation $parent = null): self
    {
        $this->parent = $parent;

        return $this;
    }

    /* ---------------------- Autres méthodes ---------------------- */

}
