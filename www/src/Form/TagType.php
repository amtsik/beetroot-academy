<?php

namespace App\Form;

use App\Entity\Tag;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TagType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title')
            ->add('color', ChoiceType::class, [
                'choices'  => [
                    'синий' => 'badge-primary',
                    'серый' => 'badge-secondary',
                    'зеленый' => 'badge-success',
                    'красный' => 'badge-danger',
                    'желтый' => 'badge-warning',
                    'бирюзовый' => 'badge-info',
                    'светлый' => 'badge-light',
                    'темный' => 'badge-dark',
                ],
            ])
//            ->add('articles')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Tag::class,
        ]);
    }
}
