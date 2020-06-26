<?php

namespace App\Form;

use App\Entity\Contact;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
class ContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom', TextType::class,['attr'=>['placeholder '=>'Your lastname' ,'id'=>'lname'] ,'required'=>true])
            ->add('prenom',TextType::class,['attr'=>['placeholder '=>'Your firstname' , 'id'=>'fname'] ,'required'=>true])
            ->add('email',TextType::class,['attr'=>['placeholder '=>'Your email address' , 'id'=>'email'] ,'required'=>true])
            ->add('sujet',TextType::class,['attr'=>['placeholder '=>'Your subject of this message' ,'id'=>'subject'] ,'required'=>true])
            ->add('contenu',TextareaType::class,['attr'=>['placeholder '=>'Say something about us' ,'id'=>'message','style'=>'height:200px;'] ,'required'=>true])

        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Contact::class,
        ]);
    }
}
