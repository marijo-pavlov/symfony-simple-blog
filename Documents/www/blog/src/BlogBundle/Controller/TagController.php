<?php

namespace BlogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;

use BlogBundle\Entity\Tag;

class TagController extends Controller
{

	/**
	 * @Route("/tag/new", name="new_tag")
	 * @Method("POST")
	 * @Template()
	 */
	public function indexAction(Request $request)
	{
	    
	    $entity = new Tag();

	    $tagForm = $this->get('tag_form')->createCreateForm($entity);

        $tagForm->handleRequest($request);

        if($tagForm->isValid()){

        	$em = $this->getDoctrine()->getManager();
        	$em->persist($entity);
        	$em->flush();

        	return $this->redirect($this->getRequest()->headers->get('referer'));

        }

        $session = new Session();
        $session->getFlashBag()->add('FormErrors', 'We couldn\'t add your tag. Please try again later.');

	    return $this->redirect($this->getRequest()->headers->get('referer'));

	}

	/**
	* @Route("/tag/delete/{id}", name="delete_tag")
	* Template()
	*/

	public function deleteTagAction($id)
	{
		$entity = $this->getDoctrine()->getRepository('BlogBundle:Tag')->find($id);
		$postId = $entity->getPost()->getId();
 
		$em = $this->getDoctrine()->getManager();
		$em->remove($entity);
		$em->flush();

		return $this->redirectToRoute('show_post', array('id' => $postId));

	}

}