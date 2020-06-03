<?php
// src\Form\PersoCompType.php
namespace App\Form;

use App\Entity\Comps;
use App\Entity\Caracs;
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
 * Class PersoCompType
 *
 * PHP version 7.2
 *
 * @package    App\Form
 * @author     Sylvain FLORIDE <sfloride@gmail.com>
 * @version    1.0.0
 */
class PersoCompType extends AbstractType
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
            ->add('type', ChoiceType::class, [
                'label' => 'type',
                'choices' => array_flip(Comps::TYPE)
            ])
            ->add('caracPrimae', EntityType::class, [
                'class' => Caracs::class,
                'choice_label' => function ($caracs) {
                    return $caracs->getNom() . ' [' . $caracs->getAbreviation() . ']';
                },
                'label' => 'caracPrimae',
                'placeholder' => 'defaultCaracPrimae',
                'required' => false,
            ])
            ->add('caracSecundae', EntityType::class, [
                'class' => Caracs::class,
                'choice_label' => function ($caracs) {
                    return $caracs->getNom() . ' [' . $caracs->getAbreviation() . ']';
                },
                'label' => 'caracSecundae',
                'placeholder' => 'defaultCaracSecundae',
                'required' => false,
            ])
            ->add('caracTertiae', EntityType::class, [
                'class' => Caracs::class,
                'choice_label' => function ($caracs) {
                    return $caracs->getNom() . ' [' . $caracs->getAbreviation() . ']';
                },
                'label' => 'caracTertiae',
                'placeholder' => 'defaultCaracTertiae',
                'required' => false,
            ])
            ->add('caracQuartae', EntityType::class, [
                'class' => Caracs::class,
                'choice_label' => function ($caracs) {
                    return $caracs->getNom() . ' [' . $caracs->getAbreviation() . ']';
                },
                'label' => 'caracQuartae',
                'placeholder' => 'defaultCaracQuartae',
                'required' => false,
            ])
            ->add('valeur', NumberType::class, [
                'label' => 'valeurFixe',
                'required' => false,
            ])
            ->add('picture', FileType::class, [
                'label' => 'illustration',
                'required' => false,
            ])
            ->add('obsolete', CheckboxType::class, [
                'label' => 'obsolete',
                'required' => false,
            ])
            ->add('remplacerPar', EntityType::class, [
                'class' => Comps::class,
                'choice_label' => function ($comps) {
                    return $comps->getNom() . ' [' . $comps->getAbreviation() . ']';
                },
                'label' => 'compsRemplacerPar',
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
            'data_class' => Comps::class,
            'translation_domain' => 'forms',
        ]);
    }
}
