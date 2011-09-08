<?php
/**
 * Wallアクション
 *
 * @package jp.co.commons.cfms
 * @subpackage UserProject
 * @author 小石達也 <tkoishi@b-shock.co.jp>
 */
class WallAction extends BSRecordAction {
	public function execute () {
		BSModule::getInstance('UserIdea')->setListAction($this);
		return BSModule::getInstance('UserIdea')->getAction('WallByProject')->forward();
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
