<?php

namespace MarafyBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use MarafyBundle\Entity\Part;
use MarafyBundle\Form\PartType;

/**
 * Part controller.
 *
 * @Route("/part")
 */
class PartController extends Controller
{
    /**
     * Lists all Part entities.
     *
     * @Route("/", name="part_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $parts = $em->getRepository('MarafyBundle:Part')->findAll();

        return $this->render('part/index.html.twig', array(
            'parts' => $parts,
        ));
    }

    /**
     * Creates a new Part entity.
     *
     * @Route("/new", name="part_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $part = new Part();
        $form = $this->createForm('MarafyBundle\Form\PartType', $part);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($part);
            $em->flush();

            return $this->redirectToRoute('part_show', array('id' => $part->getId()));
        }

        return $this->render('part/new.html.twig', array(
            'part' => $part,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Part entity.
     *
     * @Route("/{id}", name="part_show")
     * @Method("GET")
     */
    public function showAction(Part $part)
    {
        $deleteForm = $this->createDeleteForm($part);

        return $this->render('part/show.html.twig', array(
            'part' => $part,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Part entity.
     *
     * @Route("/{id}/edit", name="part_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Part $part)
    {
        $deleteForm = $this->createDeleteForm($part);
        $editForm = $this->createForm('MarafyBundle\Form\PartType', $part);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($part);
            $em->flush();

            return $this->redirectToRoute('part_edit', array('id' => $part->getId()));
        }

        return $this->render('part/edit.html.twig', array(
            'part' => $part,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Part entity.
     *
     * @Route("/{id}", name="part_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Part $part)
    {
        $form = $this->createDeleteForm($part);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($part);
            $em->flush();
        }

        return $this->redirectToRoute('part_index');
    }

    /**
     * Creates a form to delete a Part entity.
     *
     * @param Part $part The Part entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Part $part)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('part_delete', array('id' => $part->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
