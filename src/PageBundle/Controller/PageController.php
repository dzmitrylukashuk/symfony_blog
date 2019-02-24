<?php

namespace PageBundle\Controller;


use PageBundle\Entity\Page;
use PageBundle\Forms\PageDeleteForm;
use PageBundle\Forms\PageForm;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class PageController extends Controller {

    public function listAction() {
        $pageRepo = $this->getDoctrine()->getRepository('PageBundle:Page');
        $pages = $pageRepo->findAll();
        return $this->render('@Page/Page/list.html.twig', [
            'pages' => $pages
        ]);
    }

    public function viewAction($id) {
        $pageRepo = $this->getDoctrine()->getRepository('PageBundle:Page');
        $page = $pageRepo->find($id);
        if (!$page) {
            throw $this->createNotFoundException('Page not found');
        }
        return $this->render('@Page/Page/view.html.twig', [
            'page' => $page
        ]);
    }

    public function addAction(Request $request) {
        $page = new Page();
        $form = $this->createForm(PageForm::class, $page);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($page);
            $em->flush();
            return $this->redirectToRoute('page_list');
        }

        return $this->render('@Page/Page/add.html.twig', [
            'form' => $form->createView()
        ]);
    }

    public function editAction($id, Request $request) {
        $em = $this->getDoctrine()->getManager();
        $repo = $em->getRepository('PageBundle:Page');
        $page = $repo->find($id);
        if(!$page) {
            return $this->redirectToRoute('page_list');
        }

        $form = $this->createForm(PageForm::class, $page);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            $em->persist($page);
            $em->flush();
            return $this->redirectToRoute('page_view', [ 'id' => $page->getId() ]);
        }

        return $this->render('@Page/Page/edit.html.twig', [
            'form' => $form->createView()
        ]);
    }

    public function removeAction($id, Request $request) {
        $em = $this->getDoctrine()->getManager();
        $repo = $em->getRepository('PageBundle:Page');
        $page = $repo->find($id);
        if(!$page) {
            return $this->redirectToRoute('page_list');
        }

        $form = $this->createForm(PageDeleteForm::class, $page);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            $em->remove($page);
            $em->flush();
            return $this->redirectToRoute('page_list', [ 'id' => $page->getId() ]);
        }

        return $this->render('@Page/Page/delete.html.twig', [
            'form' => $form->createView()
        ]);
    }
}