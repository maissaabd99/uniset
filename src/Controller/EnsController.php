<?php
namespace App\Controller;


use App\Entity\Enseignant;
use App\Entity\Utilisateur;
use App\Form\EnseignantType;
use App\Repository\EnseignantRepository;
use App\Repository\UtilisateurRepository;
use phpDocumentor\Reflection\Types\Boolean;
use PhpParser\Node\Scalar\String_;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class EnsController extends AbstractController
{


    /**
     * @Route("/ens",name="ens")
     * @param Request $request
     * @param UtilisateurRepository $r
     * @param EnseignantRepository $e
     * @return Response
     */
        public function index(Request $request ,UtilisateurRepository $r,EnseignantRepository $e)
    {

        $ens = new Enseignant();

        $uti=new Utilisateur();

        $form = $this->createForm(EnseignantType::class,  $ens);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $em = $this->getDoctrine()->getManager();


        $uti->setUsername($ens->getUsername());
        $uti->setPassword($ens->getPassword());
            $uti->setType('e');
            $uti->setUpdatedAt($ens->getUpdatedAt());
            $uti->setCin($ens->getCin());
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
    $em->persist($ens);
    $em->flush();
    $uti->setImg($e->find($ens->getId())->getImg());
    $em->persist($uti);
    $em->flush();

    return $this->redirectToRoute("login");
}
        }}
        return $this->render('ens.html.twig', ['ens' =>  $ens, 'form' => $form->createView()]);

    }



}