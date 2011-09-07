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
	const WITH_BACKUP = 8;

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
	 * レコード追加
	 *
	 * @access public
	 * @param mixed $values 値
	 * @param integer $flags フラグのビット列
	 *   BSDatabase::WITH_LOGGING ログを残さない
	 * @return string レコードの主キー
	 */
	public function createRecord ($values, $flags = null) {
		if ($flags & self::WITH_BACKUP) {
			$db = $this->getDatabase();
			$db->exec(BSSQL::getInsertQueryString($this, $values, $db));
			$this->setExecuted(false);
			return $db->lastInsertId();
		} else {
			return parent::createRecord($values, $flags);
		}
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