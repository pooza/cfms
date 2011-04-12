<?php
/**
 * Createアクション
 *
 * @package jp.co.commons.cfms
 * @subpackage UserIdea
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
			'description' => $this->request['description'],
			'project_id' => $this->getModule()->getProject()->getID(),
		);
	}

	public function initialize () {
		parent::initialize();
		if (BSString::isBlank($this->request['name'])) {
			if ($info = $this->request['attachment']) {
				$this->request['name'] = mb_ereg_replace('\\.[^.]+$', '', $info['name']);
			}
		}
		return true;
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
		$this->request->setAttribute('theme', $this->getModule()->getProject()->getTheme());
		return BSView::INPUT;
	}

	public function handleError () {
		return $this->getDefaultView();
	}

	public function getCredential () {
		return $this->getModule()->getProject()->getCredential();
	}
}

/* vim:set tabstop=4: */
