<?php
// src\Entity\Character\Accreditation.php
namespace App\Entity\Character;

use App\Mapping\EntityBase;
use Doctrine\ORM\Mapping as ORM;
use App\Helper\ORM\TypeableTrait;
use App\Helper\ORM\CategoriableTrait;
use App\Helper\ORM\IsDefaultableTrait;
use App\Helper\ORM\IsPlayablableTrait;
use App\Helper\ORM\UniqueNameableTrait;
use App\Helper\ORM\DescriptionableTrait;
use App\Helper\ORM\AbbreviationableTrait;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use App\Repository\Character\AccreditationRepository;

/**
 * Class Role
 *
 * PHP version 7.2.5
 *
 * @package    App\Entity
 * @author     Sylvain FLORIDE <sfloride@gmail.com>
 * @version    1.0.0
 *
 * @ORM\Entity(repositoryClass=AccreditationRepository::class)
 * @ORM\HasLifecycleCallbacks
 * @ORM\Table(name="c_accreditation")
 */
class Accreditation extends EntityBase
{
    use AbbreviationableTrait;
    use CategoriableTrait;
    use DescriptionableTrait;
    use IsDefaultableTrait;
    use IsPlayablableTrait;
    use TypeableTrait;
    use UniqueNameableTrait;

    const TYPE = [
        0 => 'Not specified',
        1 => 'Military',
        2 => 'Civilian',
        3 => 'Mixte',
    ];
    
    const CATEGORY = [
        0 => 'Not specified',
        1 => 'Régimental',
        2 => 'Commissioner',
        3 => 'Other'
    ];

    /**
     * @var int|null Table id
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(name="id", type="integer")
     */
    private $id;

    /**
     * @var Collection|Character[]|null
     * @ORM\ManyToMany(targetEntity=Character::class, mappedBy="accreditations")
     */
    private $characters;

    /**
     * @var int|null
     * @ORM\Column(name="level", type="smallint", options={"default" : 0})
     */
    private $level;

    /**
     * @var Collection|Role[]|null
     * @ORM\OneToMany(targetEntity=Role::class, mappedBy="accreditationMin")
     */
    private $rolesMin;

    /**
     * @var Collection|Rank[]|null
     * @ORM\OneToMany(targetEntity=Rank::class, mappedBy="accreditationMin")
     */
    private $ranksMin;

    /**
     * Skill Constructor
     */
    public function __construct()
    {
        parent::__construct();
        $this->setType();
        $this->setDefault();
        $this->setPlayable();
        $this->characters = new ArrayCollection();
        $this->rolesMin = new ArrayCollection();
        $this->ranksMin = new ArrayCollection();
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
     * @return Collection|Character[]|null
     */
    public function getCharacters(): ?Collection
    {
        return $this->characters;
    }

    /**
     * addCharacter
     *
     * @param Character $character
     * @return self
     */
    public function addCharacter(Character $character): self
    {
        if (!$this->characters->contains($character)) {
            $this->characters[] = $character;
            $character->addAccreditation($this);
        }

        return $this;
    }

    /**
     * removeCharacter
     *
     * @param Character $character
     * @return self
     */
    public function removeCharacter(Character $character): self
    {
        if ($this->characters->contains($character)) {
            $this->characters->removeElement($character);
            $character->removeAccreditation($this);
        }

        return $this;
    }

    /**
     * getLevel
     *
     * @return int|null
     */
    public function getLevel(): ?int
    {
        return $this->level;
    }

    /**
     * setLevel
     *
     * @param int|null $level
     * @return self
     */
    public function setLevel(?int $level = 0): self
    {
        $this->level = $level;

        return $this;
    }

    /**
     * getRanksMin
     * 
     * @return Collection|Rank[]|null
     */
    public function getRanksMin(): ?Collection
    {
        return $this->ranksMin;
    }

    /**
     * addRanksMin
     *
     * @param Rank $ranksMin
     * @return self
     */
    public function addRanksMin(Rank $ranksMin): self
    {
        if (!$this->ranksMin->contains($ranksMin)) {
            $this->ranksMin[] = $ranksMin;
            $ranksMin->setAccreditationMin($this);
        }

        return $this;
    }

    /**
     * removeRanksMin
     *
     * @param Rank $ranksMin
     * @return self
     */
    public function removeRanksMin(Rank $ranksMin): self
    {
        if ($this->ranksMin->contains($ranksMin)) {
            $this->ranksMin->removeElement($ranksMin);
            // set the owning side to null (unless already changed)
            if ($ranksMin->getAccreditationMin() === $this) {
                $ranksMin->setAccreditationMin(null);
            }
        }

        return $this;
    }

    /**
     * getRolesMin
     * 
     * @return Collection|Role[]|null
     */
    public function getRolesMin(): ?Collection
    {
        return $this->rolesMin;
    }

    /**
     * addRolesMin
     *
     * @param Role $rolesMin
     * @return self
     */
    public function addRolesMin(Role $rolesMin): self
    {
        if (!$this->rolesMin->contains($rolesMin)) {
            $this->rolesMin[] = $rolesMin;
            $rolesMin->setAccreditationMin($this);
        }

        return $this;
    }

    /**
     * removeRolesMin
     *
     * @param Role $rolesMin
     * @return self
     */
    public function removeRolesMin(Role $rolesMin): self
    {
        if ($this->rolesMin->contains($rolesMin)) {
            $this->rolesMin->removeElement($rolesMin);
            // set the owning side to null (unless already changed)
            if ($rolesMin->getAccreditationMin() === $this) {
                $rolesMin->setAccreditationMin(null);
            }
        }

        return $this;
    }
    
    /* ---------------------- Autres méthodes ---------------------- */

}
