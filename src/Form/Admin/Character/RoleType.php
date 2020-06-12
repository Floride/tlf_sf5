<?php
// src\Form\Admin\Character\RoleType.php
namespace App\Form\Admin\Character;

use App\Entity\Character\Rank;
use App\Entity\Character\Role;
use App\Entity\Character\Accreditation;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

/**
 * Class RoleType
 *
 * .
 * PHP version 7.2.5
 *
 * @package    App\Form
 * @author     Sylvain FLORIDE <sfloride@gmail.com>
 * @version    1.0.0
 */
class RoleType extends AbstractType
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
                'choices' => array_flip(Role::TYPE),
                'required' => true,
            ])
            ->add('picture', FileType::class, [
                'label' => 'label.illustration',
                'required' => false,
            ])
            ->add('accreditationMin', EntityType::class, [
                'class' => Accreditation::class,
                'choice_label' => function ($accreditation) {
                    return $accreditation->getName() 
                        . ' [' . $accreditation->getAbbreviation(). ']'
                    ;
                },
                'label' => 'label.accreditation_min',
                'placeholder' => 'placeholder.accreditation_min',
                'required' => false,
            ])
            ->add('rankMin', EntityType::class, [
                'class' => Rank::class,
                'choice_label' => function ($rank) {
                    return $rank->getName();
                },
                'label' => 'label.rank',
                'placeholder' => 'placeholder.rank_min',
                'required' => true,
            ])
            ->add('rankMax', EntityType::class, [
                'class' => Rank::class,
                'choice_label' => function ($rank) {
                    return $rank->getName();
                },
                'label' => 'label.rank',
                'placeholder' => 'placeholder.rank_max',
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
            'data_class' => Role::class,
            'translation_domain' => 'forms',
        ]);
    }
}
