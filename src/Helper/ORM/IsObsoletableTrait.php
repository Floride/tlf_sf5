<?php
// src\Helper\ORM\IsObsoletableTrait.php
namespace App\Helper\ORM;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Trait IsObsoletableTrait
 * 
 * PHP version 7.2.5
 *
 * @package    App\Helper
 * @author     Sylvain FLORIDE <sfloride@gmail.com>
 * @version    1.0.0
 */
trait IsObsoletableTrait
{
    /**
     * @var bool|null is obsolete ?
     * @ORM\Column(name="is_obsolete", type="boolean", options={"default" : false})
     */
    private $obsolete;

    /**
     * Get obsoleted
     *
     * @return bool|null
     */
    public function getObsolete(): ?bool
    {
        return $this->obsolete;
    }

    /**
     * Set obsolete
     *
     * @param bool|null $obsolete
     * 
     * @return self
     */
    public function setObsolete(?bool $obsolete = false): self
    {
        $this->obsolete = $obsolete;

        return $this;
    }
}
