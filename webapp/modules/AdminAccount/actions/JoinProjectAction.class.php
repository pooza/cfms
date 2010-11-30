<?php
/**
 * JoinProjectアクション
 *
 * @package jp.co.commons.cfms
 * @subpackage AdminAccount
 * @author 小石達也 <tkoishi@b-shock.co.jp>
 * @version $Id$
 */
class JoinProjectAction extends BSRecordAction {
	private $project;

	private function getProject () {
		if (!$this->project) {
			$projects = new ProjectHandler;
			$this->project = $projects->getRecord($this->request['project_id']);
		}
		return $this->project;
	}

	public function execute () {
		try {
			$this->database->beginTransaction();
			if ($project = $this->getProject()) {
				$this->getRecord()->updateProjectStatus($project, $this->request['status']);
			}
			$this->database->commit();
		} catch (Exception $e) {
			$this->database->rollBack();
			$this->request->setError($this->getTable()->getName(), $e->getMessage());
			return BSView::ERROR;
		}
		return BSView::SUCCESS;
	}
}

/* vim:set tabstop=4: */
