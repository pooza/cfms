<?php
/**
 * @package jp.co.commons.cfms
 */

/**
 * アカウントレコード
 *
 * @author 小石達也 <tkoishi@b-shock.co.jp>
 * @version $Id$
 */
class Account extends BSRecord {

	/**
	 * 更新可能か？
	 *
	 * @access protected
	 * @return boolean 更新可能ならTrue
	 */
	protected function isUpdatable () {
		return true;
	}

	/**
	 * 日付を返す
	 *
	 * @access public
	 * @return BSDate 記事日付
	 */
	public function getDate () {
		if (!$this->date) {
			$this->date = BSDate::getInstance($this['create_date']);
		}
		return $this->date;
	}

	/**
	 * 新着か？
	 *
	 * @access public
	 * @return boolean 新着ならTrue
	 */
	public function isNew () {
		return !$this->getDate()->setAttribute('day', '+1')->isPast();
	}

	/**
	 * シリアライズするか？
	 *
	 * @access public
	 * @return boolean シリアライズするならTrue
	 */
	public function isSerializable () {
		return true;
	}
}

/* vim:set tabstop=4 */