<?php
/**
 * Detailアクション
 *
 * @package jp.co.commons.cfms
 * @subpackage UserDelivery
 * @author 小石達也 <tkoishi@b-shock.co.jp>
 */
class DetailAction extends BSRecordAction {
	public function execute () {
		$this->request->setAttribute('theme', new Theme);
		return BSView::INPUT;
	}

	public function handleError () {
		return $this->controller->getAction('not_found')->forward();
	}

	public function validate () {
		return parent::validate() && !$this->getRecord()->isExpired();
	}
}

/* vim:set tabstop=4: */
