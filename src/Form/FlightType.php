<?php
/**
 * Created by IntelliJ IDEA.
 * User: giaxmon
 * Date: 07.03.2019
 * Time: 14:28
 */

namespace App\Form;

use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\AbstractType;

class FlightType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options){
        $builder->add("origin", TextType::class)
            ->add("destination", TextType::class)
            ->add("send", SubmitType::class);
        return $builder;
    }

}