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
	 * アサインすべき値を返す
	 *
	 * @access public
	 * @return mixed アサインすべき値
	 */
	public function getAssignableValues () {
		$values = parent::getAssignableValues();
		$values['account'] = $this->getAccount()->getAssignableValues();
		return $values;
	}
}

/* vim:set tabstop=4 */