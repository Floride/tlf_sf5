<?php
// src\Form\Admin\Character\RankType.php
namespace App\Form\Admin\Character;

use App\Entity\Character\Rank;
use App\Entity\Character\Accreditation;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

/**
 * Class RankType
 *
 * PHP version 7.2.5
 *
 * @package    App\Form
 * @author     Sylvain FLORIDE <sfloride@gmail.com>
 * @version    1.1.0
 */
class RankType extends AbstractType
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
                'choices' => array_flip(Rank::TYPE)
            ])
            ->add('category', ChoiceType::class, [
                'label' => 'label.category',
                'choices' => array_flip(Rank::CATEGORY)
            ])
            ->add('score', NumberType::class, [
                'label' => 'label.score_rank_std',
                'required' => false,
            ])
            ->add('scoreOL', NumberType::class, [
                'label' => 'label.score_rank_ol',
                'required' => false,
            ])
            ->add('pictureFile', FileType::class, [
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
                'placeholder' => 'placeholder.accreditationMin',
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
            'data_class' => Rank::class,
            'translation_domain' => 'forms',
        ]);
    }
}
