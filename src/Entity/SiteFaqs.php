<?php
// src\Entity\SiteFaqs.php
namespace App\Entity;

use App\Mapping\EntityBase;
use App\Repository\SiteFaqsRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class SiteFaqs
 *
 * PHP version 7.2
 *
 * @package    App\Entity
 * @author     Sylvain FLORIDE <sfloride@gmail.com>
 * @version    1.0.0
 *
 * @ORM\Entity(repositoryClass=SiteFaqsRepository::class)
 * @ORM\HasLifecycleCallbacks
 * @ORM\Table(name="site_faqs")
 */
class SiteFaqs extends EntityBase
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(name="id", type="integer")
     */
    private $id;

    /**
     * @var string
     * @ORM\Column(name="question", type="string", length=512, unique=true, nullable=false)
     * @Assert\NotBlank
     */
    private $question;

    /**
     * @var string
     * @ORM\Column(name="response", type="text", nullable=false)
     * @Assert\NotBlank
     */
    private $reponse;

    /**
     * Constructor
     */
    public function __construct()
    {
        parent::__construct();
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
     * Get Question
     *
     * @return null|string
     */
    public function getQuestion(): ?string
    {
        return $this->question;
    }

    /**
     * Set Question
     *
     * @param string|null $question
     * @return self
     */
    public function setQuestion(string $question): self
    {
        $this->question = $question;

        return $this;
    }


    /**
     * Get Reponse
     *
     * @return null|string
     */
    public function getReponse(): ?string
    {
        return $this->reponse;
    }

    /**
     * Set Reponse
     *
     * @param string|null $reponse
     * @return self
     */
    public function setReponse(string $reponse): self
    {
        $this->reponse = $reponse;

        return $this;
    }
    
    /* ---------------------- Autres méthodes ---------------------- */
}
