<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Doctrine\ORM\QueryBuilder;

use App\Entity\Style;
use App\Repository\StyleRepository;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class AlbumRechercheType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom', TextType::class, [
                'attr' => ['placeholder'=>"Saisissez le nom de l'album"],
                'required' => false
            ])
            ->add('style', EntityType::class, [
                'class' => Style::class,
                'query_builder' => function (StyleRepository $sr): QueryBuilder {
                    return $sr->createQueryBuilder('s')
                    ->orderBy('s.libelle', 'ASC');
                },
                'choice_label' => 'libelle',
                'multiple' => false,
                'required' => false
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
