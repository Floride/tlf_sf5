<?php
// src\Helper\ORM\NameableTrait.php
namespace App\Helper\ORM;

use Doctrine\ORM\Mapping as ORM;

/**
 * Trait NameableTrait
 *
 * PHP version 7.2.5
 *
 * @package    App\Helper
 * @author     Sylvain FLORIDE <sfloride@gmail.com>
 * @version    1.0.0
 */
trait NameableTrait
{
    /**
     * @var string|null
     * @ORM\Column(name="name", type="string", length=255, nullable=true)
     */
    private $name;

    /**
     * Get name
     *
     * @return string|null
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * Set name
     *
     * @param string|null $name
     * @return self
     */
    public function setName(?string $name = null): self
    {
        $this->name = $name;

        return $this;
    }
}
