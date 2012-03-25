<?php
/**
 * Thanxアクション
 *
 * @package jp.co.commons.cfms
 * @subpackage UserDelivery
 * @author 小石達也 <tkoishi@b-shock.co.jp>
 */
class ThanxAction extends BSRecordAction {
	public function execute () {
		try {
			$this->getRecord()->sendMail('thanx');
		} catch (Exception $e) {
			$this->database->rollBack();
			$this->request->setError($this->getTable()->getName(), $e->getMessage());
			return $this->handleError();
		}
		return $this->getRecord()->redirect();
	}

	public function getDefaultView () {
		return $this->handleError();
	}

	public function handleError () {
		return $this->controller->getAction('not_found')->forward();
	}

	public function validate () {
		return parent::validate() && !$this->getRecord()->isExpired();
	}
}

/* vim:set tabstop=4: */
