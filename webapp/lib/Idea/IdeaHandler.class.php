<?php
/**
 * @package jp.co.commons.cfms
 */

/**
 * アイデアテーブル
 *
 * @author 小石達也 <tkoishi@b-shock.co.jp>
 * @version $Id$
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