<?php
namespace App\Controller;


use App\Entity\Enseignant;
use App\Entity\Utilisateur;
use App\Form\EnseignantType;
use App\Repository\EnseignantRepository;
use App\Repository\IsetRepository;
use App\Repository\UtilisateurRepository;
use phpDocumentor\Reflection\Types\Boolean;
use PhpParser\Node\Scalar\String_;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class AdmController extends AbstractController
{


    /**
     * @Route("/adm",name="adm")
     * @param IsetRepository $repository
     * @return Response
     */
        public function index( IsetRepository $repository)
        {
$iset=$repository->findAll();
$totale=0;
$totalet=0;
            foreach ($iset as $i)
            {
               $totale+= sizeof( $i->getEnseignants());
                foreach ($i->getClasses() as $c)
                {

                    $totalet+= $c->getNbrEtudiant();
                }
            }
$result=null;
            $result2=null;
foreach ($iset as $i)
            {

                if($totale <>0)

                {  $result[]=['nom'=>$i->getNom(),
                    'nb'=>sizeof( $i->getEnseignants())*100/($totale*100)];}
                else
                {
                    $result[]=['nom'=>$i->getNom(),
                        'nb'=>0];
                }
                if($totalet <> 0)
                {
                    $t=0;
                    foreach ($i->getClasses() as $c)
                    {

                        $t+= $c->getNbrEtudiant();
                    }
                    $result2[]=['nom'=>$i->getNom(),
                        'nb'=> $t*100/($totalet*100)];
                }

        else
            {
                $result2[]=['nom'=>$i->getNom(),
                    'nb'=>0];
            }

            }




            return $this->render('adm.html.twig',['result'=>$result,'total'=>$totale,'totalet'=>$totalet,'result2'=>$result2,'iset'=>sizeof($iset)]);

}



}