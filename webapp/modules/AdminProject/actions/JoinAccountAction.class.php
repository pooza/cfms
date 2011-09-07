<?php
/**
 * JoinAccountアクション
 *
 * @package jp.co.commons.cfms
 * @subpackage AdminProject
 * @author 小石達也 <tkoishi@b-shock.co.jp>
 */
class JoinAccountAction extends BSRecordAction {
	private $project;

	private function getAccount () {
		if (!$this->account) {
			$accounts = new AccountHandler;
			$this->account = $accounts->getRecord($this->request['account_id']);
		}
		return $this->account;
	}

	public function execute () {
		try {
			$this->database->beginTransaction();
			if ($account = $this->getAccount()) {
				$this->getRecord()->updateAccountStatus($account, $this->request['status']);
			}
			$this->database->commit();
		} catch (Exception $e) {
			$this->database->rollBack();
			$this->request->setError($this->getTable()->getName(), $e->getMessage());
			return BSView::ERROR;
		}
		return BSView::SUCCESS;
	}

	public function getViewClass () {
		return 'BSJSONView';
	}
}

/* vim:set tabstop=4: */
