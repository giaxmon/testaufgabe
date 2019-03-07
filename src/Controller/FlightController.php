<?php
/**
 * Created by IntelliJ IDEA.
 * User: giaxmon
 * Date: 07.03.2019
 * Time: 14:35
 */

namespace App\Controller;

use App\Repository\FlightRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use App\Entity\Flight;
use App\Form\FlightType;


/**
 * @Route("/flight")
 */
class FlightController extends AbstractController
{
    /**
     * @Route ("/create", name="Flight_create")
     */
    public function createFlight(Request $request){
        $flight = new Flight();
        $form = $this->createForm(FlightType::class, $flight);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            $flight = $form->getData();

            $em = $this->getDoctrine()->getManager();
            $em->persist($flight);
            $em->flush();


            return $this->render('flight/flightSuccess.html.twig');
        }

        return $this->render('flight/flightCreate.html.twig', [
            'form' => $form->createView(),
        ]);

    }


    /**
     * @Route ("/edit/{id}", name="Flight_edit")
     */
    public function editFlight(Request $request, $id){
        $flight = $this->getDoctrine()->getRepository(Flight::class)->findOneBy(['id'=>$id]);
        $form = $this->createForm(FlightType::class, $flight);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            $flight = $form->getData();

            $em = $this->getDoctrine()->getManager();
            $em->persist($flight);
            $em->flush();


            return $this->render('flight/flightSuccess.html.twig');
        }

        return $this->render('flight/flightEdit.html.twig', [
            'form' => $form->createView(),
        ]);

    }




    /**
     * @Route ("/view/{id}", name="Flight_view")
     */
    public function viewFlight($id){
        $flight= $this->getDoctrine()
            ->getRepository(Flight::class)
            ->findOneBy(["id" => $id]);
        if(!$flight){
            throw $this->createNotFoundException(
                "No Flight with this Id"
            );
        }
        return $this->render("flight/flightView.html.twig", [
            "flight" => $flight
        ]);
    }

    /**
     * @Route ("/list/{search}", defaults={"search"=0},  requirements={"search"="\w+"}, name="Flight_list")
     */
    public function listFlights($search){
        if($search == 0){
            $flightList = $this->getDoctrine()
                ->getRepository(Flight::class)
                ->findAll();
        }else{
            $flightList = $this->getDoctrine()
                ->getRepository(Flight::class)
                ->findBy(['origin'=>$search, 'destination'=>$search]);
        }

        if(!$flightList){
            throw $this->createNotFoundException(
                "There are no flights!"
            );
            return;
        }

        return $this->render("flight/flightList.html.twig", [
            "flightList" => $flightList
        ]);
    }

}