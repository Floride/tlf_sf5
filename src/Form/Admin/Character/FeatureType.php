<?php
// src\Form\Character\FeatureType.php
namespace App\Form\Admin\Character;

use App\Entity\Character\Feature;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class FeatureType
 *
 * PHP version 7.2.5
 *
 * @package    App\Form
 * @author     Sylvain FLORIDE <sfloride@gmail.com>
 * @version    1.1.0
 */
class FeatureType extends AbstractType
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
            ->add('name', TextType::class, [
                'label' => 'label.name',
                'required' => true,
            ])
            ->add('abbreviation', TextType::class, [
                'label' => 'label.abbreviation',
                'required' => true,
            ])
            ->add('description', TextareaType::class, [
                'label' => 'label.description',
                'required' => true,
            ])
            ->add('pictureFile', FileType::class, [
                'label' => 'label.illustration',
                'required' => false,
            ])
            ->add('valueMin', NumberType::class, [
                'label' => 'label.valueMax',
                'required' => false,
            ])
            ->add('valueMax', NumberType::class, [
                'label' => 'label.valueMax',
                'required' => false,
            ])
            ->add('valueAverage', NumberType::class, [
                'label' => 'label.valueAverage',
                'required' => false,
            ])
            ->add('type', ChoiceType::class, [
                'label' => 'label.type',
                'choices' => array_flip(Feature::TYPE)
            ])
        ;
    }

    /**
     * configureOptions
     *
     * @param OptionsResolver $resolver
     * 
     * @return void
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Feature::class,
            'translation_domain' => 'forms',
        ]);
    }
}
