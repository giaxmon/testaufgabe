<?php
/**
 * Created by IntelliJ IDEA.
 * User: giaxmon
 * Date: 07.03.2019
 * Time: 14:31
 */

namespace App\Form;


use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class SearchType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('searchString', TextType::class)
            ->add('searchType', ChoiceType::class,[
                'choices'=> [
                    'Flight' => 'flight',
                    'Customer' => 'customer',
                    'Booking' => 'booking'
                ]
            ])
            ->add('search', SubmitType::class);
        return $builder;
    }
}