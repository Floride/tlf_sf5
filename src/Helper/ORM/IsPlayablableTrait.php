<?php
// src\Helper\ORM\IsPlayablableTrait.php
namespace App\Helper\ORM;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Trait IsPlayablableTrait
 * 
 * PHP version 7.2.5
 *
 * @package    App\Helper
 * @author     Sylvain FLORIDE <sfloride@gmail.com>
 * @version    1.0.0
 */
trait IsPlayablableTrait
{
    /**
     * @var bool|null is playable ?
     * @ORM\Column(name="is_playable", type="boolean", options={"default" : false})
     */
    private $playable;

    /**
     * Get enabled
     *
     * @return bool|null
     */
    public function getPlayable(): ?bool
    {
        return $this->playable;
    }

    /**
     * Set enable
     *
     * @param bool|null $playable
     * 
     * @return self
     */
    public function setPlayable(?bool $playable = false): self
    {
        $this->playable = $playable;

        return $this;
    }
}
