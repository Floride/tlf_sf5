<?php
// src\Form\Character\SkillType.php
namespace App\Form\Admin\Character;

use App\Entity\Character\Feature;
use App\Entity\Character\Skill;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

/**
 * Class SkillType
 *
 * PHP version 7.2.5
 *
 * @package    App\Form
 * @author     Sylvain FLORIDE <sfloride@gmail.com>
 * @version    1.1.2
 */
class SkillType extends AbstractType
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
            ->add('type', ChoiceType::class, [
                'label' => 'label.type',
                'choices' => array_flip(Skill::TYPE)
            ])
            ->add('featurePrimae', EntityType::class, [
                'class' => Feature::class,
                'choice_label' => function ($feature) {
                    return $feature->getName() . ' [' . $feature->getAbbreviation() . ']';
                },
                'label' => 'label.featurePrimae',
                'placeholder' => 'placeholder.featurePrimae',
                'required' => false,
            ])
            ->add('featureSecundae', EntityType::class, [
                'class' => Feature::class,
                'choice_label' => function ($feature) {
                    return $feature->getName() . ' [' . $feature->getAbbreviation() . ']';
                },
                'label' => 'label.featureSecundae',
                'placeholder' => 'placeholder.featureSecundae',
                'required' => false,
            ])
            ->add('featureTertiae', EntityType::class, [
                'class' => Feature::class,
                'choice_label' => function ($feature) {
                    return $feature->getName() . ' [' . $feature->getAbbreviation() . ']';
                },
                'label' => 'label.featureTertiae',
                'placeholder' => 'placeholder.featureTertiae',
                'required' => false,
            ])
            ->add('featureQuartae', EntityType::class, [
                'class' => Feature::class,
                'choice_label' => function ($feature) {
                    return $feature->getName() . ' [' . $feature->getAbbreviation() . ']';
                },
                'label' => 'label.featureQuartae',
                'placeholder' => 'placeholder.featureQuartae',
                'required' => false,
            ])
            ->add('value', NumberType::class, [
                'label' => 'label.valueFixe',
                'required' => false,
            ])
            ->add('pictureFile', FileType::class, [
                'label' => 'label.illustration',
                'required' => false,
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
            'data_class' => Skill::class,
            'translation_domain' => 'forms',
        ]);
    }
}
