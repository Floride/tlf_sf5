<?php

namespace App\Form;

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

class AdminUserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom', TextType::class, [
                'label' => 'nom',
                'required' => false,
            ])
            ->add('prenom', TextType::class, [
                'label' => 'prenom',
                'required' => false,
            ])
            ->add('email', EmailType::class, [
                'label' => 'email',
                'required' => true
            ])
            ->add('username', TextType::class, [
                'label' => 'username',
                'required' => false,
            ])
            ->add('sexe', ChoiceType::class, [
                'label' => 'sexe',
                'choices' => array_flip(User::SEXE)
            ])
            ->add('dateNaissance', DateType::class, [
                'label' => 'dtn',
                'widget' => 'single_text',
                'required' => false,
            ])
            ->add('biographie', TextareaType::class, [
                'label' => 'bio',
                'required' => false,
            ])
            ->add('pictureFile', FileType::class, [
                'label' => 'Photo',
                'required' => false,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
            'translation_domain' => 'forms'
        ]);
    }
}
