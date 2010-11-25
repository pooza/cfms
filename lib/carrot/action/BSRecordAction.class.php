<?php
/**
 * @package org.carrot-framework
 * @subpackage action
 */

/**
 * 詳細画面用 アクションひな形
 *
 * @author 小石達也 <tkoishi@b-shock.co.jp>
 * @version $Id: BSRecordAction.class.php 2324 2010-09-02 05:35:11Z pooza $
 * @abstract
 */
abstract class BSRecordAction extends BSAction {

	/**
	 * 初期化
	 *
	 * Falseを返すと、例外が発生。
	 *
	 * @access public
	 * @return boolean 正常終了ならTrue
	 */
	public function initialize () {
		if ($id = $this->request['id']) {
			$this->setRecordID($id);
		}

		if ($this->isCreateAction()) {
			$this->clearRecordID();
		} else if ($record = $this->getRecord()) {
			$name = BSString::underscorize($this->getModule()->getRecordClass());
			$this->request->setAttribute($name, $record);
			if (!$this->isExecutable() && BSString::isBlank($this->request['submit'])) {
				$this->request->setParameters($record->getAttributes());
			}
		}

		$this->request->setAttribute('styleset', 'carrot.Detail');
		$this->assignStatusOptions();

		return true;
	}

	/**
	 * タイトルを返す
	 *
	 * @access public
	 * @return string タイトル
	 */
	public function getTitle () {
		if (BSString::isBlank($this->title)) {
			if (BSString::isBlank($this->title = $this->getConfig('title'))) {
				try {
					$this->title = $this->getModule()->getRecordClass('ja');
					if ($this->isCreateAction()) {
						$this->title .= '登録';
					} else {
						if ($record = $this->getRecord()) {
							if (BSString::isBlank($name = $record->getName())) {
								$name = '(無題)';
							}
							$this->title .= ':' . $name;
						} else {
							$this->title = $this->getName();
						}
					}
				} catch (Exception $e) {
					$this->title = $this->getName();
				}
			}
		}
		return $this->title;
	}

	/**
	 * 更新レコードのフィールド値を配列で返す
	 *
	 * @access protected
	 * @return mixed[] フィールド値の連想配列
	 */
	protected function getRecordValues () {
		return $this->getRecord()->getAttributes();
	}

	/**
	 * 編集中レコードを返す
	 *
	 * @access public
	 * @return BSRecord 編集中レコード
	 */
	public function getRecord () {
		return $this->getModule()->getRecord();
	}

	/**
	 * レコードを登録する為のアクションか？
	 *
	 * @access protected
	 * @return boolean レコードを登録する為のアクションならTrue
	 */
	protected function isCreateAction () {
		return mb_ereg('^Create', $this->getName());
	}

	/**
	 * レコードを更新
	 *
	 * @access protected
	 */
	protected function updateRecord () {
		if ($this->isCreateAction()) {
			$id = $this->getTable()->createRecord($this->getRecordValues());
			$this->setRecordID($id);
		} else {
			$this->getRecord()->update($this->getRecordValues());
		}
		$this->getRecord()->setAttachments($this->request);
	}

	/**
	 * 論理バリデーション
	 *
	 * レコードが存在するか、最低限チェックする。
	 *
	 * @access public
	 * @return boolean 妥当な入力ならTrue
	 */
	public function validate () {
		if (!$this->isCreateAction() && !$this->getRecord()) {
			$this->request->setError($this->getTable()->getKeyField(), '未登録です。');
			$this->controller->setHeader('Status', BSHTTP::getStatus(404));
			return false;
		}
		return parent::validate();
	}
}

/* vim:set tabstop=4: */
