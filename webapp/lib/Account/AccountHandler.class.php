<?php
/**
 * @package jp.co.commons.cfms
 */

/**
 * アカウントテーブル
 *
 * @author 小石達也 <tkoishi@b-shock.co.jp>
 */
class AccountHandler extends BSTableHandler {

	/**
	 * @access public
	 * @param mixed $criteria 抽出条件
	 * @param mixed $order ソート順
	 */
	public function __construct ($criteria = null, $order = null) {
		if (!$order) {
			$order = new BSTableFieldSet;
			$order->push('update_date DESC');
		}
		parent::__construct($criteria, $order);
	}

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
		$values['password'] = BSCrypt::digest($values['password']);
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
	 * 種類を全てを返す
	 *
	 * @access public
	 * @return BSArray 種類
	 * @static
	 */
	static public function getTypeOptions () {
		return new BSArray(array(
			'customer' => 'クライアント',
			'supplier' => '協力会社',
			'commons' => 'コモンズ',
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