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

	/**
	 * 画像のサイズ名を全てを返す
	 *
	 * @access public
	 * @return BSArray 画像のサイズ名
	 * @static
	 */
	static public function getImageNames () {
		return new BSArray(array(
			'icon',
		));
	}

	/**
	 * ログイン中アカウント返す
	 *
	 * @access public
	 * @return Account ログイン中アカウント
	 * @static
	 */
	static public function getCurrent () {
		if ($id = BSUser::getInstance()->getID()) {
			$table = new self;
			return $table->getRecord($id);
		}
	}
}

/* vim:set tabstop=4 */