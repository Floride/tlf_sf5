<?php
// src\Form\Admin\Character\CharacterType.php
namespace App\Form\Admin\Character;

use App\Entity\User;
use App\Entity\Character\Rank;
use App\Entity\Character\Role;
use App\Entity\Game\Geo\Place;
use App\Entity\Character\Character;
use App\Entity\Character\Profession;
use App\Entity\Character\Speciality;
use App\Entity\Character\Accreditation;
use Symfony\Component\Form\AbstractType;
use App\Repository\Character\RoleRepository;
use App\Repository\Game\Geo\PlaceRepository;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

/**
 * Class CharacterType
 *
 * PHP version 7.2.5
 *
 * @package    App\Form
 * @author     Sylvain FLORIDE <sfloride@gmail.com>
 * @version    1.0.0
 */
class CharacterType extends AbstractType
{
    /**
     * buildForm
     *
     * @param FormBuilderInterface $builder
     * @param array $options
     * 
     * @return void
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('biography', TextareaType::class, [
                'label' => 'label.description',
                'required' => true,
            ])
            ->add('birthDate', DateType::class, [
                'label' => 'label.birthDate',
                'widget' => 'single_text',
                'required' => false,
            ])
            ->add('email', EmailType::class, [
                'label' => 'label.email',
                'required' => false,
            ])
            ->add('firstname', TextType::class, [
                'label' => 'label.firstname',
                'required' => true,
            ])
            ->add('lastname', TextType::class, [
                'label' => 'label.lastname',
                'required' => true,
            ])
            ->add('nickname', TextType::class, [
                'label' => 'label.nickname',
                'required' => false,
            ])
            ->add('status', ChoiceType::class, [
                'label' => 'label.status',
                'choices' => array_flip(Character::STATUS),
                'required' => true,
            ])
            ->add('pictureFile', FileType::class, [
                'label' => 'label.avatar',
                'required' => false,
            ])
            ->add('sexe', ChoiceType::class, [
                'label' => 'label.sexe',
                'choices' => array_flip(Character::SEXE)
            ])
            ->add('accreditations', EntityType::class, [
                'attr' => [
                    'class' => 'select2'
                ],
                'class' => Accreditation::class,
                'choice_label' => function (Accreditation $accreditation) {
                    return $accreditation->getName() 
                        . ' [' . $accreditation->getAbbreviation() . ']'
                        . ' - niveau ' . $accreditation->getLevel()
                    ;
                },
                'expanded' => false,
                'label' => 'label.accreditations',
                'multiple' => true,
                'placeholder' => 'placeholder.accreditations',
                'required' => false,
            ])
            ->add('birthPlace', EntityType::class, [
                'class' => Place::class,
                'choice_label' => function (Place $place) {
                    return $this->getPlace($place);
                },
                'label' => 'label.place.birth',
                'placeholder' => 'placeholder.place.birth',
                'query_builder' => function (PlaceRepository $repository) {
                    return $repository->getBirthPlace();
                },
                'required' => false,
            ])
            ->add('profession', EntityType::class, [
                'class' => Profession::class,
                'choice_label' => function (Profession $profession) {
                    return $profession->getName();
                },
                'label' => 'label.profession',
                'placeholder' => 'placeholder.profession',
                'required' => false,
            ])
            ->add('rank', EntityType::class, [
                'class' => Rank::class,
                'choice_label' => function (Rank $rank) {
                    return $rank->getName() . ' [' . $rank->getAbbreviation() . ']';
                },
                'label' => 'label.rank',
                'placeholder' => 'placeholder.rank',
                'required' => false,
            ])
            ->add('recruitmentPlace', EntityType::class, [
                'class' => Place::class,
                'choice_label' => function (Place $place) {
                    return $this->getPlace($place);
                },
                'label' => 'label.place.recruitment',
                'placeholder' => 'placeholder.place.recruitment',
                'query_builder' => function (PlaceRepository $repository) {
                    return $repository->getRecruitmentPlace();
                },
                'required' => false,
            ])
            ->add('roles', EntityType::class, [
                'attr' => [
                    'class' => 'select2'
                ],
                'class' => Role::class,
                'choice_label' => function (Role $role) {
                    return $role->getName() . ' [' . $role->getAbbreviation() . ']';
                },
                'expanded' => false,
                'label' => 'label.roles',
                'multiple' => true,
                'placeholder' => 'placeholder.roles',
                'query_builder' => function (RoleRepository $repository) {
                    return $repository->getObsolete(false);
                },
                'required' => false,
            ])
            ->add('speciality', EntityType::class, [
                'class' => Speciality::class,
                'choice_label' => function (Speciality $speciality) {
                    return $speciality->getProfession()->getName() 
                        . ' ' . $speciality->getName();
                },
                'label' => 'label.speciality',
                'placeholder' => 'placeholder.speciality',
                'required' => false,
            ])
            ->add('user', EntityType::class, [
                'class' => User::class,
                'choice_label' => function (User $user) {
                    return $user->getUsername() . ' [' . $user->getEmail() . ']';
                },
                'label' => 'label.user',
                'placeholder' => 'placeholder.user',
                'required' => false,
            ])
        ;
    }

    /**
     * configureOptions
     *
     * @param OptionsResolver $resolver
     * 
     * @return void
     */
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Character::class,
            'translation_domain' => 'forms',
        ]);
    }

    /**
     * getPlace
     *
     * @param Place $place
     * 
     * @return string
     */
    private function getPlace(Place $place): string 
    {
        $result = $place->getType()->getName() . ' ' .$place->getName();
        if ($place->getLuminary()) {
            switch ($place->getLuminary()->getType()->getName()) {
                case 'Planète naine':
                case 'Planète tellurique':
                case 'Géante gazeuse':
                    $luminary = 'planète';
                break;
                case 'Satellite':
                    $luminary = 'Satellite';
                break;
                case 'Astéroïde':
                    $luminary = 'Astéroïde';
                break;
                default:
                    $luminary = 'XXX';
                break;
            }
            $result .= ' [ ' . $luminary . ' '. $place->getLuminary()->getName() . ']';
        } elseif ($place->getParent()) {
            $p = $place->getParent();
            $result .= ' [' . $p->getType()->getName() . ' ' . $p->getName();
            if ($p->getLuminary()) {
                $type = $p->getLuminary()->getType()->getName();
                switch ($type) {
                    case 'Planète naine':
                    case 'Planète tellurique':
                    case 'Géante gazeuse':
                        $luminary = $type;
                    break;
                    case 'Satellite':
                        $luminary = 'Satellite';
                    break;
                    case 'Astéroïde':
                        $luminary = 'Astéroïde';
                    break;
                    default:
                        $luminary = 'XXX';
                    break;
                }
                $result .= ' / ' . $luminary . ' '. $p->getLuminary()->getName();
            }
            $result .= ']';
        }

        return $result;
    }
}
