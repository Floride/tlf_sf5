<?php
// src\Helper\ORM\IsDefaultableTrait.php
namespace App\Helper\ORM;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Trait IsDefaultableTrait
 * 
 * PHP version 7.2.5
 *
 * @package    App\Helper
 * @author     Sylvain FLORIDE <sfloride@gmail.com>
 * @version    1.0.0
 */
trait IsDefaultableTrait
{
    /**
     * @var bool|null is default ?
     * @ORM\Column(name="is_default", type="boolean", nullable=false, options={"default" : false})
     */
    private $default;

    /**
     * Get default
     *
     * @return bool|null
     */
    public function getDefault(): ?bool
    {
        return $this->default;
    }

    /**
     * Set default
     *
     * @param bool|null $default
     * 
     * @return self
     */
    public function setDefault(?bool $default = false): self
    {
        $this->default = $default;

        return $this;
    }
}
