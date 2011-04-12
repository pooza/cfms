<?php
/**
 * DeleteImageアクション
 *
 * @package jp.co.commons.cfms
 * @subpackage AdminAccount
 * @author 小石達也 <tkoishi@b-shock.co.jp>
 */
class DeleteImageAction extends BSRecordAction {
	public function execute () {
		if ($file = $this->getRecord()->getImageFile($this->request['name'])) {
			$file->delete();
			$this->getRecord()->clearImageCache($this->request['name']);
			$this->getRecord()->touch();
		}

		$url = $this->getModule()->getAction('Detail')->getURL();
		$url->setParameter('pane', 'DetailForm');
		return $url->redirect();
	}

	public function handleError () {
		return $this->controller->getAction('not_found')->forward();
	}
}

/* vim:set tabstop=4: */
