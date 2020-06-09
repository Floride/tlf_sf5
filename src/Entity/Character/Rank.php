<?php
// src\Entity\Character\Rank.php
namespace App\Entity\Character;

use App\Mapping\EntityBase;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use App\Helper\ORM\TypeableTrait;
use App\Helper\ORM\CategoriableTrait;
use App\Helper\ORM\IsDefaultableTrait;
use App\Helper\ORM\IsObsoletableTrait;
use App\Helper\ORM\IsPlayablableTrait;
use App\Helper\ORM\UniqueNameableTrait;
use App\Helper\ORM\DescriptionableTrait;
use App\Helper\ORM\AbbreviationableTrait;
use App\Repository\Character\RankRepository;
use Symfony\Component\HttpFoundation\File\File;
use Doctrine\Common\Collections\ArrayCollection;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class Rank
 *
 * PHP version 7.2.5
 *
 * @package    App\Entity
 * @author     Sylvain FLORIDE <sfloride@gmail.com>
 * @version    1.0.0
 *
 * @ORM\Entity(repositoryClass=RankRepository::class)
 * @ORM\HasLifecycleCallbacks
 * @ORM\Table(name="c_rank")
 * @Vich\Uploadable
 */
class Rank extends EntityBase
{
    use AbbreviationableTrait;
    use CategoriableTrait;
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
    ];
    
    const CATEGORY = [
        0 => 'Not specified',
        1 => 'Homme du Rang',
        2 => 'Sous-officier',
        3 => 'Officier',
        4 => 'Officier Général',
        5 => 'Elève',
    ];

    /**
     * @var int|null Table id
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

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
     * @var int|null score min to promote
     * @ORM\Column(name="score", type="integer", options={"default" : 0})
     */
    private $score;

    /**
     * @var int|null score OL min to promote
     * @ORM\Column(name="score_ol", type="integer", nullable=true)
     */
    private $scoreOL;

    /**
     * @ORM\OneToMany(targetEntity=Role::class, mappedBy="rankMin")
     */
    private $rolesMin;

    /**
     * @ORM\OneToMany(targetEntity=Role::class, mappedBy="rankMax")
     */
    private $rolesMax;

    /**
     * Rank Constructor
     */
    public function __construct()
    {
        parent::__construct();
        $this->setDefault();
        $this->setPlayable();
        $this->setObsolete();
        $this->setType();
        $this->rolesMin = new ArrayCollection();
        $this->rolesMax = new ArrayCollection();
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
     * @return Collection|Role[]
     */
    public function getRolesMin(): Collection
    {
        return $this->rolesMin;
    }

    public function addRolesMin(Role $rolesMin): self
    {
        if (!$this->rolesMin->contains($rolesMin)) {
            $this->rolesMin[] = $rolesMin;
            $rolesMin->setRankMin($this);
        }

        return $this;
    }

    public function removeRolesMin(Role $rolesMin): self
    {
        if ($this->rolesMin->contains($rolesMin)) {
            $this->rolesMin->removeElement($rolesMin);
            // set the owning side to null (unless already changed)
            if ($rolesMin->getRankMin() === $this) {
                $rolesMin->setRankMin(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Role[]
     */
    public function getRolesMax(): Collection
    {
        return $this->rolesMax;
    }

    public function addRolesMax(Role $rolesMax): self
    {
        if (!$this->rolesMax->contains($rolesMax)) {
            $this->rolesMax[] = $rolesMax;
            $rolesMax->setRankMax($this);
        }

        return $this;
    }

    public function removeRolesMax(Role $rolesMax): self
    {
        if ($this->rolesMax->contains($rolesMax)) {
            $this->rolesMax->removeElement($rolesMax);
            // set the owning side to null (unless already changed)
            if ($rolesMax->getRankMax() === $this) {
                $rolesMax->setRankMax(null);
            }
        }

        return $this;
    }
    
    /**
     * getScore
     *
     * @return int|null
     */
    public function getScore(): ?int
    {
        return $this->score;
    }

    /**
     * setScore
     *
     * @param int|null $score
     * @return self
     */
    public function setScore(?int $score = 0): self
    {
        $this->score = $score;

        return $this;
    }
    
    /**
     * getScoreOL
     *
     * @return int|null
     */
    public function getScoreOL(): ?int
    {
        return $this->scoreOL;
    }

    /**
     * setScoreOL
     *
     * @param int|null $score
     * @return self
     */
    public function setScoreOL(?int $score = null): self
    {
        $this->scoreOL = $score;

        return $this;
    }
}