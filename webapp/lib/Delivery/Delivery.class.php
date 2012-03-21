<?php
/**
 * @package jp.co.commons.cfms
 */

/**
 * デリバリーレコード
 *
 * @author 小石達也 <tkoishi@b-shock.co.jp>
 */
class Delivery extends BSRecord {

	/**
	 * 削除可能か？
	 *
	 * @access protected
	 * @return boolean 削除可能ならTrue
	 */
	protected function isDeletable () {
		return true;
	}

	/**
	 * 期限日を返す
	 *
	 * @access public
	 * @return BSDate 期限日
	 */
	public function getExpireDate () {
		return BSDate::create($this['expire_date']);
	}

	/**
	 * 期限日を過ぎているか？
	 *
	 * @access public
	 * @return boolean 期限を過ぎているならTrue
	 */
	public function isExpired () {
		return $this->getExpireDate()->isPast();
	}

	/**
	 * 所有者か？
	 *
	 * @access public
	 * @param Account $account 対象
	 * @return boolean 所有者ならTrue
	 */
	public function isOwnedBy (Account $account) {
		return $this->getAccount()->getID() == $account->getID();
	}

	/**
	 * 添付ファイルのダウンロード時の名を返す
	 *
	 * @access public
	 * @param string $name 名前
	 * @return string ダウンロード時ファイル名
	 */
	public function getAttachmentFileName ($name = null) {
		if ($file = $this->getAttachment($name)) {
			return $this['filename'];
		}
	}

	/**
	 * アサインすべき値を返す
	 *
	 * @access public
	 * @return mixed アサインすべき値
	 */
	public function getAssignableValues () {
		$values = parent::getAssignableValues();
		$values['account'] = $this->getAccount()->getAssignableValues();
		$values['is_expired'] = $this->isExpired();
		return $values;
	}
}

/* vim:set tabstop=4 */