<?php
// src\Entity\Character\Profession.php
namespace App\Entity\Character;

use DateTimeImmutable;
use App\Mapping\EntityBase;
use Doctrine\ORM\Mapping as ORM;
use App\Helper\ORM\TypeableTrait;
use App\Entity\Character\Speciality;
use App\Helper\ORM\IsObsoletableTrait;
use App\Helper\ORM\IsPlayablableTrait;
use App\Helper\ORM\UniqueNameableTrait;
use Doctrine\Common\Collections\Collection;
use App\Helper\ORM\NeededDescriptionableTrait;
use Symfony\Component\HttpFoundation\File\File;
use Doctrine\Common\Collections\ArrayCollection;
use App\Repository\Character\ProfessionRepository;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * Class Profession
 *
 * PHP version 7.2.5
 *
 * @package    App\Entity
 * @author     Sylvain FLORIDE <sfloride@gmail.com>
 * @version    1.0.0
 * 
 * @ORM\Entity(repositoryClass=ProfessionRepository::class)
 * @ORM\HasLifecycleCallbacks
 * @ORM\Table(name="c_profession")
 * @Vich\Uploadable
 */
class Profession extends EntityBase
{
    use IsObsoletableTrait;
    use IsPlayablableTrait;
    use NeededDescriptionableTrait;
    use TypeableTrait;
    use UniqueNameableTrait;
    
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
     * @ORM\Column(name="id", type="integer")
     */
    private $id;

    /**
     * @var Collection|Character[]|null
     * @ORM\OneToMany(targetEntity=Character::class, mappedBy="profession")
     */
    private $characters;

    /**
     * @var string|null Picture name
     * @ORM\Column(name="picture", type="string", length=255, nullable=true)
     */
    private $picture;

    /**
     * @var File|null
     * @Vich\UploadableField(mapping="character_profession_picture", fileNameProperty="picture")
     */
    private $pictureFile;

    /**
     * @var Collection|Speciality[]|null
     * @ORM\OneToMany(targetEntity=Speciality::class, mappedBy="profession", orphanRemoval=true)
     */
    private $specialities;

    /**
     * Constructor
     */
    public function __construct()
    {
        parent::__construct();
        $this->setPlayable();
        $this->setObsolete();
        $this->setType();
        $this->specialities = new ArrayCollection();
        $this->characters = new ArrayCollection();
    }

    /* ---------------------- Setters & Getters ---------------------- */

    /**
     * Get Id
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
            $character->setProfession($this);
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
            if ($character->getProfession() === $this) {
                $character->setProfession(null);
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
     * Get specialities
     * 
     * @return Collection|Speciality[]|null
     */
    public function getSpecialities(): ?Collection
    {
        return $this->specialities;
    }

    /**
     * Add speciality
     *
     * @param Speciality $speciality
     * @return self
     */
    public function addSpeciality(Speciality $speciality): self
    {
        if (!$this->specialities->contains($speciality)) {
            $this->specialities[] = $speciality;
            $speciality->setProfession($this);
        }

        return $this;
    }
 
    /**
     * Remove speciality
     *
     * @param Speciality $speciality
     * @return self
     */
    public function removeSpeciality(Speciality $speciality): self
    {
        if ($this->specialities->contains($speciality)) {
            $this->specialities->removeElement($speciality);
            if ($speciality->getProfession() === $this) {
                $speciality->setProfession(null);
            }
        }

        return $this;
    }
    
    /* ---------------------- Autres méthodes ---------------------- */

}
