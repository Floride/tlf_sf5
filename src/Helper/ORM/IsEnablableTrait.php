<?php
// src\Helper\ORM\IsEnablableTrait.php
namespace App\Helper\ORM;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Trait IsEnablableTrait
 * 
 * PHP version 7.2.5
 *
 * @package    App\Helper
 * @author     Sylvain FLORIDE <sfloride@gmail.com>
 * @version    1.0.0
 */
trait IsEnablableTrait
{
    /**
     * @var bool|null is enable ?
     * @ORM\Column(name="is_enable", type="boolean", options={"default" : true})
     */
    private $enable;

    /**
     * Get enabled
     *
     * @return bool|null
     */
    public function getEnable(): ?bool
    {
        return $this->enable;
    }

    /**
     * Set enable
     *
     * @param bool|null $enable
     * 
     * @return self
     */
    public function setEnable(?bool $enable = true): self
    {
        $this->enable = $enable;

        return $this;
    }
}
