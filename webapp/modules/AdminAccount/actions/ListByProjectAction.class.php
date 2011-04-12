<?php
/**
 * ListByProjectアクション
 *
 * @package jp.co.commons.cfms
 * @subpackage AdminAccount
 * @author 小石達也 <tkoishi@b-shock.co.jp>
 */
class ListByProjectAction extends BSPaginateTableAction {
	protected function getPageSize () {
		return 20;
	}

	public function getCriteria () {
		if (!$this->criteria) {
			$this->criteria = $this->createCriteriaSet();
			if ($key = $this->request['key']) {
				$this->criteria['key'] = $criteria = $this->createCriteriaSet();
				$criteria->setGlue('OR');
				foreach (array('name', 'name_en', 'name_read', 'email') as $field) {
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
		$this->request->setAttribute('accounts', $this->getRows());
		if ($project = BSModule::getInstance('AdminProject')->getRecord()) {
			$this->request['accounts'] = new BSArray;
			foreach ($project->getAccounts()->getIDs() as $id) {
				$this->request['accounts'][$id] = 1;
			}
		}
		return BSView::SUCCESS;
	}
}

/* vim:set tabstop=4: */
