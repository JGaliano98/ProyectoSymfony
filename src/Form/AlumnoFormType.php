<?php

namespace App\Form\Type;

use App\Entity\Alumno;
use App\Entity\Tutor; // Asegúrate de importar la entidad Tutor
use Symfony\Bridge\Doctrine\Form\Type\EntityType; // Importa EntityType
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AlumnoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nombre', TextType::class)
            ->add('apellido', TextType::class)
            ->add('fecha_nacimiento', DateType::class)
            ->add('foto', TextType::class)
            
            ->add('tutor', EntityType::class, [
                'class' => Tutor::class,
                'choice_label' => 'nombre', 

            ])
            ->add('save', SubmitType::class);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Alumno::class,
        ]);
    }
}
