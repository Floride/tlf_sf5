<?php

namespace App\Form\Admin\Character;

use App\Entity\Character\Medal;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class MedalType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'label.name',
                'required' => true,
            ])
            ->add('description', TextareaType::class, [
                'label' => 'label.description',
                'required' => true,
            ])
            ->add('type', ChoiceType::class, [
                'label' => 'label.type',
                'choices' => array_flip(Medal::TYPE),
                'required' => true,
            ])
            ->add('abbreviation', TextType::class, [
                'label' => 'label.abbreviation',
                'required' => true,
            ])
            ->add('category', ChoiceType::class, [
                'label' => 'label.category',
                'choices' => array_flip(Medal::CATEGORY),
                'required' => true,
            ])
            ->add('value', NumberType::class, [
                'label' => 'label.value',
                'required' => true,
            ])
            ->add('coeficientXp', NumberType::class, [
                'label' => 'label.coeficientXp',
                'required' => false,
            ])
            ->add('pictureFile', FileType::class, [
                'label' => 'label.illustration',
                'required' => false,
            ])
            ->add('ribbon', FileType::class, [
                'label' => 'label.ribbon',
                'required' => false,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Medal::class,
            'translation_domain' => 'forms',
        ]);
    }
}
