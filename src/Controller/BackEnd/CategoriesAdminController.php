<?php

namespace App\Controller\Backend;

use App\Entity\Category;
use App\Form\CategoriesFormType;
use App\Repository\CategoryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/admin/categories")
 */
class CategoriesAdminController extends AbstractController
{
    public function __construct(EntityManagerInterface $em, CategoryRepository $RepoCategory)
    {
        $this->em = $em;
        $this->RepoCategory = $RepoCategory;
    }

    /**
     * Page admin des catégories
     *
     * @Route("/list", name="admin.category.show")
     * @return Response
     */
    public function indexCategory(): Response
    {
        $categories = $this->RepoCategory->findAll();

        return $this->render("Backend/Categories.html.twig", [
            'categories' => $categories
        ]);
    }

    /**
     * Page de création des catégories
     * 
     * @Route("/create")
     * @return Response
     * @param  Request $request
     */
    public function CreateCategories(Request $request): Response
    {
        $categorie = new Category();
        $form = $this->createForm(CategoriesFormType::class, $categorie);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $this->em->persist($categorie);
            $this->em->flush();
        }

        return $this->render("Backend/CategoriesAdmin.html.twig", [
            'form' => $form->createView(),
        ]);
    }

}