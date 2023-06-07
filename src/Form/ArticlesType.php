<?php

namespace App\Form;

use App\Entity\Articles;
use App\Entity\Category;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ArticlesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class)
            ->add('catchPhrase', TextType::class)
            ->add('date', DateType::class, [
                'data' => new \DateTime()
            ])
            ->add('author', TextType::class)
            ->add('description', TextType::class)
            ->add('posterFile', FileType::class, array(
                'required' => false,
                ))
            ->add('relatedSubjects', CollectionType::class, [
                'entry_type' => TextType::class,
                'allow_add' => true,
            ])
            ->add('chapo', TextType::class)
            ->add('legendMainPicture', TextType::class)
            ->add('authorWebsite', TextType::class)
            ->add('relatedCourse', NumberType::class)
            ->add('newCategory', TextType::class, array(
                'required'   => false,
                'mapped' => false, // newCategory n'est pas lié à une collonne en bdd
                'row_attr' => ['class' => 'show_category d-none']
            ))
            ->add('category', EntityType::class, [
                'placeholder' => '--',
                'class' => Category::class,
            ])
            ->add('Modifier', SubmitType::class, [
                'attr' => ['class' => 'save btn-primary']
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Articles::class,
        ]);
    }
}
