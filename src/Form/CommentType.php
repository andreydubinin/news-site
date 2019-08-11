<?php
/**
 * Created by PhpStorm.
 * User: Andrey Dubinin
 * Date: 11.08.2019
 * Time: 0:23
 */

namespace App\Form;

use App\Entity\Comment;
use App\Entity\News;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CommentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('text', TextareaType::class)
            //->add('news', HiddenType::class)
            ->add('news', EntityType::class, [
                'class' => News::class,
                'choice_label' => 'name', ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Comment::class,
        ]);
    }
}