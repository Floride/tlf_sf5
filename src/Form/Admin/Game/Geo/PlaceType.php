<?php

namespace App\Form\Admin\Game\Geo;

use App\Entity\Game\Geo\Place;
use Symfony\Component\Form\AbstractType;
use App\Entity\Game\Geo\PlaceType as Type;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class PlaceType extends AbstractType
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
            ->add('type', EntityType::class, [
                'class' => Type::class,
                'choice_label' => function ($type) {
                    return $type->getName();
                },
                'label' => 'label.type',
                'placeholder' => 'placeholder.type',
                'required' => false,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Place::class,
            'translation_domain' => 'forms',
        ]);
    }
}
