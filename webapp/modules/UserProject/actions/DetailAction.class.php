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
		$this->request->setAttribute('theme', $this->getRecord()->getTheme());
		return BSView::SUCCESS;
	}

	public function deny () {
		$this->user->setAttribute('requested_url', $this->request->getURL()->getContents());
		return parent::deny();
	}

	public function getCredential () {
		return $this->getRecord()->getCredential();
	}
}

/* vim:set tabstop=4: */
