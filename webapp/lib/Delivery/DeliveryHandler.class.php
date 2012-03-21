<?php
/**
 * @package jp.co.commons.cfms
 */

/**
 * デリバリーテーブル
 *
 * @author 小石達也 <tkoishi@b-shock.co.jp>
 */
class DeliveryHandler extends BSTableHandler {

	/**
	 * @access public
	 * @param string $criteria 抽出条件
	 * @param string $order ソート順
	 */
	public function __construct ($criteria = null, $order = null) {
		if (!$order) {
			$order = new BSTableFieldSet;
			$order->push('create_date DESC');
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

	/**
	 * 期間を全てを返す
	 *
	 * @access public
	 * @return BSArray 期間
	 * @static
	 */
	static public function getDurationOptions () {
		return new BSArray(array(
			1 => '1日',
			3 => '3日',
			7 => '1週間',
		));
	}
}

/* vim:set tabstop=4 */