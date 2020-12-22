<?php
// src\Form\Admin\Character\CharacterFeatureType.php
namespace App\Form\Admin\Character;

use Symfony\Component\Form\AbstractType;
use App\Entity\Character\CharacterFeature;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\NumberType;

/**
 * Class CharacterFeatureType
 *
 * PHP version 7.2.5
 *
 * @package    App\Form
 * @author     Sylvain FLORIDE <sfloride@gmail.com>
 * @version    1.0.0
 */
class CharacterFeatureType extends AbstractType
{
    /**
     * buildForm
     *
     * @param array                $options
     * @param FormBuilderInterface $builder
     * 
     * @return void
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('experienceUpgrade', NumberType::class, [
                'label' => false,
                'required' => true,
            ])
            ->add('value', NumberType::class, [
                'label' => false,
                'required' => true,
            ])
        ;
    }

    /**
     * configureOptions
     *
     * @param OptionsResolver $resolver
     * @return void
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => CharacterFeature::class,
            'translation_domain' => 'forms',
        ]);
    }
}
