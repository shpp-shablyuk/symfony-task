<?php

namespace App\Service;

use Redmine;

class RedmineAPI {
	private $url = 'https://redmine.ekreative.com';
	private $key = '2fda745bb4cdd835fdf41ec1fab82a13ddc1a54c';
	private $client;

	public function __construct() {
		$this->client = new Redmine\Client($this->url, $this->key);
	}

	public function getProjects(  ) {
		$projects = $this->client->project->all();
		if (empty($projects['projects'])) {
			return array();
		}

		return $projects['projects'];
	}

	public function getIssues( $project_id ) {
		$issues = $this->client->issue->all(array('project_id' => $project_id));
		if (empty($issues['issues'])) {
			return array();
		}

		return $issues['issues'];
	}

	public function getIssue( $issue_id ) {
		$issue = $this->client->issue->show($issue_id);
		if (empty($issue['issue'])) {
			return array();
		}

		return $issue['issue'];
	}

	public function addSpendHours( $data ) {
		$issue = $this->client->time_entry->create(
			array(
				'issue_id' => $data->getIssueId(),
				'hours' => $data->getHours(),
				'comments' => $data->getComments(),
			)
		);

		if (isset($issue['error'])) {
			return array(
				'success' => false,
				'message' => $issue['error']
			);
		}

		return array(
			'success' => true
		);
	}
}
