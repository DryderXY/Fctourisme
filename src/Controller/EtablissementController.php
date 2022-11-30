<?php

namespace App\Controller;

use App\Repository\EtablissementRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class EtablissementController extends AbstractController
{
    private EtablissementRepository $etablissementRepository;

    public function __construct(EtablissementRepository $etablissementRepository)
    {
        $this->etablissementRepository = $etablissementRepository;
    }

    #[Route('/etablissements', name: 'app_etablissements')]
    public function index(Request $request, PaginatorInterface $paginator): Response
    {
        $etablissements = $paginator->paginate(
            $this->etablissementRepository->findBy(["actif" => true],["nom" => "ASC"]), /* query NOT result */
            $request->query->getInt('page', 1), /*page number*/
            10 /*limit per page*/
        );
        return $this->render('etablissement/index.html.twig', [
            'etablissements' => $etablissements,
        ]);
    }


    #[Route('/etablissements/{id}', name: 'app_etablissement_id')]
    public function getArticle($id): Response
    {
        $etablissement = $this->etablissementRepository->findOneBy(["id"=>$id]);

            return $this->render('etablissement/etablissement.html.twig',[
                "etablissement" => $etablissement
            ]);
        }
}
