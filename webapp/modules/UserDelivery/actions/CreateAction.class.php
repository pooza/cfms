<?php
/**
 * Createアクション
 *
 * @package jp.co.commons.cfms
 * @subpackage UserDelivery
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
		$date = BSDate::create();
		$date['day'] = '+' . $this->request['preserve_duration'];
		return array(
			'recipient' => $this->request['recipient'],
			'email' => $this->request['email'],
			'expire_date' => $date->format('Y-m-d H:i:s'),
			'password' => $this->request['password'],
			'filename' => $this->request['attachment']['name'],
			'comment' => $this->request['comment'],
			'account_id' => AccountHandler::getCurrent()->getID(),
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
		return $this->redirect();
	}

	public function getDefaultView () {
		$this->request->setAttribute('theme', new Theme);
		return BSView::INPUT;
	}

	public function handleError () {
		return $this->getDefaultView();
	}

	public function getCredential () {
		return 'Delivery';
	}
}

/* vim:set tabstop=4: */
