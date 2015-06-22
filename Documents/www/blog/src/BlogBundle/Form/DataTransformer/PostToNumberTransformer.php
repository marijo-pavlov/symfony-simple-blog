<?php

namespace BlogBundle\Form\DataTransformer;


use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;
use Doctrine\Common\Persistence\ObjectManager;
use Acme\TaskBundle\Entity\Post;

class PostToNumberTransformer implements DataTransformerInterface{

	protected $om;

	public function __construct(ObjectManager $om){
		$this->om = $om;
	}

	public function transform($post){
		if(null === $post){
			return '';
		}

		return $post;
	}

	public function reverseTransform($id){

		if(!$id){
			return null;
		}

		$post = $this->om->getRepository('BlogBundle:Post')
						->find($id)
		;

		if(null === $post){
			throw new TransformationFailedException(sprintf(
				'A post with number %s does not exist!', 
				$id
			));
		}

		return $post;
	}
}