<?php

namespace CommentBundle\Controller;

use CommentBundle\Forms\CommentDeleteForm;
use CommentBundle\Forms\CommentForm;
use PageBundle\Entity\Page;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class CommentController extends Controller {

    public function editAction($id, Request $request) {
        $em = $this->getDoctrine()->getManager();
        $repo = $em->getRepository('CommentBundle:Comment');
        $comment = $repo->find($id);
        if(!$comment) {
            return $this->redirectToRoute('page_list');
        }

        $form = $this->createForm(CommentForm::class, $comment);
        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            /** @var Page $page */
            $page = $comment->getPage();
            $em->persist($comment);
            $em->flush();
            return $this->redirectToRoute('page_view', [ 'id' => $page->getId() ]);
        }

        return $this->render('@Comment/Page/edit.html.twig', [
            'form' => $form->createView()
        ]);
    }

    public function removeAction($id, Request $request) {
        $em = $this->getDoctrine()->getManager();
        $repo = $em->getRepository('CommentBundle:Comment');
        $comment = $repo->find($id);

        if(!$comment) {
            return $this->redirectToRoute('page_list');
        }

        $form = $this->createForm(CommentDeleteForm::class, $comment);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            /** @var Page $page */
            $page = $comment->getPage();
            $em->remove($comment);
            $em->flush();
            return $this->redirectToRoute('page_view', [
                'id' => $page->getId()
            ]);
        }

        return $this->render('@Comment/Page/delete.html.twig', [
            'form' => $form->createView()
        ]);
    }

}