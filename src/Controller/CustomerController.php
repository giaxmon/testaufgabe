<?php
/**
 * Created by IntelliJ IDEA.
 * User: giaxmon
 * Date: 07.03.2019
 * Time: 14:52
 */

namespace App\Controller;

use Doctrine\DBAL\Types\DateType;
use Doctrine\DBAL\Types\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Entity\Customer;
use App\Form\CustomerType;


/**
 * @Route("/customer")
 */
class CustomerController extends AbstractController
{


    /**
     * @Route ("/create", name="Customer_create")
     */
    public function createCustomer(Request $request){
        $customer = new Customer();
        $form = $this->createForm(CustomerType::class, $customer);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            $customer = $form->getData();

            $em = $this->getDoctrine()->getManager();
            $em->persist($customer);
            $em->flush();


            return ($this->render('customer/customerSuccess.html.twig'));
        }

        return $this->render('customer/customerCreate.html.twig', [
            'form' => $form->createView(),
        ]);

    }


    /**
     * @Route ("/edit/{id}", name="Customer_edit")
     */
    public function editCustomer(Request $request, $id){
        $customer = $this->getDoctrine()->getRepository(Customer::class)->findOneBy(['id'=>$id]);
        $form = $this->createForm(CustomerType::class, $customer);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            $customer = $form->getData();

            $em = $this->getDoctrine()->getManager();
            $em->persist($customer);
            $em->flush();


            return ($this->render('customer/customerSuccess.html.twig'));
        }

        return $this->render('customer/customerEdit.html.twig', [
            'form' => $form->createView(),
        ]);

    }




    /**
     * @Route ("/list/{search}", defaults={"search"=0},  requirements={"search"="\w+"}, name="Customer_list")
     */
    public function listCustomers($search){
        if($search==0){
            $customerList = $this->getDoctrine()
                ->getRepository(Customer::class)
                ->findAll();
        }else{
            $customerList = $this->getDoctrine()
                ->getRepository(Customer::class)
                ->findBy(['surName'=>$search, 'firstName'=>$search]);
        }

        if(!$customerList){
            throw $this->createNotFoundException(
                "There are no customers!"
            );
            return;
        }

        return $this->render("customer/customerList.html.twig", [
            "customerList" => $customerList
        ]);
    }

    /**
     * @Route ("/view/{id}", name="Customer_view")
     */
    public function viewCustomer($id){
        $customer= $this->getDoctrine()
            ->getRepository(Customer::class)
            ->findOneBy(["id" => $id]);
        if(!$customer){
            throw $this->createNotFoundException(
                "No Customer with this Id"
            );
        }
        return $this->render("customer/customerView.html.twig", [
            "customer" => $customer
        ]);
    }

}