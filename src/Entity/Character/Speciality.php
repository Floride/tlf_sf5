<?php
// src\Entity\Character\Speciality.php
namespace App\Entity\Character;

use DateTimeImmutable;
use App\Mapping\EntityBase;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use App\Helper\ORM\NameableTrait;
use App\Helper\ORM\TypeableTrait;
use App\Entity\Character\Profession;
use App\Helper\ORM\IsDefaultableTrait;
use App\Helper\ORM\IsObsoletableTrait;
use App\Helper\ORM\IsPlayablableTrait;
use App\Helper\ORM\NeededDescriptionableTrait;
use Symfony\Component\HttpFoundation\File\File;
use App\Repository\Character\SpecialityRepository;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * Class Speciality
 *
 * PHP version 7.2.5
 *
 * @package    App\Entity
 * @author     Sylvain FLORIDE <sfloride@gmail.com>
 * @version    1.0.1
 * 
 * @ORM\Entity(repositoryClass=SpecialityRepository::class)
 * @ORM\HasLifecycleCallbacks
 * @ORM\Table(name="c_speciality")
 * @Vich\Uploadable
 */
class Speciality extends EntityBase
{
    use IsDefaultableTrait;
    use IsObsoletableTrait;
    use IsPlayablableTrait;
    use NameableTrait;
    use NeededDescriptionableTrait;
    use TypeableTrait;

    const TYPE = [
        0 => 'Not specified',
        1 => 'Military',
        2 => 'Civilian',
        3 => 'Mixte',
        4 => 'Other'
    ];

    /**
     * @var int|null Table id
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @var Collection|Character[]|null
     * @ORM\OneToMany(targetEntity=Character::class, mappedBy="speciality")
     */
    private $characters;

    /**
     * @var string|null Picture name
     * @ORM\Column(name="picture", type="string", length=255, nullable=true)
     */
    private $picture;

    /**
     * @var File|null
     * @Vich\UploadableField(mapping="character_profession_speciality_picture", fileNameProperty="picture")
     */
    private $pictureFile;

    /**
     * @var Profession|null
     * @ORM\ManyToOne(targetEntity=Profession::class, inversedBy="specialities")
     * @ORM\JoinColumn(name="profession_id", referencedColumnName="id", onDelete="SET NULL")
     */
    private $profession;

    /**
     * Speciality Constructor
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
     * Get Table id
     *
     * @return null|int
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
    public function getCharacters(): Collection
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
            $character->setSpeciality($this);
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
            // set the owning side to null (unless already changed)
            if ($character->getSpeciality() === $this) {
                $character->setSpeciality(null);
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
     * @param string|null $picture
     * @return self
     */
    public function setPicture(?string $picture = null): self
    {
        $this->picture = $picture;
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
     * Get profession
     *
     * @return Profession|null
     */
    public function getProfession(): ?Profession
    {
        return $this->profession;
    }

    /**
     * Set profession
     *
     * @param Profession|null $profession
     * @return self
     */
    public function setProfession(?Profession $profession): self
    {
        $this->profession = $profession;

        return $this;
    }
    
    /* ---------------------- Autres méthodes ---------------------- */

}
