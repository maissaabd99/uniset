<?php

namespace App\Controller;

use App\Entity\Support;
use App\Form\AjoutsupportFormType;
use App\Repository\EnseignantRepository;
use App\Repository\IsetRepository;
use App\Repository\MatiereRepository;
use App\Repository\SupportRepository;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class Ajout_supportController extends AbstractController
{
    /**
     * @Route("/enseignant/supports", name="ajout_support")
     * @param Request $request
     * @param EnseignantRepository $repository
     * @param MatiereRepository $rep
     * @return Response
     * @throws Exception
     */
    public function index(Request $request, EnseignantRepository $repository, MatiereRepository $rep): Response
    {
        $user = $this->getUser();
        $ens = $repository->findOneBy(['username' => $user->getUsername()]);

        $matieres = $ens->getEnsMatieres()->getValues();
        $mat = $ens->getEnsMatieres();
        $support = new Support();
        $form = $this->createForm(AjoutsupportFormType::class, $support);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $file = $form->get('contenu')->getData();;
          //  $filename = md5(uniqid()) . '.' . $file->guessExtension();
            $filename =$file->getClientOriginalName ();
            $file->move(
                $this->getParameter('support_directory'), $filename
            );
            $support->setContenu($filename);
            $support->setDateAjout(new \DateTime());
            $data = null;
            if (isset($_POST["matiere"])) {
                $data = $_POST['matiere'];
            }
            $mat = $rep->find($data);
            $support->setMatiere($mat);
            $em = $this->getDoctrine()->getManager();
            $em->persist($support);
            $em->flush();
            return $this->redirectToRoute('ajout_support');
        }
        // dd($matieres);
        return $this->render('ajout_support.html.twig', ['form' => $form->createView(), 'matieres' => $matieres]);
    }

    /**
     * @Route("/enseignant/support/delete/{id}", name="deletesupport")
     * @param $id
     * @param Request $request
     * @param SupportRepository $repository
     * @return Response
     */
    public function delsupport($id,Request $request, SupportRepository $repository): Response
    {
        $user = $this->getUser();
        $support=$repository->find($id);
        $em=$this->getDoctrine()->getManager();
        $em->remove($support);
        $em->flush();
        return $this->redirectToRoute('ajout_support');
    }
}