<?php
/**
 * Listアクション
 *
 * @package jp.co.commons.cfms
 * @subpackage UserProject
 * @author 小石達也 <tkoishi@b-shock.co.jp>
 */
class ListAction extends BSTableAction {
	public function getTable () {
		return AccountHandler::getCurrent()->getProjects();
	}

	public function execute () {
		$this->request->setAttribute('projects', $this->getRows());
		$this->request->setAttribute('account', AccountHandler::getCurrent());
		return BSView::SUCCESS;
	}
}

/* vim:set tabstop=4: */
