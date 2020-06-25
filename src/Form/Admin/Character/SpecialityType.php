<?php
// src\Form\Admin\Character\SpecialityType.php
namespace App\Form\Admin\Character;

use App\Entity\Character\Profession;
use App\Entity\Character\Speciality;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

/**
 * Class SpecialityType
 *
 * PHP version 7.2.5
 *
 * @package    App\Form
 * @author     Sylvain FLORIDE <sfloride@gmail.com>
 * @version    1.1.0
 */
class SpecialityType extends AbstractType
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
            ->add('description', TextareaType::class, [
                'label' => 'label.description',
                'required' => true,
            ])
            ->add('type', ChoiceType::class, [
                'label' => 'label.type',
                'choices' => array_flip(Speciality::TYPE)
            ])
            ->add('pictureFile', FileType::class, [
                'label' => 'label.badge',
                'required' => false,
            ])
            ->add('profession', EntityType::class, [
                'class' => Profession::class,
                'choice_label' => function ($profession) {
                    return $profession->getName();
                },
                'label' => 'label.profession',
                'placeholder' => 'placeholder.profession',
                'required' => false,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Speciality::class,
            'translation_domain' => 'forms',
        ]);
    }
}
