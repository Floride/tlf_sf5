<?php
// src\Mapping\EntityMissionInterface.php
namespace App\Mapping;

use DateTimeInterface;

/**
 * interface EntityMissionInterface
 *
 * PHP version 7.2.5
 *
 * @package    App\Mapping
 * @author     Sylvain FLORIDE <sfloride@gmail.com>
 * @version    1.0.0
 */
interface EntityMissionInterface extends EntityBaseInterface
{
    /**
     * Get beginAt
     *
     * @return DateTimeInterface|null
     */
    public function getBeginAt(): ?DateTimeInterface;
    
    /**
     * Set beginAt
     *
     * @param DateTimeInterface|null
     * @return self
     */
    public function setBeginAt(?EntityScenarioInterface $date = null);

    /**
     * getAchivmentMedal
     *
     * @return Medal|null
     */
    public function getAchivmentMedal(): ?Medal;

    /**
     * setAchivmentMedal
     *
     * @param Medal|null $medal
     * @return self
     */
    public function setAchivmentMedal(?Medal $medal = null);

    /**
     * getObjectifs()
     *
     * @return Collection|EntityObjectifInterface[]|null
     */
    public function getObjectifs(): ?Collection;

    /**
     * addObjectif()
     *
     * @param EntityObjectifInterface|null
     * @return self
     */
    public function addObjectif(?EntityObjectifInterface $objectif = null);
    
    /**
     * removeObjectif()
     *
     * @param EntityObjectifInterface|null
     * @return self
     */
    public function removeObjectif(?EntityObjectifInterface $objectif = null);

}