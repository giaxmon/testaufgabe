<?php
/**
 * Created by IntelliJ IDEA.
 * User: giaxmon
 * Date: 07.03.2019
 * Time: 17:39
 */

namespace App\Controller;


use App\Form\SearchType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController
{

    /**
     * @Route("/", name="home")
     */
    public function home(){
        return $this->render('home.html.twig');
    }


    /**
     * @Route("/search", name="Search")
     */
    public function search(Request $request){
        $form = $this->createForm(SearchType::class);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
           $type = $form["searchType"]->getData();
           $search = $form['searchString']->getData();

           if($type=="flight"){
                return $this->redirectToRoute("Flight_list", ['search' => $search]);
           }elseif($type=="customer"){
                return $this->redirectToRoute("Customer_list", ['search' => $search]);
           }elseif($type=="booking"){
                return $this->redirectToRoute("Booking_list", ['search' => $search]);
           }

        }

        return $this->render('search.html.twig', [
            'form' => $form->createView(),
        ]);

    }
}