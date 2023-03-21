<?php

namespace App\Controller;

use App\Repository\EtablissementRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;

class EtablissementController extends AbstractController
{
    private EtablissementRepository $etablissementRepository;
    private UserRepository $userRepository;

    public function __construct(EtablissementRepository $etablissementRepository, UserRepository $userRepository)
    {
        $this->etablissementRepository = $etablissementRepository;
        $this->userRepository = $userRepository;
    }

    #[Route('/etablissements', name: 'app_etablissements')]
    public function index(Request $request, PaginatorInterface $paginator): Response
    {
        $etablissements = $paginator->paginate(
            $this->etablissementRepository->findBy(["actif" => true],["nom" => "ASC"]), /* query NOT result */
            $request->query->getInt('page', 1), /*page number*/
            12 /*limit per page*/
        );
        return $this->render('etablissement/index.html.twig', [
            'etablissements' => $etablissements,
        ]);
    }


    #[Route('/etablissements/{slug}', name: 'app_etablissement_slug')]
    public function getArticle($slug): Response
    {
        $etablissement = $this->etablissementRepository->findOneBy(["slug"=>$slug]);

            return $this->render('etablissement/etablissement.html.twig',[
                "etablissement" => $etablissement
            ]);
        }

    #[Route('/etablissement/favoris/{slug}', name: 'app_etablissement_favoris_slug',methods:['GET','POST'])]
    public function etablissementFavoris(EntityManagerInterface $manager,Security $security,$slug): Response
    {
        $etablissement = $this->etablissementRepository->findOneBy(["slug"=>$slug]);
        $user = $this->userRepository->find($security->getUser()->getId());
        if ($user->getFavoris()->contains($etablissement)){
            $user->removeFavori($etablissement);
        }else{
            $user->addFavori($etablissement);
        }


        $manager->persist($etablissement);
        $manager->flush();
        return $this->redirectToRoute("app_etablissement_slug",["slug"=>$slug]);

    }

    #[Route('/etablissement/favoris}', name: 'app_etablissement_favoris',priority: 1)]
    public function favoris(PaginatorInterface $paginator,Request $request,Security $security): Response
    {
        $idUser = $security->getUser();
        $favoris = $paginator->paginate(
            $this->userRepository->find($idUser)->getFavoris(),
            $request->query->getInt('page', 1), /*page number*/
            9 /*limit per page*/
        );

        return $this->render('etablissement/etablissementFav.html.twig',["favoris" => $favoris]);

    }

}
