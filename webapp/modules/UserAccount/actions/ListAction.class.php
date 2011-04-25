<?php
/**
 * Listアクション
 *
 * @package jp.co.commons.cfms
 * @subpackage UserAccount
 * @author 小石達也 <tkoishi@b-shock.co.jp>
 */
class ListAction extends BSTableAction {
	public function getCriteria () {
		if (!$this->criteria) {
			$this->criteria = $this->createCriteriaSet();
			$this->criteria->register(
				'id',
				$this->getModule()->getProject()->getAccounts()->getIDs()
			);
		}
		return $this->criteria;
	}

	public function execute () {
		$this->request->setAttribute('accounts', $this->getRows());
		return BSView::SUCCESS;
	}

	public function handleError () {
		return $this->controller->getAction('not_found')->forward();
	}

	public function validate () {
		return parent::validate() && $this->getModule()->getProject();
	}
}

/* vim:set tabstop=4: */
