<?php

namespace CategoryBundle\Controller;

use CategoryBundle\Entity\Category;
use CategoryBundle\Forms\CategoryForm;
use CategoryBundle\Forms\CategoryDeleteForm;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class CategoryController extends Controller {

    public function listAction() {
        $categories = $this->getDoctrine()->getRepository('CategoryBundle:Category')->findAll();
        return $this->render('@Category/Page/list.html.twig', [
            'categories' => $categories
        ]);
    }

    public function addAction( Request $request) {
        $category = new Category();
        $form = $this->createForm(CategoryForm::class, $category);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($category);
            $em->flush();
            return $this->redirectToRoute('category_list');
        }

        return $this->render('@Category/Page/add.html.twig', [
            'form' => $form->createView()
        ]);

    }

    public function viewAction($id) {
        $categoryRepo = $this->getDoctrine()->getRepository('CategoryBundle:Category');
        $category = $categoryRepo->find($id);
        if (!$category) {
            throw $this->createNotFoundException('Category not found');
        }
        return $this->render('@Category/Page/view.html.twig', [
            'category' => $category
        ]);
    }

    public function editAction($id, Request $request) {
        $em = $this->getDoctrine()->getManager();
        $repo = $em->getRepository('CategoryBundle:Category');
        $category = $repo->find($id);
        if(!$category) {
            return $this->redirectToRoute('category_list');
        }

        $form = $this->createForm(CategoryForm::class, $category);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            $em->persist($category);
            $em->flush();
            return $this->redirectToRoute('category_view', [ 'id' => $category->getId() ]);
        }

        return $this->render('@Category/Page/edit.html.twig', [
            'form' => $form->createView()
        ]);
    }

    public function removeAction($id, Request $request) {
        $em = $this->getDoctrine()->getManager();
        $repo = $em->getRepository('CategoryBundle:Category');
        $category = $repo->find($id);
        if(!$category) {
            return $this->redirectToRoute('category_list');
        }

        $form = $this->createForm(CategoryDeleteForm::class, $category);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            $em->remove($category);
            $em->flush();
            return $this->redirectToRoute('category_list', [ 'id' => $category->getId() ]);
        }

        return $this->render('@Category/Page/delete.html.twig', [
            'form' => $form->createView()
        ]);
    }

}