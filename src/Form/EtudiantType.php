<?php

namespace App\Form;

use App\Entity\Etudiant;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EtudiantType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom', TextType::class, array(
                'label' => false,
                'attr' => array(
                    'placeholder' => 'Nom')
            ))

            ->add('prenom', TextType::class, array(
                'label' => false,
                'attr' => array(
                    'placeholder' => 'Prenom')
            ))
            ->add('classe', null, array(
                'label' => false,
                'group_by'=>'iset',

                    'placeholder' => 'CLASSE :',
                    'required' => true,


            ))
            ->add('cin', TextType::class, array(
                'label' => false,
                'attr' => array(
                    'placeholder' => 'CIN')
            ))
            ->add('imageFile',FileType::class, array(
                'label' => false,
                'required'=>true,
                'attr' => array(
                    'placeholder' => 'Image')
            ))

            ->add('date_naissance',null, ['label'=>'Date De Naissance : '])
            ->add('username', TextType::class, array(
                'label' => false,

                'attr' => array(
                    'placeholder' => 'Nom d\'utilisateur')
            ))
            ->add('password', RepeatedType::class, [
                'type' => PasswordType::class,
                'invalid_message' => 'Mot de Passe incorrect.',
                'options' => ['attr' => ['class' => 'password-field']],
                'required' => true,
                'first_options'  => ['label' => false, 'attr' => array(
                    'placeholder' => 'Mot de Passe')],
                'second_options' => ['label' => false, 'attr' => array(
                    'placeholder' => 'confirmation')
                ]])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Etudiant::class,
        ]);
    }
}
