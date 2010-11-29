<?php
/**
 * @package jp.co.commons.cfms
 */

/**
 * アカウントテーブル
 *
 * @author 小石達也 <tkoishi@b-shock.co.jp>
 * @version $Id$
 */
class AccountHandler extends BSTableHandler {

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
		$values = new BSArray($values);
		$values['password'] = BSCrypt::getDigest($values['password']);
		return parent::createRecord($values, $flags);
	}
}

/* vim:set tabstop=4 */