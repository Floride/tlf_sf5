<?php
// src\Form\Admin\UserType.php
namespace App\Form\Admin;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

/**
 * Class UserType
 *
 * PHP version 7.2.5
 *
 * @package    App\Form
 * @author     Sylvain FLORIDE <sfloride@gmail.com>
 * @version    1.0.0
 */
class UserType extends AbstractType
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
            ->add('lastname', TextType::class, [
                'label' => 'label.lastname',
                'required' => false,
            ])
            ->add('firstname', TextType::class, [
                'label' => 'label.firstname',
                'required' => false,
            ])
            ->add('email', EmailType::class, [
                'label' => 'label.email',
                'required' => true
            ])
            ->add('username', TextType::class, [
                'label' => 'label.username',
                'required' => false,
            ])
            ->add('sexe', ChoiceType::class, [
                'label' => 'label.sexe',
                'choices' => array_flip(User::SEXE)
            ])
            ->add('birthDate', DateType::class, [
                'label' => 'label.birthDate',
                'widget' => 'single_text',
                'required' => false,
            ])
            ->add('biography', TextareaType::class, [
                'label' => 'label.biography',
                'required' => false,
            ])
            ->add('picture', FileType::class, [
                'label' => 'label.photo',
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
            'data_class' => User::class,
            'translation_domain' => 'forms'
        ]);
    }
}
