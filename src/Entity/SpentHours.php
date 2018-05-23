<?php

namespace App\Entity;

use Symfony\Component\Validator\Constraints as Assert;


class SpentHours {

	/**
	 * @Assert\NotBlank()
	 */
	protected $issueId;

	/**
	 * @Assert\NotBlank()
	 */
	protected $hours;

	protected $comments;

	/**
	 * @return mixed
	 */
	public function getIssueId() {
		return $this->issueId;
	}

	/**
	 * @param mixed $issueId
	 */
	public function setIssueId( $issueId ) {
		$this->issueId = $issueId;
	}

	/**
	 * @return mixed
	 */
	public function getHours() {
		return $this->hours;
	}

	/**
	 * @param mixed $hours
	 */
	public function setHours( $hours ) {
		$this->hours = $hours;
	}

	/**
	 * @return mixed
	 */
	public function getComments() {
		return $this->comments;
	}

	/**
	 * @param mixed $comments
	 */
	public function setComments( $comments ) {
		$this->comments = $comments;
	}
}