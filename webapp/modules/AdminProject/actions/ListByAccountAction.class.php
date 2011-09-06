<?php
/**
 * ListByAccountアクション
 *
 * @package jp.co.commons.cfms
 * @subpackage AdminProject
 * @author 小石達也 <tkoishi@b-shock.co.jp>
 */
class ListByAccountAction extends BSPaginateTableAction {
	protected function getPageSize () {
		return 20;
	}

	public function getCriteria () {
		if (!$this->criteria) {
			$this->criteria = $this->createCriteriaSet();
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

	public function execute () {
		$this->request->setAttribute('projects', $this->getRows());
		$this->getModule()->setListAction($this);
		if ($account = BSModule::getInstance('AdminAccount')->getRecord()) {
			$this->request['projects'] = new BSArray;
			foreach ($account->getProjects()->getIDs() as $id) {
				$this->request['projects'][$id] = 1;
			}
		}
		return BSView::SUCCESS;
	}
}

/* vim:set tabstop=4: */
