<?php
// src\Mapping\EntityBaseInterface.php
namespace App\Mapping;

use DateTimeInterface;
use Doctrine\ORM\Mapping as ORM;

/**
 * interface EntityBaseInterface
 *
 * PHP version 7.2.5
 *
 * @package    App\Mapping
 * @author     Sylvain FLORIDE <sfloride@gmail.com>
 * @version    1.0.0
 */
interface EntityBaseInterface
{
    /**
     * @ORM\PrePersist
     * @ORM\PreUpdate
     */
    public function updatedTimestamps();

    /**
     * Get createdAt
     *
     * @return null|DateTimeInterface
     */
    public function getCreatedAt();

    /**
     * Set createdAt
     *
     * @param null|DateTimeInterface $createdAt
     * @return self
     */
    public function setCreatedAt(?DateTimeInterface $createdAt = null);
        
    /**
     * Get updatedAt
     *
     * @return DateTimeInterface $createdAt
     */
    public function getUpdatedAt();

    /**
     * Set updatedAt
     *
     * @param null|DateTimeInterface $updatedAt
     * @return self
     */
    public function setUpdatedAt(?DateTimeInterface $updatedAt = null);
}
