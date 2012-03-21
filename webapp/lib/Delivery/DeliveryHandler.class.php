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
}

/* vim:set tabstop=4 */