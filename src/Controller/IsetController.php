<?php

namespace App\Controller;

use App\Repository\ClasseRepository;
use App\Repository\EnseignantRepository;
use App\Repository\EtudiantRepository;
use App\Repository\IsetRepository;
use App\Repository\SupportRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class IsetController extends AbstractController
{
    /**
     * @Route("/ISETs", name="isets", methods={"GET"})
     * @param IsetRepository $repository
     * @param ClasseRepository $classeRepository
     * @param EtudiantRepository $etudiantRepository
     * @param EnseignantRepository $enseignantRepository
     * @param SupportRepository $supportRepository
     * @return Response
     */
    public function index(IsetRepository $repository,ClasseRepository $classeRepository,EtudiantRepository $etudiantRepository,EnseignantRepository $enseignantRepository,SupportRepository $supportRepository): Response
    {
        $enseignants=$enseignantRepository->findAll();
        $etudiants=$etudiantRepository->findAll();
        $classes=$classeRepository->findAll();
        $supports=$supportRepository->findAll();
        $isets=$repository->findAll();
        return $this->render('iset.html.twig',['isets'=>$isets,'classes'=>$classes,'enseignants'=>$enseignants,'etudiants'=>$etudiants,'supports'=>$supports]);
    }
}