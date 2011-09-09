<?php
/**
 * Threadアクション
 *
 * @package jp.co.commons.cfms
 * @subpackage UserIdea
 * @author 小石達也 <tkoishi@b-shock.co.jp>
 */
class ThreadAction extends BSRecordAction {
	public function execute () {
		try {
			$this->database->beginTransaction();
			$this->getRecord()->reply(AccountHandler::getCurrent(), $this->request['body']);
			$this->database->commit();
		} catch (Exception $e) {
			$this->database->rollBack();
			$this->request->setError($this->getTable()->getName(), $e->getMessage());
			return $this->handleError();
		}
		return $this->getRecord()->getProject()->redirect();
	}

	public function getDefaultView () {
		$comments = new BSArray;
		foreach ($this->getRecord()->getComments() as $comment) {
			$comments[$comment->getID()] = $comment->getAssignableValues();
		}
		$this->request->setAttribute('comments', $comments);

		$this->request->setAttribute('project', $this->getModule()->getProject());
		$this->request->setAttribute('list_action', $this->getModule()->getListAction());
		$this->request->setAttribute('theme', $this->getModule()->getProject()->getTheme());
		return BSView::INPUT;
	}

	public function handleError () {
		return $this->getDefaultView();
	}

	public function deny () {
		$this->user->setAttribute('requested_url', $this->request->getURL()->getContents());
		return parent::deny();
	}

	public function getCredential () {
		if ($project = $this->getModule()->getProject()) {
			return $project->getCredential();
		}
	}
}

/* vim:set tabstop=4: */
