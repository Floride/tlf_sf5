<?php
// src\Mapping\EntityCampaignInterface.php
namespace App\Mapping;

use App\Entity\Character\Medal;
use DateTimeInterface;
use App\Mapping\EntityScenarioInterface;
use Doctrine\Common\Collections\Collection;

/**
 * interface EntityCampaignInterface
 *
 * PHP version 7.2.5
 *
 * @package    App\Mapping
 * @author     Sylvain FLORIDE <sfloride@gmail.com>
 * @version    1.0.0
 */
interface EntityCampaignInterface extends EntityBaseInterface
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
     * @param EntityScenarioInterface|null $medal
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
     * getScenario()
     *
     * @return Collection|EntityScenarioInterface[]|null
     */
    public function getScenario(): ?Collection;

    /**
     * addScenario()
     *
     * @param EntityScenarioInterface|null
     * @return self
     */
    public function addScenario(?EntityScenarioInterface $scenario = null);
    
    /**
     * removeScenarion()
     *
     * @param EntityScenarioInterface|null
     * @return self
     */
    public function removeScenarion(?EntityScenarioInterface $scenario = null);
}