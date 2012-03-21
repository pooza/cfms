<?php
/**
 * Deleteアクション
 *
 * @package jp.co.commons.cfms
 * @subpackage UserDelivery
 * @author 小石達也 <tkoishi@b-shock.co.jp>
 */
class DeleteAction extends BSRecordAction {
	public function execute () {
		try {
			$this->database->beginTransaction();
			$this->getRecord()->delete();
			$this->database->commit();
		} catch (Exception $e) {
			$this->database->rollBack();
			$this->request->setError($this->getTable()->getName(), $e->getMessage());
			return $this->handleError();
		}
		return $this->getModule()->getAction('Create')->redirect();
	}

	public function handleError () {
		return $this->controller->getAction('not_found')->forward();
	}

	public function validate () {
		return (parent::validate()
			&& $this->getRecord()->isOwnedBy(AccountHandler::getCurrent())
		);
	}
}

/* vim:set tabstop=4: */
