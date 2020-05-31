<?php
// src\Entity\Comps.php
namespace App\Entity;

use App\Entity\Caracs;
use App\Mapping\EntityBase;
use App\Repository\CompsRepository;
use Doctrine\ORM\Mapping as ORM;
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
 * @ORM\Entity(repositoryClass=CompsRepository::class)
 * @ORM\HasLifecycleCallbacks
 * @ORM\Table(name="perso_comps")
 * @Vich\Uploadable
 */
class Comps extends EntityBase
{
    const TYPE = [
        0 => 'Non précisée',
        1 => 'Connaissance',
        2 => 'Pratique'
    ];

    /**
     * @var int
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(name="id", type="integer")
     */
    private $id;

    /**
     * @var string
     * @ORM\Column(name="abreviation", type="string", nullable=false, length=4)
     * @Assert\NotBlank
     */
    private $abreviation;

    /**
     * @var Caracs|null
     * @ORM\ManyToOne(targetEntity=Caracs::class, inversedBy="compPrimae")
     * @ORM\JoinColumn(name="carac_1", nullable=false)
     * @Assert\NotBlank
     */
    private $caracPrimae;

    /**
     * @var Caracs|null
     * @ORM\ManyToOne(targetEntity=Caracs::class, inversedBy="compSecundae")
     * @ORM\JoinColumn(name="carac_2", nullable=true)
     */
    private $caracSecundae;

    /**
     * @var Caracs|null
     * @ORM\ManyToOne(targetEntity=Caracs::class, inversedBy="compTertiae")
     * @ORM\JoinColumn(name="carac_3", nullable=true)
     */
    private $caracTertiae;

    /**
     * @var Caracs|null
     * @ORM\ManyToOne(targetEntity=Caracs::class, inversedBy="compQuartae")
     * @ORM\JoinColumn(name="carac_4", nullable=true)
     */
    private $caracQuartae;

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
     * @ORM\Column(name="type", type="smallint", nullable=false, options={"default" : 0})
     * @Assert\NotBlank
     */
    private $type;
    
    /**
     * @var int
     * @ORM\Column(name="valeur", type="smallint", nullable=true)
     */
    private $Valeur;
    
    /**
     * Constructor
     */
    public function __construct()
    {
        parent::__construct();
        $this->setType();
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
     * Get Caractéristique Primaire
     *
     * @return Caracs|null
     */
    public function getCaracPrimae(): ?Caracs
    {
        return $this->caracPrimae;
    }

    /**
     * Set Caractéristique Primaire
     *
     * @param Caracs|null
     * @return self
     */
    public function setCaracPrimae(?Caracs $carac = null): self
    {
        $this->caracPrimae = $carac;

        return $this;
    }

    /**
     * Get Caractéristique Secondaire
     *
     * @return Caracs|null
     */
    public function getCaracSecundae(): ?Caracs
    {
        return $this->caracSecundae;
    }

    /**
     * Set Caractéristique Secondaire
     *
     * @param Caracs|null
     * @return self
     */
    public function setCaracSecundae(?Caracs $carac = null): self
    {
        $this->caracSecundae = $carac;

        return $this;
    }

    /**
     * Get Caractéristique Tertiaire
     *
     * @return Caracs|null
     */
    public function getCaracTertiae(): ?Caracs
    {
        return $this->caracTertiae;
    }

    /**
     * Set Caractéristique Tertiaire
     *
     * @param Caracs|null
     * @return self
     */
    public function setCaracTertiae(?Caracs $carac = null): self
    {
        $this->caracTertiae = $carac;

        return $this;
    }

    /**
     * Get Caractéristique Quaternaire
     *
     * @return Caracs|null
     */
    public function getCaracQuartae(): ?Caracs
    {
        return $this->caracQuartae;
    }

    /**
     * Set Caractéristique Quaternaire
     *
     * @param Caracs|null
     * @return self
     */
    public function setCaracQuartae(?Caracs $carac = null): self
    {
        $this->caracQuartae = $carac;

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
     * Get type
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
    
    /**
     * Get valeur
     *
     * @return int|null
     */
    public function getValeur(): ?int
    {
        return $this->valeur;
    }

    /**
     * Set type
     *
     * @param int|null $valeur
     * @return self
     */
    public function setValeur(?int $valeur = null): self
    {
        $this->valeur = $valeur;

        return $this;
    }
    
    /* ---------------------- Autres méthodes ---------------------- */

    /**
     * Get Calcul
     *
     * @return string|null
     */
    public function getCalcul(): ?string
    {
        $index = 0;
        $c1 = ($this->caracPrimae) ? $this->caracPrimae->getAbreviation() : null;
        $c2 = ($this->caracSecundae) ? $this->caracSecundae->getAbreviation() : null;
        $c3 = ($this->caracTertiae) ? $this->caracTertiae->getAbreviation() : null;
        $c4 = ($this->caracQuartae) ? $this->caracQuartae->getAbreviation() : null;
        $v = ($this->valeur) ? $this->valeur : null;
        $index += ($this->caracPrimae) ? 1 : 0;
        $index += ($this->caracSecundae) ? 2 : 0;
        $index += ($this->caracTertiae) ? 4 : 0;
        $index += ($this->caracQuartae) ? 8 : 0;
        $index += ($this->valeur) ? 16 : 0;

        switch ($index) { // 16 cas possibles.
            case 1: // C1 seule
                $return = $c1;
            break;
            case 2: // C2 seule
                $return = $c2;
            break;
            case 3: // C1 + C2
                $return = '(' . $c1 . ' + ' . $c2 . ') / 2';
            break;
            case 4: // C3 seule
                $return = $c3;
            break;
            case 7: // C1 + C2 + C3
                $return = '(' . $c1 . ' + ' . $c2 . ' + ' . $c3 . ') / 3';
            break;
            case 8: // C4 seule
                $return = $c4;
            break;
            case 15: // C1 + C2 + C3 + C4
                $return = '(' . $c1 . ' + ' . $c2 . ' + ' . $c3 . ' + ' . $c4 . ') / 4';
            break;
            case 16: // Valeur fixe seule
                $return = $v;
            break;
            case 17: // C1 + valeur fixe
                $return = '(' . $c1 . ' + ' . $v . ') / 2';
            break;
            case 18: // C2 + valeur fixe
                $return = $c2;
            break;
            case 19: // C1 + C2 + valeur fixe
                $return = '(' . $c1 . ' + ' . $c2 . ' + ' . $v. ') / 3';
            break;
            case 20: // C3 + valeur fixe
                $return = $c3;
            break;
            case 23: // C1 + C2 + C3 + valeur fixe
                $return = '(' . $c1 . ' + ' . $c2 . ' + ' . $c3 . ' + ' . $v. ') / 4';
            break;
            case 24: // C4 + valeur fixe
                $return = $c4;
            break;
            case 31: // C1 + C2 + C3 + C4 + valeur fixe
                $return = '(' . $c1 . ' + ' . $c2 . ' + ' . $c3 . ' + ' . $c4 . ' + ' . $v. ') / 5';
            break;
            default:
                $return = null;
            break;
        }

        return $return;
    }
}
