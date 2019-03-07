<?php
/**
 * Created by IntelliJ IDEA.
 * User: giaxmon
 * Date: 07.03.2019
 * Time: 14:31
 */

namespace App\Form;


use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use App\Entity\Flight;
use App\Entity\Customer;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class BookingType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add("flight", EntityType::class,[
                'class' => Flight::class
            ])
            ->add("customer", EntityType::class,[
                'class' => Customer::class
            ])

            ->add("send", SubmitType::class);
        return $builder;
    }
}