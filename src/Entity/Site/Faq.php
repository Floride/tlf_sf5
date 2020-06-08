<?php
// src\Entity\Site\Faq.php
namespace App\Entity\Site;

use App\Mapping\EntityBase;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\Site\FaqRepository;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class Faq
 *
 * PHP version 7.2.5
 *
 * @package    App\Entity
 * @author     Sylvain FLORIDE <sfloride@gmail.com>
 * @version    1.0.0
 *
 * @ORM\Entity(repositoryClass=FaqRepository::class)
 * @ORM\HasLifecycleCallbacks
 * @ORM\Table(name="s_faq")
 */
class Faq extends EntityBase
{
    /**
     * @var int|null Table id
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
     * Faq Constructor
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
    public function setQuestion(?string $question = null): self
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
    public function setReponse(?string $reponse = null): self
    {
        $this->reponse = $reponse;

        return $this;
    }
    
    /* ---------------------- Autres méthodes ---------------------- */
}
