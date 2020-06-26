<?php

namespace App\Controller;

use App\Entity\Deposer;
use App\Form\DeposerFormType;
use App\Repository\ClasseRepository;
use App\Repository\DeposerRepository;
use App\Repository\EnsClasseRepository;
use App\Repository\EtudiantRepository;
use App\Repository\MatiereRepository;
use App\Repository\SupportRepository;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\File\MimeType\FileinfoMimeTypeGuesser;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use Symfony\Component\Routing\Annotation\Route;


class Etud_matieresController extends AbstractController
{
    private $locales;
    public function __construct(string $locales) {
        $this->locales = $locales;
    }

    /**
     * @Route("/etudiant/matieres", name="etudmatieres", methods={"GET"})
     * @param EtudiantRepository $etudiantRepository
     * @param ClasseRepository $rep
     * @param EnsClasseRepository $r
     * @return Response
     */
    public function index(EtudiantRepository $etudiantRepository,ClasseRepository $rep,EnsClasseRepository $r): Response
    {
        $et= $etudiantRepository->findOneBy(['username'=>$this->getUser()->getUsername()]);
        $classe=$et->getClasse();
        $c=$r->find($classe->getId());
        $en=$classe->getEnsClasses()->getValues();

        return $this->render('etud_matieres.html.twig',['etud'=>$et,'en'=>$en]);
    }

    /**
     * @Route("/about-UNISET", name="about")
     * @return Response
     */
    public function aboutuniset(): Response
    {
        return $this->render('about.html.twig');
    }

    /**
     * @Route("/etudiant/matieres/{id}", name="matiere")
     * @param $id
     * @param MatiereRepository $repository
     * @return Response
     */
    public function showmatiere($id,MatiereRepository $repository): Response
    {
        $matiere=$repository->find($id);
        $res=$matiere->getSupports();
       // dd($res);
        return $this->render('support_matiere.html.twig',['supports'=>$res,'matiere'=>$matiere]);
    }

    /**
     * @Route("/etudiant/matieres/{id}/deposer", name="deposesupport")
     * @param $id
     * @param SupportRepository $repository
     * @param Request $request
     * @param EtudiantRepository $rep
     * @param DeposerRepository $r
     * @return Response
     * @throws Exception
     */
    public function deposersupport($id,SupportRepository $repository,Request $request,EtudiantRepository $rep,DeposerRepository $r): Response
    {
        $supp=$repository->find($id);
        $deposer=new Deposer();
        $user=$this->getUser()->getUsername();
        $etud=$rep->findOneBy(['username'=>$user]);
        $form=$this->createForm(DeposerFormType::class,$deposer);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $em=$this->getDoctrine()->getManager();
            $file = $form->get('travail')->getData();;
           // $filename = md5(uniqid()).'.'.$file->guessExtension();
            $filename =$file->getClientOriginalName ();
            $file->move(
                $this->getParameter('deposer_directory'), $filename
            );
            $a=$r->findBy(['support'=>$supp,'etudiant'=>$etud]);
            if(count($a)>=1){
                foreach($a as $key=>$value){
                    $em->remove($value);
                }
            }
            $deposer->setTravail($filename);
            $deposer->setSupport($supp);
            $deposer->setDate(new \DateTime());
            $deposer->setEtudiant($etud);
            $deposer->setFilename($filename);
            $x=$deposer;
            $em->persist($deposer);
            $em->flush();
            $this->addFlash('success', 'Travail deposé !');
            return $this->redirectToRoute('matiere',['id'=>$supp->getMatiere()->getId()]);
        }
        $travail=$r->findBy(['support'=>$supp,'etudiant'=>$etud]);

        return $this->render('deposer.html.twig',['support'=>$supp,'form'=>$form->createView(),'travail'=>$travail]);
    }

    /**
     * @Route("/etudiant/matieres/deposer/{id}",name="download")
     * @param $id
     * @param DeposerRepository $repository
     * @return Response
     */
    public function downloadAction($id,DeposerRepository $repository)
    {
       // try {
            $file = $repository->find($id);
             $filename =$file->getTravail();
             $publicResourcesFolderPath = $this->getParameter('deposer_directory') . "/" . $filename;

        // This should return the file to the browser as response
        $response = new BinaryFileResponse($publicResourcesFolderPath);

        // To generate a file download, you need the mimetype of the file
        $mimeTypeGuesser = new FileinfoMimeTypeGuesser();

        // Set the mimetype with the guesser or manually
        if($mimeTypeGuesser->isSupported()){
            // Guess the mimetype of the file according to the extension of the file
            $response->headers->set('Content-Type', $mimeTypeGuesser->guess($publicResourcesFolderPath));
        }else{
            // Set the mimetype of the file manually, in this case for a text file is text/plain
            $response->headers->set('Content-Type', 'text/plain');
        }
        // Set content disposition inline of the file
        $response->setContentDisposition(
            ResponseHeaderBag::DISPOSITION_ATTACHMENT,
            $filename
        );
        return $response;
    }
            /* $response = new Response();
             $response->setContent($file->getTravail());

             $d = $response->headers->makeDisposition(
                 ResponseHeaderBag::DISPOSITION_ATTACHMENT, preg_replace('/[^a-zA-Z0-9-_. ]/', "", $file->getFilename())
             );

             $response->headers->set('Content-Disposition', $d);

             return $response;
         }*/
            /*if (!$file) {
                $array = array(
                    'status' => 0,
                    'message' => 'File does not exist'
                );
                $response = new JsonResponse ($array, 200);
                return $response;
            }

            $fileName = $file->getTravail();
            $file_with_path = $this->getParameter('deposer_directory') . "/" . $fileName;
            $response = new BinaryFileResponse ($file_with_path);
            $response->headers->set('Content-Type', 'text/plain');
            $response->setContentDisposition(ResponseHeaderBag::DISPOSITION_ATTACHMENT, $fileName);
            return $response;
        } catch (Exception $e) {
            $array = array(
                'status' => 0,
                'message' => 'Download error'
            );
            $response = new JsonResponse ($array, 400);
            return $response;
        }
    }

    /*
     * $em=$this->getDoctrine()->getManager();
        $entity = $em->getRepository('App:Deposer')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find File entity.');
        }



        $response = new \Symfony\Component\HttpFoundation\Response(stream_get_contents($entity->getTravail()), 200, array(
            'Content-Type' => $entity->getTypeFile(),
            'Content-Length' => $entity->getSizeFile(),
            'Content-Disposition' => 'attachment; filename="' . $entity->getNameFile() . '"',
        ));

        return $response;
     */

   /* /**
     * @Route("/student/ajax")
     * @param Request $request
     * @param EtudiantRepository $rep
     * @param SupportRepository $repository
     * @return JsonResponse|Response
     * @throws Exception
     */
  /*  public function ajaxAction(Request $request,EtudiantRepository $rep,SupportRepository $repository) {
        $students = $rep->findAll();

       // $supp=$repository->find($id);
        $deposer=new Deposer();
        $user=$this->getUser()->getUsername();
        $etud=$rep->findOneBy(['username'=>$user]);
        $form=$this->createForm(DeposerFormType::class,$deposer);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $file = $form->get('travail')->getData();;
            $filename = md5(uniqid()) . '.' . $file->guessExtension();
            $file->move(
                $this->getParameter('deposer_directory'), $filename
            );
            $deposer->setTravail($filename);
          //  $deposer->setSupport($supp);
            $deposer->setDate(new \DateTime('now'));
            $deposer->setEtudiant($etud);
            $em->persist($deposer);
            $em->flush();
            $this->addFlash('success', 'Travail deposé !');
           // return $this->redirectToRoute('matiere', ['id' => $supp->getMatiere()->getId()]);
        }
        if ($request->isXmlHttpRequest() || $request->query->get('showJson') == 1) {
            $jsonData = array();
            $idx = 0;
            foreach($students as $student) {
                $temp = array(
                    'name' => $student->getNom(),
                    'address' => $student->getClasse()->getNom(),
                );
                $jsonData[$idx++] = $temp;
            }
            return new JsonResponse($jsonData);
        } else {
            return $this->render('testajax.html.twig');
        }
    }*/

}