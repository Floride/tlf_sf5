<?php
// src\Entity\Site\Parameter.php
namespace App\Entity\Site;

use App\Mapping\EntityBase;
use Doctrine\ORM\Mapping as ORM;
use App\Helper\ORM\UniqueNameableTrait;
use App\Repository\Site\ParameterRepository;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class Parameter
 *
 * PHP version 7.2.5
 *
 * @package    App\Entity
 * @author     Sylvain FLORIDE <sfloride@gmail.com>
 * @version    1.0.0
 *
 * @ORM\Entity(repositoryClass=ParameterRepository::class)
 * @ORM\HasLifecycleCallbacks
 * @ORM\Table(name="s_parameter")
 */
class Parameter extends EntityBase
{
    use UniqueNameableTrait;

    /**
     * @var int|null Table id
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(name="id", type="integer")
     */
    private $id;

    /**
     * @var string
     * @ORM\Column(name="value", type="text", nullable=false)
     * @Assert\NotBlank
     */
    private $value;

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
     * Get value
     *
     * @return null|string
     */
    public function getValue(): ?string
    {
        return $this->value;
    }

    /**
     * Set value
     *
     * @param string|null $value
     * @return self
     */
    public function setValue(string $value): self
    {
        $this->value = $value;

        return $this;
    }
    
    /* ---------------------- Autres méthodes ---------------------- */
}
