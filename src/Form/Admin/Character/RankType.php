<?php
// src\Form\Admin\Character\RankType.php
namespace App\Form\Admin\Character;

use App\Entity\Character\Rank;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
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
 * @version    1.0.0
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
                'label' => 'name',
                'required' => true,
            ])
            ->add('abbreviation', TextType::class, [
                'label' => 'abbreviation',
                'required' => true,
            ])
            ->add('description', TextareaType::class, [
                'label' => 'description',
                'required' => true,
            ])
            ->add('type', ChoiceType::class, [
                'label' => 'type',
                'choices' => array_flip(Rank::TYPE)
            ])
            ->add('category', ChoiceType::class, [
                'label' => 'category',
                'choices' => array_flip(Rank::CATEGORY)
            ])
            ->add('score', NumberType::class, [
                'label' => 'scale',
                'required' => false,
            ])
            ->add('scoreOL', NumberType::class, [
                'label' => 'scale_ol',
                'required' => false,
            ])
            ->add('picture', FileType::class, [
                'label' => 'illustration',
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
