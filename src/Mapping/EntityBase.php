<?php
// src\Mapping\EntityBase.php
namespace App\Mapping;

use DateTimeImmutable;
use DateTimeInterface;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class EntityBase
 *
 * PHP version 7.2.5
 *
 * @package    App\Mapping
 * @author     Sylvain FLORIDE <sfloride@gmail.com>
 * @version    1.0.0
 *
 * @ORM\HasLifecycleCallbacks
 */
class EntityBase implements EntityBaseInterface
{
    /**
     * @var null|DateTimeImmutable $created
     *
     * @ORM\Column(name="created_at", type="datetime_immutable", nullable=false)
     */
    protected $createdAt;

    /**
     * @var null|DateTimeImmutable $updated
     *
     * @ORM\Column(name="updated_at", type="datetime_immutable", nullable=false)
     */
    protected $updatedAt;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->setCreatedAt(new DateTimeImmutable());
    }

    /**
     * @ORM\PrePersist
     * @ORM\PreUpdate
     *
     * @return void
     */
    public function updatedTimestamps(): void
    {
        $dateTimeNow = new DateTimeImmutable('now');

        $this->setUpdatedAt($dateTimeNow);

        if ($this->getCreatedAt() === null) {
            $this->setCreatedAt($dateTimeNow);
        }
    }

    /**
     * @see EntityBaseInterface
     */
    public function getCreatedAt() :?DateTimeInterface
    {
        return $this->createdAt;
    }
 
    /**
     * @see EntityBaseInterface
     */
    public function setCreatedAt(?DateTimeInterface $createdAt = null): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * @see EntityBaseInterface
     */
    public function getUpdatedAt(): ?DateTimeInterface
    {
        return $this->updatedAt;
    }
    
    /**
     * @see EntityBaseInterface
     */
    public function setUpdatedAt(?DateTimeInterface $updatedAt = null): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }
}
