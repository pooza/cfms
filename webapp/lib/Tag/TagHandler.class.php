<?php
/**
 * @package jp.co.commons.cfms
 */

/**
 * タグテーブル
 *
 * @author 小石達也 <tkoishi@b-shock.co.jp>
 * @version $Id$
 */
class TagHandler extends BSTableHandler {

	/**
	 * @access public
	 * @param string $criteria 抽出条件
	 * @param string $order ソート順
	 */
	public function __construct ($criteria = null, $order = null) {
		if (!$order) {
			$order = new BSTableFieldSet;
			$order->push('name');
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
	 * 文字列をタグに分割
	 *
	 * @access public
	 * @param string $path パス
	 * @return BSArray タグ文字列の配列
	 * @static
	 */
	static public function split ($contents) {
		return BSString::explode("\n", $contents)->uniquize()->trim();
	}
}

/* vim:set tabstop=4 */