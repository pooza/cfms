<?php
/**
 * @package jp.co.commons.cfms
 */

/**
 * ファイルログレコード
 *
 * @author 小石達也 <tkoishi@b-shock.co.jp>
 * @version $Id$
 */
class IdeaLog extends BSRecord {

	/**
	 * 親レコードを返す
	 *
	 * @access public
	 * @return BSRecord 親レコード
	 */
	public function getParent () {
		return $this->getItem();
	}
}

/* vim:set tabstop=4 */