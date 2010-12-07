<?php
/**
 * @package jp.co.commons.cfms
 */

/**
 * ファイルログテーブル
 *
 * @author 小石達也 <tkoishi@b-shock.co.jp>
 * @version $Id$
 */
class IdeaLogHandler extends BSTableHandler {

	/**
	 * @access public
	 * @param mixed $criteria 抽出条件
	 * @param mixed $order ソート順
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