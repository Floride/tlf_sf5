<?php
// src\Mapping\EntityScenarioInterface.php
namespace App\Mapping;

use DateTimeInterface;
use App\Entity\Character\Medal;
use App\Mapping\EntityMissionInterface;

/**
 * interface EntityScenarioInterface
 *
 * PHP version 7.2.5
 *
 * @package    App\Mapping
 * @author     Sylvain FLORIDE <sfloride@gmail.com>
 * @version    1.0.0
 */
interface EntityScenarioInterface extends EntityBaseInterface
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
     * getMissions()
     *
     * @return Collection|EntityMissionInterface[]|null
     */
    public function getMissions(): ?Collection;

    /**
     * addMission()
     *
     * @param EntityMissionInterface|null
     * @return self
     */
    public function addMission(?EntityMissionInterface $mission = null);
    
    /**
     * removeMission()
     *
     * @param EntityMissionInterface|null
     * @return self
     */
    public function removeMission(?EntityMissionInterface $mission = null);
    
}