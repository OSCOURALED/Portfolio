<?php

namespace App\Controller;

use App\Repository\SkillsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FrontController extends AbstractController
{

    public function __construct(EntityManagerInterface $em, SkillsRepository $RepoCategory)
    {
        $this->em = $em;
        $this->RepoCategory = $RepoCategory;
    }

    #[Route('/', name: 'app_front')]
    public function index(): Response
    {
        return $this->render('front/index.html.twig', [
            'controller_name' => 'FrontController',
        ]);
    }

    #[Route('/parcours', name: 'parcours')]
    public function parcours(): Response
    {
        return $this->render('front/parcours.html.twig', [
            'controller_name' => 'FrontController',
        ]);
    }

    /**
     * Tableau E4
     *
     * @Route("/epreuve", name="admin.category.show")
     * @return Response
     */
    public function indexCategory(): Response
    {
        $categories = $this->RepoCategory->findAll();

        return $this->render("Backend/Categories.html.twig", [
            'categories' => $categories
        ]);
    }

}
