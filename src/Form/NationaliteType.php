<?php

namespace App\Form;

use App\Entity\Nationalite;
use PharIo\Manifest\Url;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;

class NationaliteType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('libelle', TextType::class, [
                "attr"=>["placeholder"=>"Saisir le libelle"],
                "required"=>true
            ])
            ->add('drapeau', UrlType::class, [
                "attr"=>["placeholder"=>"Saisir l'url vers le drapeau"],
                "required"=>true
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Nationalite::class,
        ]);
    }
}
