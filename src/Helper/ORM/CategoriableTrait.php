<?php
// src\Helper\ORM\CategoriableTrait.php
namespace App\Helper\ORM;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Trait CategoriableTrait
 * 
 * PHP version 7.2.5
 *
 * @package    App\Helper
 * @author     Sylvain FLORIDE <sfloride@gmail.com>
 * @version    1.0.0
 */
trait CategoriableTrait
{
    /**
     * @var int|null
     * @ORM\Column(name="category", type="smallint", nullable=false, options={"default" : 0})
     * @Assert\NotBlank
     */
    private $category;

    /**
     * get Category
     *
     * @return int|null
     */
    public function getCategory(): ?int
    {
        return $this->category;
    }

    /**
     * Set Category
     *
     * @param int|null $category
     * 
     * @return self
     */
    public function setCategory(?int $category = 0): self
    {
        $this->category = $category;

        return $this;
    }
}
