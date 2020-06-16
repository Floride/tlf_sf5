<?php
// src\Entity\Character\Role.php
namespace App\Entity\Character;

use DateTimeImmutable;
use App\Mapping\EntityBase;
use App\Entity\Character\Rank;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use App\Helper\ORM\TypeableTrait;
use App\Helper\ORM\IsDefaultableTrait;
use App\Helper\ORM\IsObsoletableTrait;
use App\Helper\ORM\IsPlayablableTrait;
use App\Helper\ORM\UniqueNameableTrait;
use App\Helper\ORM\DescriptionableTrait;
use App\Helper\ORM\AbbreviationableTrait;
use App\Repository\Character\RoleRepository;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * Class Role
 *
 * PHP version 7.2.5
 *
 * @package    App\Entity
 * @author     Sylvain FLORIDE <sfloride@gmail.com>
 * @version    1.0.0
 *
 * @ORM\Entity(repositoryClass=RoleRepository::class)
 * @ORM\HasLifecycleCallbacks
 * @ORM\Table(name="c_role")
 * @Vich\Uploadable
 */
class Role extends EntityBase
{
    use AbbreviationableTrait;
    use DescriptionableTrait;
    use IsDefaultableTrait;
    use IsObsoletableTrait;
    use IsPlayablableTrait;
    use TypeableTrait;
    use UniqueNameableTrait;

    const TYPE = [
        0 => 'Not specified',
        1 => 'Military',
        2 => 'Civilian',
        3 => 'Mixte',
    ];

    /**
     * @var int|null Table id
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Accreditation::class, inversedBy="rolesMin")
     * @ORM\JoinColumn(name="lvl_accred_min_id", referencedColumnName="id", onDelete="SET NULL")
     */
    private $accreditationMin;

    /**
     * @var string|null Picture name
     * @ORM\Column(name="picture", type="string", length=255, nullable=true)
     */
    private $picture;

    /**
     * @var File|null
     * @Vich\UploadableField(mapping="character_rank_picture", fileNameProperty="picture")
     */
    private $pictureFile;

    /**
     * @var Rank|null
     * @ORM\ManyToOne(targetEntity=Rank::class, inversedBy="rolesMin")
     * @ORM\JoinColumn(name="rank_min_id", referencedColumnName="id", onDelete="SET NULL")
     */
    private $rankMin;

    /**
     * @var Rank|null
     * @ORM\ManyToOne(targetEntity=Rank::class, inversedBy="rolesMax")
     * @ORM\JoinColumn(name="rank_max_id", referencedColumnName="id", onDelete="SET NULL")
     */
    private $rankMax;

    /**
     * @var Collection|Character[]|null
     * @ORM\ManyToMany(targetEntity=Character::class, mappedBy="roles")
     */
    private $characters;

    /**
     * Role Constructor
     */
    public function __construct()
    {
        parent::__construct();
        $this->setDefault();
        $this->setPlayable();
        $this->setObsolete();
        $this->setType();
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

    public function getAccreditationMin(): ?Accreditation
    {
        return $this->accreditationMin;
    }

    public function setAccreditationMin(?Accreditation $accreditationMin): self
    {
        $this->accreditationMin = $accreditationMin;

        return $this;
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
            $character->addRole($this);
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
            $character->removeRole($this);
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
            $this->setUpdatedAt(new DateTimeImmutable('now'));
        }

        return $this;
    }

    /**
     * getRankMin
     *
     * @return Rank|null
     */
    public function getRankMin(): ?Rank
    {
        return $this->rankMin;
    }

    /**
     * setRankMin
     *
     * @param Rank|null $rankMin
     * @return self
     */
    public function setRankMin(?Rank $rankMin): self
    {
        $this->rankMin = $rankMin;

        return $this;
    }

    /**
     * getRankMax
     *
     * @return Rank|null
     */
    public function getRankMax(): ?Rank
    {
        return $this->rankMax;
    }

    /**
     * setRankMax
     *
     * @param Rank|null $rankMax
     * @return self
     */
    public function setRankMax(?Rank $rankMax): self
    {
        $this->rankMax = $rankMax;

        return $this;
    }
    
    /* ---------------------- Autres méthodes ---------------------- */

}
