<?php
/**
 * WallByProjectアクション
 *
 * @package jp.co.commons.cfms
 * @subpackage UserIdea
 * @author 小石達也 <tkoishi@b-shock.co.jp>
 */
class WallByProjectAction extends BSTableAction {
	public function getCriteria () {
		if (!$this->criteria) {
			$this->criteria = $this->createCriteriaSet();
			$this->criteria->register('project_id', $this->getModule()->getProject());
			$this->criteria->register('parent_idea_id', null);
			if (!BSString::isBlank($key = $this->request['key'])) {
				$this->criteria['key'] = $criteria = $this->createCriteriaSet();
				$criteria->setGlue('or');
				foreach (array('name', 'body') as $field) {
					$criteria->register($field, '%' . $key . '%', 'like');
				}
			}
		}
		return $this->criteria;
	}

	protected function getOrder () {
		if (!$this->order) {
			$this->order = new BSTableFieldSet;
			$this->order->push('serial DESC');
		}
		return $this->order;
	}

	protected function getRows () {
		if (!$this->rows) {
			$this->rows = new BSArray;
			foreach ($this->getTable() as $idea) {
				$row = $idea->getAssignableValues();
				$row['comments'] = new BSArray;
				foreach ($idea->getComments() as $comment) {
					$row['comments'][$comment->getID()] = $comment->getAssignableValues();
				}
				$this->rows[$idea->getID()] = $row;
			}
		}
		return $this->rows;
	}

	public function execute () {
		$this->request->setAttribute('ideas', $this->getRows());
		$this->request->setAttribute('project', $this->getModule()->getProject());
		$this->request->setAttribute('theme', $this->getModule()->getProject()->getTheme());
		return BSView::SUCCESS;
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
