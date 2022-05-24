<?php

namespace App\Form;

use App\Entity\Registration;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CountryType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RegistrationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom', TextType::class)
            ->add('prenom', TextType::class)
            ->add('date_de_naissance', BirthdayType::class, [
                'widget' => 'single_text'
            ])
            ->add('genre', ChoiceType::class, [
                'choices' => [
                    '' => '',
                    'Homme' => 'Homme',
                    'Femme' => 'Femme',
                ],
            ])
            ->add('pays', CountryType::class)
            ->add('ville', TextType::class)
            ->add('adresse', TextType::class)
            ->add('code_postal', TextType::class)
            ->add('email', EmailType::class)
            ->add('mot_de_passe', PasswordType::class)
            ->add('photo', FileType::class, [
                'required' => false,
                'disabled' => true,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Registration::class,
        ]);
    }
}
