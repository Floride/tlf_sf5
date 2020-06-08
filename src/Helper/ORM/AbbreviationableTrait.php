<?php
// src\Helper\ORM\AbbreviationableTrait.php
namespace App\Helper\ORM;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Trait AbbreviationableTrait
 *
 * PHP version 7.2.5
 *
 * @package    App\Helper
 * @author     Sylvain FLORIDE <sfloride@gmail.com>
 * @version    1.0.0
 */
trait AbbreviationableTrait
{
    /**
     * @var string|null
     * @ORM\Column(name="abbreviation", type="string", nullable=false, length=10, unique=true)
     * @Assert\NotBlank
     */
    private $abbreviation;

    /**
     * Get abbreviation
     *
     * @return string|null
     */
    public function getAbbreviation(): ?string
    {
        return $this->abbreviation;
    }

    /**
     * Set abbreviation
     *
     * @param string|null $abbreviation
     * 
     * @return self
     */
    public function setAbbreviation(?string $abbreviation = null): self
    {
        $this->abbreviation = $abbreviation;

        return $this;
    }
}
