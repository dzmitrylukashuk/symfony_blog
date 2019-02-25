<?php

namespace PageBundle\Controller;


use CommentBundle\Entity\Comment;
use CommentBundle\Forms\CommentForm;
use CommentBundle\Repository\CommentRepository;
use PageBundle\Entity\Page;
use PageBundle\Forms\PageDeleteForm;
use PageBundle\Forms\PageForm;
use PageBundle\Repository\PageRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class PageController extends Controller {

    public function listAction( Request $request ) {
        $pageRepo = $this->getDoctrine()->getRepository('PageBundle:Page');
        $pager = $request->query->get('page') ?? 1;
        $pages = $pageRepo->findPages($pager);
        $pager = [
            'pager' => $pager,
            'total' => $pageRepo->countPage(),
            'limit' => PageRepository::PAGES_LIMIT
        ];
        return $this->render('@Page/Page/list.html.twig', [
            'pages' => $pages,
            'navigator' => $pager
        ]);
    }

    public function viewAction($id, Request $request) {
        $pageRepo = $this->getDoctrine()->getRepository('PageBundle:Page');
        $page = $pageRepo->find($id);
        if (!$page) {
            throw $this->createNotFoundException('Page not found');
        }
        $em = $this->getDoctrine()->getManager();
        $commentForm = $this->createForm(CommentForm::class);
        $commentForm->handleRequest($request);

        if($commentForm->isSubmitted()) {
            /** @var Comment $comment */
            $comment = $commentForm->getData();
            $comment->setPage($page);
            $em->persist($comment);
            $em->flush();
            return $this->redirectToRoute('page_view', ['id' => $page->getId()]);
        }

        $commentRepo = $em->getRepository(Comment::class);
        $comments = $commentRepo->findLastComments($page);

        return $this->render('@Page/Page/view.html.twig', [
            'page' => $page,
            'comment_form' => $commentForm->createView(),
            'page_comments' => $comments
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

    public function commentsAction($id, Request $request) {
        $pageRepo = $this->getDoctrine()->getRepository('PageBundle:Page');
        $page = $pageRepo->find($id);
        if (!$page) {
            throw $this->createNotFoundException('Page not found');
        }
        $pager = $request->query->get('pager') ?? 1;
        $commentRepo = $this->getDoctrine()->getRepository('CommentBundle:Comment');
        $comments = $commentRepo->findBy(['page' => $page], ['id' => 'DESC'], CommentRepository::LIMIT_PER_PAGE, ($pager - 1) * CommentRepository::LIMIT_PER_PAGE);

        $pager = [
            'pager' => $pager,
            'total' => $commentRepo->countComments($page),
            'limit' => CommentRepository::LIMIT_PER_PAGE
        ];

        return $this->render('@Page/Page/page_comments.html.twig', [
            'page' => $page,
            'comments' => $comments,
            'navigator' => $pager
        ]);
    }
}