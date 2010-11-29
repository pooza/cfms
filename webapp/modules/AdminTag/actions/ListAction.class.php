<?php
/**
 * Listアクション
 *
 * @package jp.co.commons.cfms
 * @subpackage AdminTag
 * @author 小石達也 <tkoishi@b-shock.co.jp>
 * @version $Id$
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
			$this->criteria->register('project_id', $this->getModule()->getProject());
		}
		return $this->criteria;
	}

	public function execute () {
		$this->request->setAttribute('tags', $this->getRows());
		return BSView::INPUT;
	}
}

/* vim:set tabstop=4: */
