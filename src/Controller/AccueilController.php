<?php

namespace App\Controller;

use App\Repository\EtablissementRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AccueilController extends AbstractController
{

    private EtablissementRepository $etablissementRepository;

    public function __construct(EtablissementRepository $etablissementRepository)
    {
        $this->etablissementRepository = $etablissementRepository;
    }

    #[Route('/', name: 'app_accueil')]
    public function index(): Response
    {
        $etablissements = $this->etablissementRepository->findBy(["actif" => true]);
        return $this->render('accueil/index.html.twig');
    }
}
