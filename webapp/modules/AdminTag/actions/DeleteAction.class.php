<?php
/**
 * Deleteアクション
 *
 * @package jp.co.commons.cfms
 * @subpackage AdminTag
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
			return $this->getModule()->getAction('Detail')->forward();
		}

		$url = BSModule::getInstance('AdminProject')->getAction('Detail')->getURL();
		$url->setParameter('pane', 'TagList');
		return $url->redirect();
	}
}

/* vim:set tabstop=4: */
