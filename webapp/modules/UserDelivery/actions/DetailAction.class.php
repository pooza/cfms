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
		$record = $this->getRecord();
		$this->request->setAttribute('renderer', $record->getAttachment('attachment'));
		$this->request->setAttribute('filename', $record->getAttachmentFileName('attachment'));
		return BSView::SUCCESS;
	}

	public function initialize () {
		parent::initialize();
		if (!$this->getRecord() || ($this->request['t'] != $this->getRecord()->getToken())) {

			$this->getModule()->clearRecordID();
			$this->request['id'] = null;
		}
		return true;
	}

	public function getDefaultView () {
		if (!$this->getRecord()) {
			return $this->handleError();
		}
		$this->request->setAttribute('theme', new Theme);
		return BSView::INPUT;
	}

	public function handleError () {
		if (!$this->getRecord() || $this->request->hasError('expire_date')) {
			return $this->controller->getAction('not_found')->forward();
		}
		return $this->getDefaultView();
	}

	public function validate () {
		if (!$record = $this->getRecord()) {
			return false;
		} else if ($record->isExpired()) {
			$this->request->setError('expire_date', '期限を過ぎています。');
		}
		if (BSCrypt::digest($this->request['password']) != $record['password']) {
			$this->request->setError('password', '正しくありません。');
		}
		return !$this->request->getErrors()->count();
	}
}

/* vim:set tabstop=4: */
