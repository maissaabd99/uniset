<?php
namespace App\Controller;
use App\Entity\Librairie;
use App\Form\LibType;
use App\Repository\EnseignantRepository;
use App\Repository\IsetRepository;
use App\Repository\LibrairieRepository;
use Exception;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\GetSetMethodNormalizer;
use Symfony\Component\Serializer\Serializer;


class LibrairieController extends AbstractController
{
    /**
     * @Route("/librairie", name="lib")
     * @param Request $request
     * @param EnseignantRepository $repository
     * @param LibrairieRepository $rep
     * @return Response
     * @throws Exception
     */
    public function index(Request $request,EnseignantRepository $repository,LibrairieRepository $rep,IsetRepository $r)
    {
        $contenu= $rep->findAll();
        $user=$this->getUser();
        $x=$repository->findOneBy(['username'=>$user->getUsername()]);
        $librairie = new Librairie();
        $form = $this->createForm(LibType::class, $librairie);
        $form->handleRequest($request);
        $isets= $r->findAll();


        foreach ($isets as $key=>$value){
                $w=$value->getEnseignants();
                $x=0;
                foreach ($w as $cle=>$val){
                    $x =$x+count($val->getLibrairies()) ;
                }
                $tab[]=[
                    'nom'=>$value->getNom(),
                    'nbrsupport'=>$x
                ];
        }
        //$data[] = array_values($tab);
      // dd($tab);
        $encoders = array(new JsonEncoder());
        $normalizers = array(new GetSetMethodNormalizer());
        $serializer = new Serializer($normalizers, $encoders);
        $data = $serializer->serialize($tab, 'json');
        //dd($data);
        return $this->render('librairie.html.twig',['form'=>$form->createView(),'contenu'=>$contenu,'statlib'=>$tab]);
    }

    /**
     * @Route("/librairie/add", name="libens")
     * @param Request $request
     * @param EnseignantRepository $repository
     * @return Response
     * @throws Exception
     */
    public function addlib(Request $request,EnseignantRepository $repository)
    {
        $user = $this->getUser();
        $x = $repository->findOneBy(['username' => $user->getUsername()]);
        $librairie = new Librairie();
        $form = $this->createForm(LibType::class, $librairie);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $file = $form->get('support')->getData();;
           // $filename = md5(uniqid()).'.'.$file->guessExtension();
            $filename =$file->getClientOriginalName ();
            $file->move(
                $this->getParameter('file_directory'), $filename
            );
            $librairie->setSupport($filename);
            $librairie->setDateAjout(new \DateTime('now'));
            $librairie->setEnseignant($x);
            $em->persist($librairie);
            $em->flush();
            return $this->redirectToRoute('lib');
        }
       // dd($librairie);
        return $this->redirectToRoute('lib',['form'=>$form->createView()]);

    }

    /**
     * @Route("/librairie/{id}/delete", name="libdelete")
     * @param $id
     * @param Request $request
     * @param EnseignantRepository $repository
     * @param LibrairieRepository $rep
     * @return RedirectResponse
     */
    public function deletelib($id,Request $request,EnseignantRepository $repository,LibrairieRepository $rep)
    {
        $user = $this->getUser();
        $x = $repository->findOneBy(['username' => $user->getUsername()]);
        $lib= $rep->find($id);

        //$x->removeLibrairy($lib);
        $em=$this->getDoctrine()->getManager();
        $em->remove($lib);
        $em->flush();
       // dd($lib);
        return $this->redirectToRoute('lib');
    }

}