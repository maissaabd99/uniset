<?php
namespace App\Controller;
use App\Entity\Etudiant;
use App\Entity\Utilisateur;
use App\Form\EtudiantType;
use App\Repository\EtudiantRepository;
use App\Repository\UtilisateurRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class EtdController extends AbstractController
{


    /**
     * @Route("/etd",name="etd")
     * @param Request $request
     * @param UtilisateurRepository $r
     * @param EtudiantRepository $et
     * @return Response
     */
    public function index(Request $request,UtilisateurRepository $r,EtudiantRepository $et)
    {

        $etd = new Etudiant();
        $uti=new Utilisateur();

        $form = $this->createForm(EtudiantType::class,  $etd);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $em = $this->getDoctrine()->getManager();


            $uti->setPassword($etd->getPassword());
            $uti->setUsername($etd->getUsername());
            $uti->setType('s');

            $uti->setUpdatedAt($etd->getUpdatedAt());
            $uti->setCin($etd->getCin());
            if($r->findByCin($uti->getCin())==true)
            {
                $this->addFlash('error', 'Numéro CIN déjà existe');

            }
            else{
                if($r->findByUsername($uti->getUsername())==true)
                {
                    $this->addFlash('error', 'Nom d\'utilisateur déjà existe');

                }
                else {

                    $em->persist($etd);
                    $em->flush();
                    $uti->setImg($et->find($etd->getId())->getImg());
                    $em->persist($uti);
                    $em->flush();
                    return $this->redirectToRoute("login");
                }
            }}

        return $this->render('etd.html.twig', ['etd' =>  $etd, 'form' => $form->createView()]);

    }

}