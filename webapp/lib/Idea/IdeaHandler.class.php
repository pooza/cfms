<?php
/**
 * @package jp.co.commons.cfms
 */

/**
 * アイデアテーブル
 *
 * @author 小石達也 <tkoishi@b-shock.co.jp>
 */
class IdeaHandler extends BSTableHandler {

	/**
	 * レコード追加可能か？
	 *
	 * @access protected
	 * @return boolean レコード追加可能ならTrue
	 */
	protected function isInsertable () {
		return true;
	}

	/**
	 * レコード作成
	 *
	 * @access public
	 * @param mixed $values 値
	 * @param integer $flags フラグのビット列
	 *   BSDatabase::WITHOUT_LOGGING ログを残さない
	 * @return string レコードの主キー
	 */
	public function createRecord ($values, $flags = null) {
		$id = parent::createRecord($values, $flags);
		$idea = $this->getRecord($id);
		if (!($flags & BSDatabase::WITHOUT_LOGGING)) {
			if ($account = AccountHandler::getCurrent()) {
				$values = array(
					'idea_id' => $idea->getID(),
					'account_id' => $account->getID(),
					'body' => '作成しました。',
				);
				$idea->getLogs()->createRecord($values);
			}
		}
		return $id;
	}

	/**
	 * 子クラスを返す
	 *
	 * @access public
	 * @return BSArray 子クラス名の配列
	 * @static
	 */
	public function getChildClasses () {
		return new BSArray(array(
			'IdeaLog',
		));
	}

	/**
	 * 画像のサイズ名を全てを返す
	 *
	 * @access public
	 * @return BSArray 画像のサイズ名
	 * @static
	 */
	static public function getImageNames () {
		return new BSArray(array(
			'attachment',
		));
	}

	/**
	 * 添付ファイル名を全てを返す
	 *
	 * @access public
	 * @return BSArray 添付ファイル名
	 * @static
	 */
	static public function getAttachmentNames () {
		return new BSArray(array(
			'attachment',
		));
	}
}

/* vim:set tabstop=4 */