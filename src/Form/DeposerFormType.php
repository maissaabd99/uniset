<?php

namespace App\Form;

use App\Entity\Deposer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DeposerFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            //->add('date')
            ->add('travail',FileType::class,[ 'label' => false, 'attr' =>['style'=>'margin-left:150px;padding:18px;width:300px;border:2px solid grey']])
           // ->add('etudiant')
           // ->add('support')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Deposer::class,
        ]);
    }


}
