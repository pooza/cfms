<?php
/**
 * Sendアクション
 *
 * @package jp.co.commons.cfms
 * @subpackage UserIdea
 * @author 小石達也 <tkoishi@b-shock.co.jp>
 * @version $Id$
 */
class SendAction extends BSRecordAction {
	public function execute () {
		try {
			$this->getRecord()->sendMails();
		} catch (Exception $e) {
			$this->database->rollBack();
			$this->request->setError($this->getTable()->getName(), $e->getMessage());
			return BSView::ERROR;
		}
		return BSView::SUCCESS;
	}
}

/* vim:set tabstop=4: */
