<?php

namespace App\Controller\Backend;

use App\Entity\Skills;
use App\Form\SkillsFormType;
use App\Repository\SkillsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Mapping\Id;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/admin/skills")
 */
class SkillsAdminController extends AbstractController
{
    public function __construct(EntityManagerInterface $em, SkillsRepository $RepoSkill)
    {
        $this->em = $em;
        $this->RepoSkill = $RepoSkill;
    }

    /**
     * Page admin des compétences
     *
     * @Route("/list", name="admin.skills.show")
     * @return Response
     */
    public function indexSkills(): Response
    {
        $skills = $this->RepoSkill->findAll();

        return $this->render("Backend/Skills.html.twig", [
            'skills' => $skills
        ]);
    }

    /**
     * Page de création des compétences
     * 
     * @Route("/create")
     * @return Response
     * @param  Request $request
     */
    public function CreateSkills(Request $request): Response
    {
        $skill = new Skills();
        $form = $this->createForm(SkillsFormType::class, $skill);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $this->em->persist($skill);
            $this->em->flush();
        }

        return $this->render("Backend/SkillsAdmin.html.twig", [
            'form' => $form->createView(),
        ]);
    }

    /**
     * Page de modification des compétences
     * 
     * @Route("/edit/{id}", name="edit_skills")
     * @return Response
     */
    public function editSkills($id, Request $request) : Response
    {
        $Skills = $this->repoSkill->find($id);
        $form = $this->createForm(SkillType::class, $Skills);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $this->em->flush();
            $this->addFlash('Success', 'La compétence a bien été modifié !');

            return $this->redirectToRoute('app_admin');
        }
        return $this->render("admin/Skill/EditSkill.html.twig", [
            'form' => $form->createView(),
            'Skills' => $Skills
        ]);
    }


    /**
     * Page de suppression des compétences
     *
     * @Route("/delete/{id}", name="delete_skills")
     * @param Request $request
     * @param integer $id
     * @return Response
     */
    public function DeleteSkills(Request $request, Skills $skill,int $id): Response
    {
        if ($this->isCsrfTokenValid("delete" . $skill->getId(), $request->get("_token")))
        {
            $this->em->remove($skill);
            $this->em->flush();
            $this->addFlash("Success", "La compétence à été supprimée avec succès");
        };

        return $this->redirectToRoute("admin.skills.show");
    }
}
