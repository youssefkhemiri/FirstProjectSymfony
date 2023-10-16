<?php

namespace App\Form;

use App\Entity\Book;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class BookType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title')
            ->add('category', ChoiceType::class,[
                'choices' => [
                    'Humor' => 'Humor',
                    'Science' => 'Science',
                    'History' => 'History',
                ],
                ])
            ->add('oublicationDate')
            ->add('published')
            ->add('author', EntityType::class, [
                'class' => 'App\Entity\Author',
                'choice_label' => 'username',
                'placeholder' => 'Choose an author',    
                'required' => true,
            ]);
            
    }


    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Book::class,
        ]);
    }
}
