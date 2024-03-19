<?php

namespace App\Form;

use App\Entity\Nationalite;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Doctrine\ORM\QueryBuilder;

use App\Repository\NationaliteRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class ArtistRechercheType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom', TextType::class, [
                "attr"=>["placeholder"=>"Saisir le nom d'un artiste"],
                "required"=>false
            ])
            ->add('nationalite', EntityType::class, [
                "class" => Nationalite::class,
                // "choices" => fn(NationaliteRepository $nr) => $nr->choiceList(),
                "query_builder" => function (NationaliteRepository $er): QueryBuilder {
                    return $er->createQueryBuilder('n')
                        ->orderBy('n.libelle', 'ASC');
                },
                "choice_label" => "libelle",
                "multiple" => false,
                "required"=>false
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            "method"=>"get",
            "csrf_protection"=>false
        ]);
    }
}
