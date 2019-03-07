<?php
/**
 * Created by IntelliJ IDEA.
 * User: giaxmon
 * Date: 07.03.2019
 * Time: 15:21
 */

namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Booking;
use App\Entity\Flight;
use App\Entity\Customer;
use App\Form\BookingType;

/**
 * @Route("/booking")
 */
class BookingController extends AbstractController
{
    /**
     * @Route ("/create", name="Booking_create")
     */
    public function createBooking(Request $request){
        $booking = new Booking();
        $form = $this->createForm(BookingType::class, $booking);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            $booking = $form->getData();

            $em = $this->getDoctrine()->getManager();
            $em->persist($booking);
            $em->flush();


            return ($this->render('booking/bookingSuccess.html.twig'));
        }

        return $this->render('booking/bookingCreate.html.twig', [
            'form' => $form->createView(),
        ]);

    }


    /**
     * @Route ("/edit/{id}", name="Booking_edit")
     */
    public function editBooking(Request $request, $id){
        $booking = $this->getDoctrine()->getRepository(Booking::class)->findOneBy(['id'=>$id]);
        $form = $this->createForm(BookingType::class, $booking);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            $booking = $form->getData();

            $em = $this->getDoctrine()->getManager();
            $em->persist($booking);
            $em->flush();


            return $this->render('booking/bookingSuccess.html.twig');
        }

        return $this->render('booking/bookingEdit.html.twig', [
            'form' => $form->createView(),
        ]);

    }




    /**
     * @Route ("/list/{search}", defaults={"search"=0},  requirements={"search"="\w+"}, name="Booking_list")
     */
    public function listBookings($search){
        if($search==0) {
            $bookingList = $this->getDoctrine()
                ->getRepository(Booking::class)
                ->findAll();
        }else{
            $bookingList = $this->getDoctrine()
                ->getRepository(Booking::class)
                ->findBy(['customer.surName'=>$search, 'firstName'=>$search]);
        }
        if(!$bookingList){
            throw $this->createNotFoundException(
                "There are no bookings!"
            );
            return;
        }

        return $this->render("booking/bookingList.html.twig", [
            "bookingList" => $bookingList
        ]);
    }

    /**
     * @Route ("/view/{id}", name="Booking_view")
     */
    public function viewBooking($id){
        $booking= $this->getDoctrine()
            ->getRepository(Booking::class)
            ->findOneBy(["id" => $id]);
        if(!$booking){
            throw $this->createNotFoundException(
                "No Booking with this Id"
            );
        }
        return $this->render("booking/bookingView.html.twig", [
            "booking" => $booking
        ]);
    }

}