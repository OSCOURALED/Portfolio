<?php

namespace App\Controller\Backend;

use App\Entity\Skills;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * @Route("/")
 */
class SkillsAdminController extends AbstractController
{
    public function __construct(EntityManagerInterface $em)
    {
        $this->$em = $em;
    }

    /**
     * Page de création des compétences
     * 
     * @Route("/")
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
