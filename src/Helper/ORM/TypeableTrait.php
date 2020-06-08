<?php
// src\Helper\ORM\TypeableTrait.php
namespace App\Helper\ORM;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Trait TypeableTrait
 * 
 * PHP version 7.2.5
 *
 * @package    App\Helper
 * @author     Sylvain FLORIDE <sfloride@gmail.com>
 * @version    1.0.0
 */
trait TypeableTrait
{
    /**
     * @var int
     * @ORM\Column(name="type", type="smallint", nullable=false, options={"default" : 0})
     * @Assert\NotBlank
     */
    private $type;

    /**
     * get type
     *
     * @return int|null
     */
    public function getType(): ?int
    {
        return $this->type;
    }

    /**
     * Set type
     *
     * @param int|null $type
     * 
     * @return self
     */
    public function setType(?int $type = 0): self
    {
        $this->type = $type;

        return $this;
    }
}
