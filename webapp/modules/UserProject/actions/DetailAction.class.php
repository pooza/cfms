<?php
/**
 * Detailアクション
 *
 * @package jp.co.commons.cfms
 * @subpackage UserProject
 * @author 小石達也 <tkoishi@b-shock.co.jp>
 * @version $Id$
 */
class DetailAction extends BSRecordAction {
	public function execute () {
		return BSView::SUCCESS;
	}

	/**
	 * 必要なクレデンシャルを返す
	 *
	 * @access public
	 * @return string 必要なクレデンシャル
	 */
	public function getCredential () {
		return $this->getRecord()->getCredential();
	}
}

/* vim:set tabstop=4: */
