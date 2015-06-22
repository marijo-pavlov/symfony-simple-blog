<?php 

namespace BlogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;

use BlogBundle\Entity\Comment;


class CommentController extends Controller
{
	/**
	 * @Route("/comment/new", name="new_comment")
	 * @Method("POST")
	 * @Template()
	 */
	public function indexAction(Request $request)
	{

	$entity = new Comment();

        $commentForm = $this->get('comment_form')->createCreateForm($entity);

        $commentForm->handleRequest($request);

        if($commentForm->isValid()){

        	$entity->setPublished(new \DateTime());

        	$em = $this->getDoctrine()->getManager();
        	$em->persist($entity);
        	$em->flush();

        	return $this->redirect($this->getRequest()->headers->get('referer'));

        }

        $session = new Session();
        $session->getFlashBag()->add('FormErrors', 'We couldn\'t post your comment. Please try again later.');

	    return $this->redirect($this->getRequest()->headers->get('referer'));
	}

}