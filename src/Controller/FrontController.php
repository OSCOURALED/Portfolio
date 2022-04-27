<?php

namespace App\Controller;

use App\Repository\CategoryRepository;
use App\Repository\SkillsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FrontController extends AbstractController
{

    public function __construct(EntityManagerInterface $em, CategoryRepository $RepoCategory, SkillsRepository $RepoSkills)
    {
        $this->em = $em;
        $this->RepoCategory = $RepoCategory;
        $this->RepoSkills = $RepoSkills;

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
     * @Route("/epreuve", name="app.category.show")
     * @return Response
     */
    public function indexCategory(): Response
    {
        $categories = $this->RepoCategory->findAll();
        $Skills = $this->RepoSkills->findAll();

        return $this->render("Front/epreuve.html.twig", [
            'categories' => $categories,
            'skills' => $Skills
            
        ]);
    }

}
