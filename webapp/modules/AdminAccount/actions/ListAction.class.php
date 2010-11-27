<?php
/**
 * Listアクション
 *
 * @package jp.co.commons.cfms
 * @subpackage AdminAccount
 * @author 小石達也 <tkoishi@b-shock.co.jp>
 * @version $Id$
 */
class ListAction extends BSTableAction {
	public function execute () {
		$this->request->setAttribute('accounts', $this->getRows());
		return BSView::SUCCESS;
	}
}

/* vim:set tabstop=4: */
