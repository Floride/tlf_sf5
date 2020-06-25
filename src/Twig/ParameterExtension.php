<?php
// src\Twig\ParameterExtension.php
namespace App\Twig;

use App\Entity\Site\Parameter;
use App\Repository\Site\ParameterRepository;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

/**
 * Class ParameterExtension
 *
 * PHP version 7.2.5
 *
 * @package    App\Twig
 * @author     Sylvain FLORIDE <sfloride@gmail.com>
 * @version    1.1.0
 */
class ParameterExtension extends AbstractExtension
{
    /**
     * @var ParameterRepository 
     */
    private $parameterRepository;

    /**
     * ParameterExtension Constructor
     *
     * @param EntityManagerInterface $objectManager
     * 
     * @return void
     */
    public function __construct(ParameterRepository $parameterRepository)
    {
        $this->parameterRepository = $parameterRepository; 
    }

    /**
     * getFunctions
     *
     * @return array
     */
    public function getFunctions(): array
    {
        return [
            new TwigFunction('siteParams',      [$this, 'getSiteParameters']),
            new TwigFunction('siteParameters',  [$this, 'getSiteParameters']),
        ];
    }

    /**
     * getSiteParameters
     *
     * @param string|null $value
     * 
     * @return string|null
     */
    public function getSiteParameters(?string $value = null): ?string
    {
        /**
         * @var Parameter
         */
        $parameter = $this->parameterRepository->findOneBy(['name' => $value]);
        
        return is_object($parameter) ? $parameter->getValue(): null;
    }
}
