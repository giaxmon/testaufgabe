<?php
/**
 * Created by IntelliJ IDEA.
 * User: giaxmon
 * Date: 07.03.2019
 * Time: 14:15
 */

namespace App\Form;


use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class CustomerType extends AbstractType{

    public function buildForm(FormBuilderInterface $builder, array $options){
        $builder
            ->add("firstName", TextType::class)
            ->add("surName", TextType::class)
            ->add("dateOfBirth", BirthdayType::class,[
                'widget' => 'choice'
            ])
            ->add("send", SubmitType::class);

        return $builder;
    }

}