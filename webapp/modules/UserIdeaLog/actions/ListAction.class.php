<?php
/**
 * Listアクション
 *
 * @package jp.co.commons.cfms
 * @subpackage AdminTag
 * @author 小石達也 <tkoishi@b-shock.co.jp>
 */
class ListAction extends BSTableAction {

	/**
	 * 検索条件を返す
	 *
	 * @access protected
	 * @return string[] 検索条件
	 */
	protected function getCriteria () {
		if (!$this->criteria) {
			$this->criteria = $this->createCriteriaSet();
			$this->criteria->register('idea_id', $this->getModule()->getIdea());
		}
		return $this->criteria;
	}

	public function execute () {
		$this->request->setAttribute('logs', $this->getRows());
		return BSView::INPUT;
	}
}

/* vim:set tabstop=4: */
