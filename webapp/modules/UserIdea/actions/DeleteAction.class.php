<?php
/**
 * Deleteアクション
 *
 * @package jp.co.commons.cfms
 * @subpackage UserIdea
 * @author 小石達也 <tkoishi@b-shock.co.jp>
 */
class DeleteAction extends BSRecordAction {
	public function execute () {
		try {
			$this->database->beginTransaction();
			$this->getRecord()->trash();
			$this->database->commit();
		} catch (Exception $e) {
			$this->database->rollBack();
			$this->request->setError($this->getTable()->getName(), $e->getMessage());
			return $this->getModule()->getAction('Detail')->forward();
		}
		return $this->getModule()->getListAction()->redirect();
	}
}

/* vim:set tabstop=4: */
