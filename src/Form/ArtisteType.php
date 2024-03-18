<?php

namespace App\Form;

use App\Entity\Artiste;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;

class ArtisteType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom', TextType::class, [
                "attr"=>["placeholder"=>"Saisir le nom de l'artiste"],
                "required"=>true
            ])
            ->add('description', TextareaType::class, [
                "attr"=>["style"=>"height: 100%;"],
                "required"=>false
            ])
            ->add('site', UrlType::class, [
                "attr"=>["placeholder"=>"Saisir l'url du site de l'artiste"],
                "required"=>false
            ])
            ->add('image', UrlType::class, [
                "attr"=>["placeholder"=>"Saisir l'url de l'image de l'artiste"],
                "required"=>true
            ])
            ->add('type', ChoiceType::class, [
                "choices"=>["solo"=>0, "groupe"=>1],
                "expanded"=>true,
                "multiple"=>false,
                "required"=>true
            ])
            ->add('nationalite')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Artiste::class,
        ]);
    }
}
