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
	 * メモリ上限を返す
	 *
	 * @access public
	 * @return integer メモリ上限(MB)、設定の必要がない場合はNULL
	 */
	public function getMemoryLimit () {
		return 256;
	}

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
			'body' => $this->request['body'],
			'project_id' => $this->getModule()->getProject()->getID(),
			'account_id' => AccountHandler::getCurrent()->getID(),
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
			$this->getRecord()->updateTags(new BSArray($this->request['tags']));
			$this->database->commit();
		} catch (Exception $e) {
			$this->database->rollBack();
			$this->request->setError($this->getTable()->getName(), $e->getMessage());
			return $this->handleError();
		}
		return $this->getModule()->getListAction()->redirect();
	}

	public function getDefaultView () {
		$this->request->setAttribute('project', $this->getModule()->getProject());
		$this->request->setAttribute('list_action', $this->getModule()->getListAction());
		$this->request->setAttribute('theme', $this->getModule()->getProject()->getTheme());
		$this->request->setAttribute('tags', $this->getModule()->getProject()->getTags());
		return BSView::INPUT;
	}

	public function handleError () {
		return $this->getDefaultView();
	}

	public function registerValidators () {
		$manager = BSValidateManager::getInstance();
		if ($this->request['attachment']) {
			$manager->register('tags', new BSEmptyValidator);
		} else {
			$manager->register('body', new BSEmptyValidator);
		}
	}

	public function getCredential () {
		if ($project = $this->getModule()->getProject()) {
			return $project->getCredential();
		}
	}
}

/* vim:set tabstop=4: */
