<?php
// src\Entity\Caracs.php
namespace App\Entity;

use App\Entity\Comps;
use App\Mapping\EntityBase;
use App\Repository\CaracsRepository;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Constraints as Assert;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * Class Caracs
 *
 * PHP version 7.2
 *
 * @package    App\Entity
 * @author     Sylvain FLORIDE <sfloride@gmail.com>
 * @version    1.0.0
 *
 * @ORM\Entity(repositoryClass=CaracsRepository::class)
 * @ORM\HasLifecycleCallbacks
 * @ORM\Table(name="perso_caracs")
 * @Vich\Uploadable
 */
class Caracs extends EntityBase
{
    const TYPE = [
        0 => 'Non précisée',
        1 => 'Physique',
        2 => 'Mentale'
    ];

    /**
     * @var int|null
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(name="id", type="integer")
     */
    private $id;

    /**
     * @var string|null
     * @ORM\Column(name="abreviation", type="string", nullable=false, length=4, unique=true)
     * @Assert\NotBlank
     */
    private $abreviation;

    /**
     * @var Collection|Comps[]|null
     * @ORM\OneToMany(targetEntity=Comps::class, mappedBy="caracPrimae")
     */
    private $compPrimae;

    /**
     * @var Collection|Comps[]|null
     * @ORM\OneToMany(targetEntity=Comps::class, mappedBy="caracSecundae")
     */
    private $compSecundae;

    /**
     * @var Collection|Comps[]|null
     * @ORM\OneToMany(targetEntity=Comps::class, mappedBy="caracTertiae")
     */
    private $compTertiae;

    /**
     * @var Collection|Comps[]|null
     * @ORM\OneToMany(targetEntity=Comps::class, mappedBy="caracQuartae")
     */
    private $compQuartae;

    /**
     * @var string|null
     * @ORM\Column(name="description", type="text", nullable=true)
     */
    private $description;

    /**
     * @var string|null
     * @ORM\Column(name="name", type="string", length=255, nullable=false)
     * @Assert\NotBlank
     */
    private $nom;

    /**
     * @var string|null Picture name
     * @ORM\Column(name="picture", type="string", length=255, nullable=true)
     */
    private $picture;

    /**
     * @var File|null
     * @Vich\UploadableField(mapping="caracs_pictures", fileNameProperty="picture")
     */
    private $pictureFile;

    /**
     * @var int
     * @ORM\Column(name="val_min", type="integer", nullable=false, options={"default" : 0})
     * @Assert\NotBlank
     */
    private $valeurMin;

    /**
     * @var int
     * @ORM\Column(name="val_max", type="integer", nullable=false, options={"default" : 100})
     * @Assert\NotBlank
     */
    private $valeurMax;

    /**
     * @var int
     * @ORM\Column(name="val_moy", type="integer", nullable=false, options={"default" : 50})
     * @Assert\NotBlank
     */
    private $valeurMoyenne;

    /**
     * @var int
     * @ORM\Column(name="type", type="smallint", nullable=false, options={"default" : 0})
     * @Assert\NotBlank
     */
    private $type;
    
    /**
     * Constructor
     */
    public function __construct()
    {
        parent::__construct();
        $this->setType();
        $this->compPrimae = new ArrayCollection();
        $this->compSecundae = new ArrayCollection();
        $this->compTertiae = new ArrayCollection();
        $this->compQuartae = new ArrayCollection();
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
     * Get abreviation
     *
     * @return string|null
     */
    public function getAbreviation(): ?string
    {
        return $this->abreviation;
    }

    /**
     * Set abreviation
     *
     * @param string $abreviation
     * @return self
     */
    public function setAbreviation(string $abreviation): self
    {
        $this->abreviation = $abreviation;

        return $this;
    }

    /**
     * Get Compétences Primaires
     * 
     * @return Collection|Comps[]
     */
    public function getCompPrimae(): Collection
    {
        return $this->compPrimae;
    }

    /**
     * Add Compétence Primaire
     *
     * @param Comps $comp
     * 
     * @return self
     */
    public function addCompPrimae(Comps $comp): self
    {
        if (!$this->compPrimae->contains($comp)) {
            $this->compPrimae[] = $comp;
            $comp->setCaracPrima($this);
        }

        return $this;
    }

    /**
     * Remove Compétence Primaire
     *
     * @param Comps $comp
     * 
     * @return self
     */
    public function removeCompPrimae(Comps $comp): self
    {
        if ($this->compPrimae->contains($comp)) {
            $this->compPrimae->removeElement($comp);
            // set the owning side to null (unless already changed)
            if ($comp->getCaracPrimae() === $this) {
                $comp->setCaracPrimae(null);
            }
        }

        return $this;
    }

    /**
     * Get Compétences Secondaires
     * 
     * @return Collection|Comps[]
     */
    public function getCompSecundae(): Collection
    {
        return $this->compSecundae;
    }

    /**
     * Add Compétence Secondaire
     *
     * @param Comps $comp
     * 
     * @return self
     */
    public function addCompSecundae(Comps $comp): self
    {
        if (!$this->compSecundae->contains($comp)) {
            $this->compSecundae[] = $comp;
            $comp->setCaracSecundae($this);
        }

        return $this;
    }

    /**
     * Remove Compétence Secondaire
     *
     * @param Comps $comp
     * 
     * @return self
     */
    public function removeCompSecundae(Comps $comp): self
    {
        if ($this->compSecundae->contains($comp)) {
            $this->compSecundae->removeElement($comp);
            // set the owning side to null (unless already changed)
            if ($comp->getCaracSecundae() === $this) {
                $comp->setCaracSecundae(null);
            }
        }

        return $this;
    }

    /**
     * Get Compétences Tertiaires
     * 
     * @return Collection|Comps[]
     */
    public function getCompTertiae(): Collection
    {
        return $this->compTertiae;
    }

    /**
     * Add Compétence Tertiaire
     *
     * @param Comps $comp
     * 
     * @return self
     */
    public function addCompTertiae(Comps $comp): self
    {
        if (!$this->compTertiae->contains($comp)) {
            $this->compTertiae[] = $comp;
            $comp->setCaracTertiae($this);
        }

        return $this;
    }

    /**
     * Remove Compétence Tertiaire
     *
     * @param Comps $comp
     * 
     * @return self
     */
    public function removeCompTertiae(Comps $comp): self
    {
        if ($this->compTertiae->contains($comp)) {
            $this->compTertiae->removeElement($comp);
            // set the owning side to null (unless already changed)
            if ($comp->getCaracTertiae() === $this) {
                $comp->setCaracTertiae(null);
            }
        }

        return $this;
    }

    /**
     * Get Compétences Quaternaires
     * 
     * @return Collection|Comps[]
     */
    public function getCompQuartae(): Collection
    {
        return $this->compQuartae;
    }

    /**
     * Add Compétence Quaternaire
     *
     * @param Comps $comp
     * 
     * @return self
     */
    public function addCompQuartae(Comps $comp): self
    {
        if (!$this->compQuartae->contains($comp)) {
            $this->compQuartae[] = $comp;
            $comp->setCaracQuartae($this);
        }

        return $this;
    }

    /**
     * Remove Compétence Quaternaire
     *
     * @param Comps $comp
     * 
     * @return self
     */
    public function removeCompQuartae(Comps $comp): self
    {
        if ($this->compQuartae->contains($comp)) {
            $this->compQuartae->removeElement($comp);
            // set the owning side to null (unless already changed)
            if ($comp->getCaracQuartae() === $this) {
                $comp->setCaracQuartae(null);
            }
        }

        return $this;
    }

    /**
     * Get description
     *
     * @return string|null
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * Set description
     *
     * @param string|null $description
     * @return self
     */
    public function setDescription(?string $description = null): self
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get nom
     *
     * @return string|null
     */
    public function getNom(): ?string
    {
        return $this->nom;
    }

    /**
     * Set nom
     *
     * @param string $nom
     * @return self
     */
    public function setNom(string $nom): self
    {
        $this->nom = $nom;

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
            $this->setUpdatedAt(new DateTime('now'));
        }

        return $this;
    }

    /**
     * Get valeurMax
     *
     * @return int|null
     */
    public function getValeurMax(): ?int
    {
        return $this->valeurMax;
    }

    /**
     * Set valeurMax
     *
     * @param int|null $valeurMax
     * @return self
     */
    public function setValeurMax(?int $valeurMax = 100): self
    {
        $this->valeurMax = $valeurMax;

        return $this;
    }

    /**
     * Get valeurMin
     *
     * @return int|null
     */
    public function getValeurMin(): ?int
    {
        return $this->valeurMin;
    }
    
    /**
     * Set valeurMin
     *
     * @param int $valeurMin
     * @return self
     */
    public function setValeurMin(int $valeurMin = 0): self
    {
        $this->valeurMin = $valeurMin;

        return $this;
    }

    /**
     * Get valeurMoyenne
     *
     * @return int|null
     */
    public function getValeurMoyenne(): ?int
    {
        return $this->valeurMoyenne;
    }

    /**
     * Set valeurMoyenne
     *
     * @param int|null $valeurMoyenne
     * @return self
     */
    public function setValeurMoyenne(?int $valeurMoyenne = 50): self
    {
        $this->valeurMoyenne = $valeurMoyenne;

        return $this;
    }

    /**
     * get type
     *
     * @return int|null
     */
    public function getType(): ?int
    {
        return $this->type;
    }

    /**
     * Set type
     *
     * @param int|null $type
     * @return self
     */
    public function setType(?int $type = 0): self
    {
        $this->type = $type;

        return $this;
    }
    
    /* ---------------------- Autres méthodes ---------------------- */

    public function getCompsAsso() 
    {
        $compAsso = new ArrayCollection();

        foreach($this->compPrimae as $comp) {
            if (!$compAsso->contains($comp)) {
                $compAsso[] = $comp;
            }
        }

        foreach($this->compSecundae as $comp) {
            if (!$compAsso->contains($comp)) {
                $compAsso[] = $comp;
            }
        }

        foreach($this->compTertiae as $comp) {
            if (!$compAsso->contains($comp)) {
                $compAsso[] = $comp;
            }
        }

        foreach($this->compQuartae as $comp) {
            if (!$compAsso->contains($comp)) {
                $compAsso[] = $comp;
            }
        }

        return $compAsso;
    }
}
