<?php
/**
 * Createアクション
 *
 * @package jp.co.commons.cfms
 * @subpackage AdminTag
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
			'project_id' => $this->getModule()->getProject()->getID(),
		);
	}

	public function execute () {
		try {
			$this->database->beginTransaction();
			$this->updateRecord();
			$this->database->commit();
		} catch (Exception $e) {
			$this->database->rollBack();
			$this->request->setError($this->getTable()->getName(), $e->getMessage());
			return $this->handleError();
		}
		return $this->getModule()->getAction('Detail')->redirect();
	}

	public function getDefaultView () {
		$this->request->setAttribute('project', $this->getModule()->getProject());
		return BSView::INPUT;
	}

	public function handleError () {
		return $this->getDefaultView();
	}
}

/* vim:set tabstop=4: */
