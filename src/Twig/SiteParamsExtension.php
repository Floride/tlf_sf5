<?php

namespace App\Twig;

use Twig\TwigFilter;
use Twig\TwigFunction;
use App\Entity\SiteParams;
use Twig\Extension\AbstractExtension;
use App\Repository\SiteParamsRepository;
use Doctrine\ORM\EntityManagerInterface;

class SiteParamsExtension extends AbstractExtension
{
    /**
     * @var EntityManagerInterface
     */
    private $manager;
    
    /**
     * @var SiteParamsRepository
     */
    private $paramsRepository;

    /**
     * Constructor
     *
     * @param EntityManagerInterface $objectManager
     * 
     * @return void
     */
    public function __construct(EntityManagerInterface $entityManager, SiteParamsRepository $paramsRepository)
    {
        $this->manager = $entityManager; 
        $this->paramsRepository = $paramsRepository; 
    }

    /**
     * getFilters
     *
     * @return array
     */
    public function getFilters(): array
    {
        return [];
    }

    /**
     * getFunctions
     *
     * @return array
     */
    public function getFunctions(): array
    {
        return [
            new TwigFunction('siteParam', [$this, 'siteParam']),
        ];
    }

    /**
     * siteParam
     *
     * @param string|null $value
     * 
     * @return string|null
     */
    public function siteParam(?string $value = null): ?string
    {
        /**
         * @var SiteParams
         */
        $param = $this->paramsRepository->findOneBy(['nom' => $value]);
        
        return is_object($param) ? $param->getValeur(): null;
    }
}
