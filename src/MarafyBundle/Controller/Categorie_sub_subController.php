<?php

namespace MarafyBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use MarafyBundle\Entity\Categorie_sub_sub;
use MarafyBundle\Form\Categorie_sub_subType;

/**
 * Categorie_sub_sub controller.
 *
 * @Route("/categorie_sub_sub")
 */
class Categorie_sub_subController extends Controller
{
    /**
     * Lists all Categorie_sub_sub entities.
     *
     * @Route("/", name="categorie_sub_sub_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $categorie_sub_subs = $em->getRepository('MarafyBundle:Categorie_sub_sub')->findAll();

        return $this->render('categorie_sub_sub/index.html.twig', array(
            'categorie_sub_subs' => $categorie_sub_subs,
        ));
    }

    /**
     * Creates a new Categorie_sub_sub entity.
     *
     * @Route("/new", name="categorie_sub_sub_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $categorie_sub_sub = new Categorie_sub_sub();
        $form = $this->createForm('MarafyBundle\Form\Categorie_sub_subType', $categorie_sub_sub);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($categorie_sub_sub);
            $em->flush();

            return $this->redirectToRoute('categorie_sub_sub_show', array('id' => $categorie_sub_sub->getId()));
        }

        return $this->render('categorie_sub_sub/new.html.twig', array(
            'categorie_sub_sub' => $categorie_sub_sub,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Categorie_sub_sub entity.
     *
     * @Route("/{id}", name="categorie_sub_sub_show")
     * @Method("GET")
     */
    public function showAction(Categorie_sub_sub $categorie_sub_sub)
    {
        $deleteForm = $this->createDeleteForm($categorie_sub_sub);

        return $this->render('categorie_sub_sub/show.html.twig', array(
            'categorie_sub_sub' => $categorie_sub_sub,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Categorie_sub_sub entity.
     *
     * @Route("/{id}/edit", name="categorie_sub_sub_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Categorie_sub_sub $categorie_sub_sub)
    {
        $deleteForm = $this->createDeleteForm($categorie_sub_sub);
        $editForm = $this->createForm('MarafyBundle\Form\Categorie_sub_subType', $categorie_sub_sub);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($categorie_sub_sub);
            $em->flush();

            return $this->redirectToRoute('categorie_sub_sub_edit', array('id' => $categorie_sub_sub->getId()));
        }

        return $this->render('categorie_sub_sub/edit.html.twig', array(
            'categorie_sub_sub' => $categorie_sub_sub,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Categorie_sub_sub entity.
     *
     * @Route("/{id}", name="categorie_sub_sub_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Categorie_sub_sub $categorie_sub_sub)
    {
        $form = $this->createDeleteForm($categorie_sub_sub);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($categorie_sub_sub);
            $em->flush();
        }

        return $this->redirectToRoute('categorie_sub_sub_index');
    }

    /**
     * Creates a form to delete a Categorie_sub_sub entity.
     *
     * @param Categorie_sub_sub $categorie_sub_sub The Categorie_sub_sub entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Categorie_sub_sub $categorie_sub_sub)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('categorie_sub_sub_delete', array('id' => $categorie_sub_sub->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
