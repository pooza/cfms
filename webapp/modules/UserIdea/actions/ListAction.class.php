<?php
/**
 * Listアクション
 *
 * @package jp.co.commons.cfms
 * @subpackage UserIdea
 * @author 小石達也 <tkoishi@b-shock.co.jp>
 */
class ListAction extends BSPaginateTableAction {
	public function getCriteria () {
		if (!$this->criteria) {
			$this->criteria = $this->createCriteriaSet();
			$this->criteria->register('project_id', $this->getModule()->getProject());
			if ($tags = $this->request['tags']) {
				$table = new TagHandler;
				foreach ($tags as $tag) {
					if ($tag = $table->getRecord($tag)) {
						$this->criteria->register('id', $tag->getIdeas()->getIDs());
					}
				}
			}
			if ($key = $this->request['key']) {
				$this->criteria['key'] = $criteria = $this->createCriteriaSet();
				$criteria->setGlue('OR');
				foreach (array('name', 'name_en', 'name_read') as $field) {
					$criteria->register($field, '%' . $key . '%', 'LIKE');
				}
			}
		}
		return $this->criteria;
	}

	protected function getOrder () {
		if (!$this->order) {
			$this->order = new BSTableFieldSet;
			$this->order->push('update_date DESC');
		}
		return $this->order;
	}

	protected function getRows () {
		if (!$this->rows) {
			$this->rows = new BSArray;
			foreach ($this->getTable() as $idea) {
				$row = $idea->getAssignValue();
				$row['tags'] = new BSArray;
				foreach ($idea->getTags() as $tag) {
					$row['tags'][$tag->getID()] = $tag->getAssignValue();
				}
				$this->rows[$idea->getID()] = $row;
			}
		}
		return $this->rows;
	}

	public function execute () {
		$this->request->setAttribute('ideas', $this->getRows());
		$this->request->setAttribute('project', $project = $this->getModule()->getProject());
		$this->request->setAttribute('theme', $this->getModule()->getProject()->getTheme());
		return BSView::SUCCESS;
	}

	public function getCredential () {
		return $this->getModule()->getProject()->getCredential();
	}
}

/* vim:set tabstop=4: */
