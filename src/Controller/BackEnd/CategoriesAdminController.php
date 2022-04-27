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

            return $this->redirectToRoute('admin.category.show');
        }

        return $this->render("Backend/CategoriesAdmin.html.twig", [
            'form' => $form->createView(),
        ]);
    }

    /**
     * Page de modification des catégories
     * 
     * @Route("/edit/{id}", name="admin.edit.categories")
     * @return Response
     */
    public function Editcategories($id, Request $request) : Response
    {
        $categories = $this->RepoCategory->find($id);
        $form = $this->createForm(categoriesFormType::class, $categories);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $this->em->flush();
            $this->addFlash('Success', 'La compétence a bien été modifié !');

            return $this->redirectToRoute('admin.category.show');
        }
        return $this->render("Backend/categoriesEdit.html.twig", [
            'form' => $form->createView(),
            'categories' => $categories
        ]);
    }


    /**
     * Page de suppression des catégories
     *
     * @Route("/delete/{id}", name="admin.delete.categories")
     * @param Request $request
     * @param integer $id
     * @return Response
     */
    public function Deletecategories(Request $request, Category $category,int $id): Response
    {
        if ($this->isCsrfTokenValid("delete" . $category->getId(), $request->get("_token")))
        {
            $this->em->remove($category);
            $this->em->flush();
            $this->addFlash("Success", "La compétence à été supprimée avec succès");
        };

        return $this->redirectToRoute("admin.category.show");
    }

}