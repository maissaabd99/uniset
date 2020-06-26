<?php

namespace App\Form;

use App\Entity\Etudiant;
use App\Entity\Librairie;
use DateTimeInterface;
use Doctrine\DBAL\Types\DateType;
use phpDocumentor\Reflection\Types\String_;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;


class LibType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('categorie',TextType::class,[ 'label' => false, 'attr' =>['placeholder' => 'Nom','style'=>'margin-left:10px;padding:12px;width:275px']])
            ->add('support',FileType::class,['label'=>false,'attr' =>['style'=>'margin-left:37px;border:1px solid grey;padding:12px;width:275px;margin-top:-25px','class'=>'custom-file-input']
                ,'mapped' => false,
                // make it optional so you don't have to re-upload the PDF file
                // every time you edit the Product details
                'required' => true,
                    'constraints' => [
                        new File([
                            'maxSize' => '1024k',
                            'mimeTypes' => [
                                'application/pdf',
                                'application/x-pdf',
                            ],
                            'mimeTypesMessage' => 'Please upload a valid PDF document',
                        ])
               ]]
        )
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Librairie::class,
        ]);
    }
}
