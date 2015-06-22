<?php

namespace BlogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

use BlogBundle\Entity\Post;
use BlogBundle\Form\PostType;
use BlogBundle\Entity\Comment;
use BlogBundle\Entity\Tag;

class PostController extends Controller
{
	/**
	* @Route("/", name="homepage")
	* @Template("BlogBundle:Post:default.html.twig")
	*/
    public function indexAction()
    {
    	$posts = $this->getDoctrine()
    				->getManager()
    				->createQuery(
    					'SELECT p
    					FROM BlogBundle:Post p
    					ORDER BY p.published DESC'
    					)
    				->setMaxResults(5)
    				->getResult();

        $tags = $this->getDoctrine()->getManager()
                    ->createQuery(
                        'SELECT t FROM BlogBundle:Tag t
                        GROUP BY t.name'
                        )->getResult();

    	return array(
    		'posts' => $posts,
            'tags' => $tags
    		);
    }

    /**
    * @Route("/post/")
    */
    public function postRedirectAction(){
        return $this->redirectToRoute('homepage');
    }

    /**
     * @Route("/post/{id}", name="show_post", requirements={"id" = "\d+"})
     * @Template("BlogBundle:Post:show.html.twig")
     */
    public function showPostAction($id)
    {
        $post = $this->getDoctrine()->getRepository('BlogBundle:Post')->find($id);

        $entity = new Comment();

        $commentForm = $this->get('comment_form')->createCreateForm($entity, $id);

        $entity2 = new Tag();

        $tagForm = $this->get('tag_form')->createCreateForm($entity2, $id);

        return array(
        		'post' => $post,
        		'commentForm' => $commentForm->createView(),
                'comments' => $post->getComments(),
                'tagForm' => $tagForm->createView(),
                'tags' => $post->getTags()
        	);
    }

    /**
     * @Route("/post/new", name="new_post")
     * @Method("GET")
     * @Template("BlogBundle:Post:new.html.twig")
     */
    public function newPostAction()
    {
        $entity = new Post();
        $form = $this->createCreateForm($entity);

        return array(
        	'form' => $form->createView()
        	);

    }

    /**
     * @Route("/post/new")
     * @Method("POST")
     * @Template("BlogBundle:Post:new.html.twig")
     */
    public function createPostAction(Request $request)
    {	
    	$entity = new Post();
        $form = $this->createCreateForm($entity);

        $form->handleRequest($request);

        if($form->isValid()){
        	$entity->setPublished(new \DateTime());

        	$em = $this->getDoctrine()->getManager();
        	$em->persist($entity);
        	$em->flush();

        	return $this->redirectToRoute('show_post', array("id" => $entity->getId()));
        }

        return array(
        	'form' => $form->createView()
        	);
    }

    public function createCreateForm($entity){

    	$form = $this->createForm(new PostType(),$entity, array(
    		'action' => $this->generateUrl('new_post'),
    		'method' => 'POST'
    		));

    	$form->add('submit', 'submit', array(
    		'label' => 'Post something new'
    		));

    	return $form;
    }

    /**
     * @Route("/post/tag/{name}", name="post_by_tag")
     * @Method("GET")
     * @Template("BlogBundle:Post:show_by_tag.html.twig")
     */
    public function PostByTagAction($name)
    {
        $posts = $this->getDoctrine()->getManager()
                ->createQuery('SELECT p FROM BlogBundle:Post p JOIN BlogBundle:Tag t
                                WITH p.id = t.post WHERE t.name = :name ORDER BY p.published DESC')
                ->setParameter('name', $name)
                ->getResult();

        return array(
            'posts' => $posts
            );
    }
}