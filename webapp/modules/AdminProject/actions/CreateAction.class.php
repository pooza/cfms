<?php
/**
 * Createアクション
 *
 * @package jp.co.commons.cfms
 * @subpackage AdminProject
 * @author 小石達也 <tkoishi@b-shock.co.jp>
 */
class CreateAction extends BSRecordAction {

	/**
	 * レコードのフィールド値を配列で返す
	 *
	 * @access protected
	 * @return mixed[] フィールド値の連想配列
	 */
	protected function getRecordValues () {
		return array(
			'name' => $this->request['name'],
			'name_en' => $this->request['name_en'],
			'name_read' => $this->request['name_read'],
			'theme' => $this->request['theme'],
			'start_date' => $this->request['start_date'],
			'end_date' => $this->request['end_date'],
			'status' => $this->request['status'],
		);
	}

	public function execute () {
		try {
			$this->database->beginTransaction();
			$this->updateRecord();
			$this->getRecord()->createDefaultTag();
			$this->database->commit();
		} catch (Exception $e) {
			$this->database->rollBack();
			$this->request->setError($this->getTable()->getName(), $e->getMessage());
			return $this->handleError();
		}
		return $this->getModule()->getAction('Detail')->redirect();
	}

	public function getDefaultView () {
		if (!$this->request['_submitted']) {
			$this->request['theme'] = 'default';
			$this->request['status'] = 'show';
		}
		return BSView::INPUT;
	}

	public function handleError () {
		return $this->getDefaultView();
	}
}

/* vim:set tabstop=4: */
