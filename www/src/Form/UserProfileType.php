<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
//use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Validator\Constraints\File;


class UserProfileType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email',
                EmailType::class,
                [
                    'label' => 'электронная почта',
                    'empty_data' => 'test@test.com',
//                    'required' => false
                ])
//            ->add('roles')
//            ->add('password')
            ->add('name', TextType::class,
                [
                    'label' => 'Логин',
//                    'required' => false
                ])
            ->add('password', PasswordType::class,
                [
                    'label' => 'Пароль',
                    'required' => false,
                    'empty_data' => ''
                ])
            ->add('avatar', FileType::class,
                [
                    'label' => 'Аватарка',
                    'data_class' => null,
                    'required' => false,
                    'attr' => [
                        'accept' => 'image/jpeg'
                    ],
                    'constraints' => [
                        new File([
                            'maxSize' => '1024k',
                            'mimeTypes' => [
                                'image/jpeg',
                                'image/pjpeg',
                            ],
                            'mimeTypesMessage' => 'Пожалуйста выберите JPG файл',
                        ])
                    ],
                ])
//            ->add('isVerified')
            ->add('save', SubmitType::class);;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
