<?php
namespace App\Controller;
use App\Entity\Contact;
use App\Form\ContactType;
use App\Repository\ContactRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use Symfony\Component\HttpFoundation\Request;
class ContactController extends AbstractController
{


    /**
     * @Route("about-UNISET", name="about-UNISET")
     * @param Request $request
     * @param ContactRepository $r

     * @return Response
     */
    public function aboutuniset(ContactRepository $r,Request $request)
    {
        $cont = new Contact();

        $form = $this->createForm(ContactType::class, $cont);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($cont);
            $em->flush();
            $this->addFlash('success', 'Merci de nous avoir contacter !');
            return $this->redirectToRoute("etud");

        }
        return $this->render('about.html.twig', ['cont' => $cont, 'form' => $form->createView()]);
    }
    /**
     * @Route("messages", name="messages")
     * @param ContactRepository $repository
     * @return Response
     */
    public function index(ContactRepository $repository): Response
    {
        $x = $repository->findAll();
        return $this->render('message.html.twig',['x' => $x]) ;


    }

    /**
     * @route("/Supprimermessage/{id}",name="Supprimermessage")
     * @param Contact $p
     * @return Response


     */

    public function supprimer(Contact  $p)
    {        $em = $this->getDoctrine()->getManager();







     $em->remove($p);

        $em->flush();

        $this->addFlash('success', 'Message supprimé');



        return $this->redirect($_SERVER['HTTP_REFERER']);

    }


    /**
     * @Route("/detailcontact/{id}",name="detailcontact")
     * @param Contact $a
     * @return Response
     */
    public function modifier(Contact $a)
    {


        return $this->render('detailcontact.html.twig',['a' =>$a]) ;

    }


}