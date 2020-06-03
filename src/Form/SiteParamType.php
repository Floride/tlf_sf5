<?php
// src\Form\SiteParamType.php
namespace App\Form;

use App\Entity\SiteParams;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class SiteParamType
 *
 * PHP version 7.2
 *
 * @package    App\Form
 * @author     Sylvain FLORIDE <sfloride@gmail.com>
 * @version    1.0.0
 */
class SiteParamType extends AbstractType
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
                'label' => 'Clé',
                'required' => true,
            ])
            ->add('valeur', TextareaType::class, [
                'label' => 'Valeur',
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
            'data_class' => SiteParams::class,
            'translation_domain' => 'forms',
        ]);
    }
}
