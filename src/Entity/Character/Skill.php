<?php
// src\Entity\Character\Skill.php
namespace App\Entity\Character;

use DateTimeImmutable;
use App\Mapping\EntityBase;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\Character\Feature;
use App\Helper\ORM\TypeableTrait;
use App\Helper\ORM\IsObsoletableTrait;
use App\Helper\ORM\UniqueNameableTrait;
use App\Helper\ORM\DescriptionableTrait;
use App\Helper\ORM\AbbreviationableTrait;
use App\Repository\Character\SkillRepository;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * Class Skill
 *
 * PHP version 7.2.5
 *
 * @package    App\Entity
 * @author     Sylvain FLORIDE <sfloride@gmail.com>
 * @version    1.0.0
 *
 * @ORM\Entity(repositoryClass=SkillRepository::class)
 * @ORM\HasLifecycleCallbacks
 * @ORM\Table(name="c_skill")
 * @Vich\Uploadable
 */
class Skill extends EntityBase
{
    use AbbreviationableTrait;
    use DescriptionableTrait;
    use IsObsoletableTrait;
    use TypeableTrait;
    use UniqueNameableTrait;

    const TYPE = [
        0 => 'Not specified',
        1 => 'Knowledge',
        2 => 'Practice'
    ];

    /**
     * @var int|null Table id
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(name="id", type="integer")
     */
    private $id;

    /**
     * @var Feature|null
     * @ORM\ManyToOne(targetEntity=Feature::class, inversedBy="skillPrimae")
     * @ORM\JoinColumn(name="feature_1", onDelete="SET NULL")
     * @Assert\NotBlank
     */
    private $featurePrimae;

    /**
     * @var Feature|null
     * @ORM\ManyToOne(targetEntity=Feature::class, inversedBy="skillSecundae")
     * @ORM\JoinColumn(name="feature_2", onDelete="SET NULL")
     */
    private $featureSecundae;

    /**
     * @var Feature|null
     * @ORM\ManyToOne(targetEntity=Feature::class, inversedBy="skillTertiae")
     * @ORM\JoinColumn(name="feature_3", onDelete="SET NULL")
     */
    private $featureTertiae;

    /**
     * @var Feature|null
     * @ORM\ManyToOne(targetEntity=Feature::class, inversedBy="skillQuartae")
     * @ORM\JoinColumn(name="feature_4", onDelete="SET NULL")
     */
    private $featureQuartae;

    /**
     * @var string|null Picture name
     * @ORM\Column(name="picture", type="string", length=255, nullable=true)
     */
    private $picture;

    /**
     * @var File|null
     * @Vich\UploadableField(mapping="character_skill_picture", fileNameProperty="picture")
     */
    private $pictureFile;
    
    /**
     * @var int
     * @ORM\Column(name="value", type="smallint", nullable=true)
     */
    private $value;
    
    /**
     * Skill Constructor
     */
    public function __construct()
    {
        parent::__construct();
        $this->setType();
        $this->setObsolete();
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
     * Get Caratéristique Primaire
     *
     * @return Feature|null
     */
    public function getFeaturePrimae(): ?Feature
    {
        return $this->featurePrimae;
    }

    /**
     * Set Caratéristique Primaire
     *
     * @param Feature|null
     * @return self
     */
    public function setFeaturePrimae(?Feature $feature = null): self
    {
        $this->featurePrimae = $feature;

        return $this;
    }

    /**
     * Get Caratéristique Secondaire
     *
     * @return Feature|null
     */
    public function getFeatureSecundae(): ?Feature
    {
        return $this->featureSecundae;
    }

    /**
     * Set Caratéristique Secondaire
     *
     * @param Feature|null
     * @return self
     */
    public function setFeatureSecundae(?Feature $feature = null): self
    {
        $this->featureSecundae = $feature;

        return $this;
    }

    /**
     * Get Caratéristique Tertiaire
     *
     * @return Feature|null
     */
    public function getFeatureTertiae(): ?Feature
    {
        return $this->featureTertiae;
    }

    /**
     * Set Caratéristique Tertiaire
     *
     * @param Feature|null
     * @return self
     */
    public function setFeatureTertiae(?Feature $feature = null): self
    {
        $this->featureTertiae = $feature;

        return $this;
    }

    /**
     * Get Caratéristique Quaternaire
     *
     * @return Feature|null
     */
    public function getFeatureQuartae(): ?Feature
    {
        return $this->featureQuartae;
    }

    /**
     * Set Caratéristique Quaternaire
     *
     * @param Feature|null
     * @return self
     */
    public function setFeatureQuartae(?Feature $feature = null): self
    {
        $this->featureQuartae = $feature;

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
     * Get value
     *
     * @return int|null
     */
    public function getValue(): ?int
    {
        return $this->value;
    }

    /**
     * Set type
     *
     * @param int|null $value
     * @return self
     */
    public function setValue(?int $value = null): self
    {
        $this->value = $value;

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
        $c1 = ($this->featurePrimae) ? $this->featurePrimae->getAbbreviation() : null;
        $c2 = ($this->featureSecundae) ? $this->featureSecundae->getAbbreviation() : null;
        $c3 = ($this->featureTertiae) ? $this->featureTertiae->getAbbreviation() : null;
        $c4 = ($this->featureQuartae) ? $this->featureQuartae->getAbbreviation() : null;
        $v = ($this->value) ? $this->value : null;
        $index += ($this->featurePrimae) ? 1 : 0;
        $index += ($this->featureSecundae) ? 2 : 0;
        $index += ($this->featureTertiae) ? 4 : 0;
        $index += ($this->featureQuartae) ? 8 : 0;
        $index += ($this->value) ? 16 : 0;

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
            case 17: // C1 + value fixe
                $return = '(' . $c1 . ' + ' . $v . ') / 2';
            break;
            case 18: // C2 + value fixe
                $return = $c2;
            break;
            case 19: // C1 + C2 + value fixe
                $return = '(' . $c1 . ' + ' . $c2 . ' + ' . $v. ') / 3';
            break;
            case 20: // C3 + value fixe
                $return = $c3;
            break;
            case 23: // C1 + C2 + C3 + value fixe
                $return = '(' . $c1 . ' + ' . $c2 . ' + ' . $c3 . ' + ' . $v. ') / 4';
            break;
            case 24: // C4 + value fixe
                $return = $c4;
            break;
            case 31: // C1 + C2 + C3 + C4 + value fixe
                $return = '(' . $c1 . ' + ' . $c2 . ' + ' . $c3 . ' + ' . $c4 . ' + ' . $v. ') / 5';
            break;
            default:
                $return = null;
            break;
        }

        return $return;
    }
}
