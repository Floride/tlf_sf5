<?php
// src\Entity\Character\Character.php
namespace App\Entity\Character;

use DateTimeImmutable;
use App\Mapping\EntityBase;
use App\Entity\Character\Rank;
use App\Entity\Character\Role;
use App\Entity\Game\Geo\Place;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\Character\Profession;
use App\Entity\Character\Speciality;
use App\Helper\ORM\IsEnablableTrait;
use App\Helper\ORM\IsDefaultableTrait;
use App\Entity\Character\Accreditation;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\HttpFoundation\File\File;
use Doctrine\Common\Collections\ArrayCollection;
use App\Repository\Character\CharacterRepository;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * Class Character
 *
 * PHP version 7.2.5
 *
 * @package    App\Entity
 * @author     Sylvain FLORIDE <sfloride@gmail.com>
 * @version    1.0.0
 *
 * @ORM\Entity(repositoryClass=CharacterRepository::class)
 * @ORM\HasLifecycleCallbacks
 * @ORM\Table(name="c_character")
 */
class Character extends EntityBase
{
    use IsDefaultableTrait;
    use IsEnablableTrait;
    
    const SEXE = [
        0 => 'Unknown',
        1 => 'Male',
        2 => 'Female'
    ];
    
    /**
     * @var int|null
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(name="id", type="integer")
     */
    private $id;

    /**
     * @var Colection|Accreditation[]|null
     * @ORM\ManyToMany(targetEntity=Accreditation::class, inversedBy="characters")
     * @ORM\JoinTable(name="join_character_accreditation",
     *      joinColumns={@ORM\JoinColumn(name="character_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="accreditation_id", referencedColumnName="id")}
     * )
     */
    private $accreditations;

    /**
     * @var Collection|CharacterAffectation[]|null 
     * @ORM\OneToMany(targetEntity=CharacterAffectation::class, mappedBy="character", orphanRemoval=true)
     */
    private $affectations;

    /**
     * @var string|null
     * @ORM\Column(type="text", nullable=true)
     */
    private $biography;

    /**
     * @var DateTimeImmutable|null Date of Birth
     * @ORM\Column(name="birth_date", type="datetime_immutable", nullable=false)
     * @Assert\NotBlank
     */
    private $birthDate;

    /**
     * @var Place|null
     * @ORM\ManyToOne(targetEntity=Place::class, inversedBy="birthCharacters")
     * @ORM\JoinColumn(name="birth_place_id", referencedColumnName="id", onDelete="SET NULL")
     */
    private $birthPlace;

    /**
     * @var Collection|CharacterFeature[]|null
     * @ORM\OneToMany(targetEntity=CharacterFeature::class, mappedBy="character", orphanRemoval=true)
     */
    private $features;

    /**
     * @var string|null
     * @ORM\Column(name="firthname", type="string", length=100, nullable=false)
     * @Assert\NotBlank
     */
    private $fistname;

    /**
     * @var string|null
     * @ORM\Column(name="lastname", type="string", length=100, nullable=false)
     * @Assert\NotBlank
     */
    private $lastname;

    /**
     * @var Collection|CharacterMedal[]|null
     * @ORM\OneToMany(targetEntity=CharacterMedal::class, mappedBy="character", orphanRemoval=true)
     */
    private $medals;

    /**
     * @var string|null
     * @ORM\Column(name="nickname", type="string", length=100, nullable=true)
     */
    private $nickname;

    /**
     * @var string|null Picture name
     * @ORM\Column(name="picture", type="string", length=255, nullable=true)
     */
    private $picture;

    /**
     * @var File|null
     * @Vich\UploadableField(mapping="character_feature_picture", fileNameProperty="picture")
     */
    private $pictureFile;

    /**
     * @var Profession|null
     * @ORM\ManyToOne(targetEntity=Profession::class, inversedBy="characters")
     * @ORM\JoinColumn(name="profession_id", referencedColumnName="id", onDelete="SET NULL")
     */
    private $profession;

    /**
     * @var Rank|null 
     * @ORM\ManyToOne(targetEntity=Rank::class, inversedBy="characters")
     * @ORM\JoinColumn(name="rank_id", referencedColumnName="id", onDelete="SET NULL")
     */
    private $rank;

    /**
     * @var Place|null
     * @ORM\ManyToOne(targetEntity=Place::class, inversedBy="recruitmentCharacters")
     * @ORM\JoinColumn(name="recruitment_place_id", referencedColumnName="id", onDelete="SET NULL")
     */
    private $recruitmentPlace;

    /**
     * @var Collection|Role[]|null
     * @ORM\ManyToMany(targetEntity=Role::class, inversedBy="characters")
     * @ORM\JoinTable(name="join_character_role",
     *      joinColumns={@ORM\JoinColumn(name="character_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="role_id", referencedColumnName="id")}
     * )
     */
    private $roles;

    /**
     * @var int|null sexe
     * @ORM\Column(name="sexe", type="smallint", nullable=false)
     */
    private $sexe;

    /**
     * @var Collection|CharacterSkill[]|null 
     * @ORM\OneToMany(targetEntity=CharacterSkill::class, mappedBy="character", orphanRemoval=true)
     */
    private $skills;

    /**
     * @var Speciality|null 
     * @ORM\ManyToOne(targetEntity=Speciality::class, inversedBy="characters")
     * @ORM\JoinColumn(name="speciality", onDelete="SET NULL")
     */
    private $speciality;

    /**
     * Character Constructor
     */
    public function __construct()
    {
        parent::__construct();
        $this->setDefault();
        $this->setEnable(); 
        $this->accreditations = new ArrayCollection();
        $this->affectations = new ArrayCollection();
        $this->features = new ArrayCollection();
        $this->medals = new ArrayCollection();
        $this->roles = new ArrayCollection();
        $this->skills = new ArrayCollection();
    }

    /* ---------------------- Setters & Getters ---------------------- */

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * getAccreditations
     *
     * @return Collection|Accreditation[]|null
     */
    public function getAccreditations(): ?Collection
    {
        return $this->accreditations;
    }

    /**
     * addAccreditation
     *
     * @param Accreditation $accreditation
     * @return self
     */
    public function addAccreditation(Accreditation $accreditation): self
    {
        if (!$this->accreditations->contains($accreditation)) {
            $this->accreditations[] = $accreditation;
        }

        return $this;
    }

    /**
     * removeAccreditation
     *
     * @param Accreditation $accreditation
     * @return self
     */
    public function removeAccreditation(Accreditation $accreditation): self
    {
        if ($this->accreditations->contains($accreditation)) {
            $this->accreditations->removeElement($accreditation);
        }

        return $this;
    }
    /**
     * getAffectations
     * 
     * @return Collection|CharacterAffectation[]
     */
    public function getAffectations(): Collection
    {
        return $this->affectations;
    }

    /**
     * addAffectation
     *
     * @param CharacterAffectation $affectation
     * @return self
     */
    public function addAffectation(CharacterAffectation $affectation): self
    {
        if (!$this->affectations->contains($affectation)) {
            $this->affectations[] = $affectation;
            $affectation->setCharacter($this);
        }

        return $this;
    }

    /**
     * removeAffectation
     *
     * @param CharacterAffectation $affectation
     * @return self
     */
    public function removeAffectation(CharacterAffectation $affectation): self
    {
        if ($this->affectations->contains($affectation)) {
            $this->affectations->removeElement($affectation);
            // set the owning side to null (unless already changed)
            if ($affectation->getCharacter() === $this) {
                $affectation->setCharacter(null);
            }
        }

        return $this;
    }
    
    /**
     * getBiography
     *
     * @return string|null
     */
    public function getBiography(): ?string
    {
        return $this->biography;
    }

    /**
     * setBiography
     *
     * @param string|null $biography
     * @return self
     */
    public function setBiography(?string $biography = null): self
    {
        $this->biography = $biography;

        return $this;
    }

    /**
     * getBirthDate
     *
     * @return DateTimeImmutable|null
     */
    public function getBirthDate(): ?DateTimeImmutable
    {
        return $this->birthDate;
    }

    /**
     * setBirthDate
     *
     * @param DateTimeImmutable|null $birthDate
     * @return self
     */
    public function setBirthDate(?DateTimeImmutable $birthDate = null): self
    {
        $this->birthDate = $birthDate;

        return $this;
    }

    /**
     * getBirthPlace
     *
     * @return Place|null
     */
    public function getBirthPlace(): ?Place
    {
        return $this->birthPlace;
    }

    /**
     * setBirthPlace
     *
     * @param Place|null $birthPlace
     * @return self
     */
    public function setBirthPlace(?Place $birthPlace = null): self
    {
        $this->birthPlace = $birthPlace;

        return $this;
    }
    
    /**
     * getCharacterFeatures
     * 
     * @return Collection|CharacterFeature[]
     */
    public function getFeatures(): Collection
    {
        return $this->features;
    }

    /**
     * addFeature
     *
     * @param CharacterFeature $feature
     * @return self
     */
    public function addFeature(CharacterFeature $feature): self
    {
        if (!$this->features->contains($feature)) {
            $this->features[] = $feature;
            $feature->setCharacter($this);
        }

        return $this;
    }

    /**
     * removeFeature
     *
     * @param CharacterFeature $feature
     * @return self
     */
    public function removeFeature(CharacterFeature $feature): self
    {
        if ($this->features->contains($feature)) {
            $this->features->removeElement($feature);
            // set the owning side to null (unless already changed)
            if ($feature->getCharacter() === $this) {
                $feature->setCharacter(null);
            }
        }

        return $this;
    }
    
    /**
     * getMedals
     * 
     * @return Collection|CharacterMedal[]|null
     */
    public function getMedals(): ?Collection
    {
        return $this->medals;
    }

    /**
     * addMedal
     *
     * @param CharacterMedal $medal
     * @return self
     */
    public function addMedal(CharacterMedal $medal): self
    {
        if (!$this->medals->contains($medal)) {
            $this->medals[] = $medal;
            $medal->setCharacter($this);
        }

        return $this;
    }

    /**
     * removeMedal
     *
     * @param CharacterMedal $medal
     * @return self
     */
    public function removeMedal(CharacterMedal $medal): self
    {
        if ($this->medals->contains($medal)) {
            $this->medals->removeElement($medal);
            // set the owning side to null (unless already changed)
            if ($medal->getCharacter() === $this) {
                $medal->setCharacter(null);
            }
        }

        return $this;
    }

    /**
     * getFistname
     *
     * @return string|null
     */
    public function getFistname(): ?string
    {
        return $this->fistname;
    }

    /**
     * setFistname
     *
     * @param string|null $fistname
     * @return self
     */
    public function setFistname(?string $fistname = null): self
    {
        $this->fistname = $fistname;

        return $this;
    }

    /**
     * getLastname
     *
     * @return string|null
     */
    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    /**
     * setLastname
     *
     * @param string|null $lastname
     * @return self
     */
    public function setLastname(?string $lastname = null): self
    {
        $this->lastname = $lastname;

        return $this;
    }

    /**
     * getNickname
     *
     * @return string|null
     */
    public function getNickname(): ?string
    {
        return $this->nickname;
    }

    /**
     * setNickname
     *
     * @param string|null $nickname
     * @return self
     */
    public function setNickname(?string $nickname = null): self
    {
        $this->nickname = $nickname;

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
     * getProfession
     *
     * @return Profession|null
     */
    public function getProfession(): ?Profession
    {
        return $this->profession;
    }

    /**
     * setProfession
     *
     * @param Profession|null $profession
     * @return self
     */
    public function setProfession(?Profession $profession = null): self
    {
        $this->profession = $profession;

        return $this;
    }

    /**
     * getRank
     *
     * @return Rank|null
     */
    public function getRank(): ?Rank
    {
        return $this->rank;
    }

    /**
     * setRank
     *
     * @param Rank|null $rank
     * @return self
     */
    public function setRank(?Rank $rank = null): self
    {
        $this->rank = $rank;

        return $this;
    }

    /**
     * getRecruitmentPlace
     *
     * @return Place|null
     */
    public function getRecruitmentPlace(): ?Place
    {
        return $this->recruitmentPlace;
    }

    /**
     * setRecruitmentPlace
     *
     * @param Place|null $recruitmentPlace
     * @return self
     */
    public function setRecruitmentPlace(?Place $recruitmentPlace = null): self
    {
        $this->recruitmentPlace = $recruitmentPlace;

        return $this;
    }

    /**
     * getRoles
     * 
     * @return Collection|Role[]
     */
    public function getRoles(): Collection
    {
        return $this->roles;
    }

    /**
     * addRole
     *
     * @param Role $role
     * @return self
     */
    public function addRole(Role $role): self
    {
        if (!$this->roles->contains($role)) {
            $this->roles[] = $role;
        }

        return $this;
    }

    /**
     * removeRole
     *
     * @param Role $role
     * @return self
     */
    public function removeRole(Role $role): self
    {
        if ($this->roles->contains($role)) {
            $this->roles->removeElement($role);
        }

        return $this;
    }

    /**
     * getSexe
     *
     * @return integer|null
     */
    public function getSexe(): ?int
    {
        return $this->sexe;
    }

    /**
     * setSexe
     *
     * @param integer|null $sexe
     * @return self
     */
    public function setSexe(?int $sexe = 0): self
    {
        $this->sexe = $sexe;

        return $this;
    }
    /**
     * getSkills
     * 
     * @return Collection|CharacterSkill[]
     */
    public function getSkills(): Collection
    {
        return $this->skills;
    }

    /**
     * addSkill
     *
     * @param CharacterSkill $skill
     * @return self
     */
    public function addSkill(CharacterSkill $skill): self
    {
        if (!$this->skills->contains($skill)) {
            $this->skills[] = $skill;
            $skill->setCharacter($this);
        }

        return $this;
    }

    /**
     * removeSkill
     *
     * @param CharacterSkill $skill
     * @return self
     */
    public function removeSkill(CharacterSkill $skill): self
    {
        if ($this->skills->contains($skill)) {
            $this->skills->removeElement($skill);
            // set the owning side to null (unless already changed)
            if ($skill->getCharacter() === $this) {
                $skill->setCharacter(null);
            }
        }

        return $this;
    }

    /**
     * getSpeciality
     *
     * @return Speciality|null
     */
    public function getSpeciality(): ?Speciality
    {
        return $this->speciality;
    }

    /**
     * setSpeciality
     *
     * @param Speciality|null $speciality
     * @return self
     */
    public function setSpeciality(?Speciality $speciality = null): self
    {
        $this->speciality = $speciality;

        return $this;
    }

    /* ---------------------- Autres méthodes ---------------------- */

}
