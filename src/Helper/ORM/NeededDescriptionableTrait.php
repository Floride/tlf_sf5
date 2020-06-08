<?php
// src\Helper\ORM\NeededDescriptionableTrait.php
namespace App\Helper\ORM;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Trait NeededDescriptionableTrait
 *
 * PHP version 7.2.5
 *
 * @package    App\Helper
 * @author     Sylvain FLORIDE <sfloride@gmail.com>
 * @version    1.0.0
 */
trait NeededDescriptionableTrait
{
    /**
     * @var string|null
     * @ORM\Column(name="description", type="text", nullable=false)
     * @Assert\NotBlank
     */
    private $description;

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
}
