<?php
// src\Form\PersoCaracType.php
namespace App\Form;

use App\Entity\Caracs;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class PersoCaracType
 *
 * PHP version 7.2
 *
 * @package    App\Form
 * @author     Sylvain FLORIDE <sfloride@gmail.com>
 * @version    1.0.0
 */
class PersoCaracType extends AbstractType
{
    /**
     * buildForm
     *
     * @param FormBuilderInterface $builder
     * @param array $options
     * @return void
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom', TextType::class, [
                'label' => 'nom',
                'required' => true,
            ])
            ->add('abreviation', TextType::class, [
                'label' => 'abreviation',
                'required' => true,
            ])
            ->add('description', TextareaType::class, [
                'label' => 'description',
                'required' => true,
            ])
            ->add('picture', FileType::class, [
                'label' => 'illustration',
                'required' => false,
            ])
            ->add('valeurMin', NumberType::class, [
                'label' => 'valeurMin',
                'required' => false,
            ])
            ->add('valeurMax', NumberType::class, [
                'label' => 'valeurMax',
                'required' => false,
            ])
            ->add('valeurMoyenne', NumberType::class, [
                'label' => 'valeurMoyenne',
                'required' => false,
            ])
            ->add('type', ChoiceType::class, [
                'label' => 'type',
                'choices' => array_flip(Caracs::TYPE)
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
            'data_class' => Caracs::class,
            'translation_domain' => 'forms',
        ]);
    }
}
