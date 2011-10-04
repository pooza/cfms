<?php
/**
 * Tagsアクション
 *
 * @package jp.co.commons.cfms
 * @subpackage UserProject
 * @author 小石達也 <tkoishi@b-shock.co.jp>
 */
class TagsAction extends BSRecordAction {
	public function execute () {
		BSModule::getInstance('UserIdea')->setListAction($this);
		$this->request->setAttribute('project', $this->getRecord());
		$this->request->setAttribute('theme', $this->getRecord()->getTheme());
		$this->request->setAttribute(
			'ideasets',
			$this->getRecord()->getIdeasGrouped($this->request['key'])
		);
		return BSView::SUCCESS;
	}

	public function handleError () {
		if (!$this->getRecord()) {
			return $this->controller->getAction('not_found')->forward();
		}	
		return $this->execute();
	}

	public function deny () {
		$this->user->setAttribute('requested_url', $this->request->getURL()->getContents());
		return parent::deny();
	}

	public function getCredential () {
		if ($project = $this->getRecord()) {
			return $project->getCredential();
		}
	}
}

/* vim:set tabstop=4: */
