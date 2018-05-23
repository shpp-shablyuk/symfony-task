<?php

namespace App\Controller;


use App\Entity\IssueComment;
use App\Entity\SpentHours;
use App\Form\IssueCommentType;
use App\Service\RedmineAPI;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;

class RedmineController extends Controller {

	/**
	 * @Route("/", name="projects")
	 */
	public function projects(RedmineAPI $redmineAPI)
	{
		return $this->render('projects.html.twig', array(
			'projects' => $redmineAPI->getProjects()
		));
	}

	/**
	 * @Route("/project/{project_id}", name="project_issues")
	 */
	public function project($project_id, RedmineAPI $redmineAPI)
	{
		return $this->render('project.html.twig', array(
			'issues' => $redmineAPI->getIssues($project_id),
		));
	}

	/**
	 * @Route("/issue/{id}", name="issue", requirements={"id"="\d+"})
	 */
	public function issue($id, Request $request, RedmineAPI $redmineAPI)
	{
		$issue = $redmineAPI->getIssue($id);
		if (count($issue) === 0) {
			return $this->render('issue.html.twig', array( 'issue' => $issue ));
		}

		$spentHours = new SpentHours();
		$spentHours->setIssueId($issue['id']);

		$formSpendHours = $this->createFormBuilder($spentHours)
			->add('issue_id', HiddenType::class)
			->add('hours', NumberType::class)
			->add('comments', TextType::class, array('label' => 'Comment', 'required' => false))
			->getForm();

		$formSpendHours->handleRequest($request);
		if ($formSpendHours->isSubmitted() && $formSpendHours->isValid()) {
			$data = $formSpendHours->getData();
			$result = $redmineAPI->addSpendHours($data);

			if ($result['success']) {
				$this->addFlash(
					'success',
					'SpendHours were saved!'
				);

				return $this->redirectToRoute('issue', array('id' => $id));
			}


			$this->addFlash(
				'success',
				$result['message']
			);
		}

		$comment = new IssueComment();
		$comment->setIssueId($id);

		$formComments = $this->createForm(IssueCommentType::class, $comment);
		$formComments->handleRequest($request);
		if ($formComments->isSubmitted() && $formComments->isValid()) {
			$comment = $formComments->getData();

			$entityManager = $this->getDoctrine()->getManager();
			$entityManager->persist($comment);
			$entityManager->flush();

			$this->addFlash(
				'success',
				'Comment were saved!'
			);

			return $this->redirectToRoute('issue', array('id' => $id));
		}

		$comments = $this->getDoctrine()
            ->getRepository(IssueComment::class)
            ->findByIssueId($id);

		return $this->render('issue.html.twig', array(
			'issue' => $issue,
			'form_spend_hours' => $formSpendHours->createView(),
			'form_comments' => $formComments->createView(),
			'comments' => $comments,
		));
	}
}
