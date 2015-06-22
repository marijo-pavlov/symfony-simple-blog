<?php

namespace BlogBundle\Service;

use BlogBundle\Form\CommentType;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Bundle\FrameworkBundle\Routing\Router;
use Doctrine\ORM\EntityManager;
use BlogBundle\Form\DataTransformer\PostToNumberTransformer;

class CommentFormService{

	protected $formFactory;
	protected $router;
	protected $em;

	public function __construct(FormFactoryInterface $formFactory, Router $router, EntityManager $em){
		$this->formFactory = $formFactory;
		$this->router = $router;
		$this->em = $em;
	}

	public function createCreateForm($entity, $id = null){
		$form = $this->formFactory->create(new CommentType(), $entity, array(
			'action' => $this->router->generate('new_comment'),
			'method' => "POST",
			'em' => $this->em,
			'id' => $id
			));

		$form->add('submit', 'submit', array('label' => 'Post comment'));

		return $form;
	}
}