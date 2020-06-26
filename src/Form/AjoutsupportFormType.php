<?php

namespace App\Form;

use App\Entity\Support;
use App\Repository\EnseignantRepository;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AjoutsupportFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom',TextType::class,['attr' =>['placeholder' => 'Libellé...','style'=>'margin-left:37px;border:1px solid grey;padding:12px;width:275px;margin-top:10px ']])
            ->add('contenu',FileType::class,['attr' =>['style'=>'margin-left:37px;border:1px solid grey;padding:12px;width:275px;margin-top:10px']])
            ->add('type',ChoiceType::class,['attr' =>['option' => 'Type de support','style'=>'margin-left:37px;border:1px solid grey;padding:12px;width:275px;margin-top:10px;'] ,
                'choices'  => [
                    'Cours' => 'Cours',
                    'TP' => 'TP',
                    'TD' => 'TD',
                ],
                'choice_attr' => function($key,$value,$index=0) {
                    $disabled = false;
                    $key=$disabled;

                    // set disabled to true based on the value, key or index of the choice...

                    return $disabled ? ['disabled' => 'disabled'] : [];
                },
            ])
        ->add('espaceDepot',ChoiceType::class,['attr' =>['option' => 'Type de support','style'=>'margin-left:37px;border:1px solid grey;padding:12px;width:275px;margin-top:10px;'] ,
        'choices'  => [
            'Créer un espace de dépôt' => 'oui',
            'Sans espace de dépôt' => 'non',
        ]]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Support::class,
        ]);
    }
}
