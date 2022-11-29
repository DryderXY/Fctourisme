<?php

namespace App\Controller;

use App\Repository\CategorieRepository;
use App\Repository\EtablissementRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class EtablissementController extends AbstractController
{
    private EtablissementRepository $etablissementRepository;

    public function __construct(EtablissementRepository $etablissementRepository,CategorieRepository $categorieRepository)
    {
        $this->etablissementRepository = $etablissementRepository;
    }

    #[Route('/etablissements', name: 'app_etablissements')]
    public function index(): Response
    {
        $etablissements = $this->etablissementRepository->findBy(["actif" => true],["nom" => "ASC"]);
        return $this->render('etablissement/index.html.twig', [
            'etablissements' => $etablissements,
        ]);
    }
}
