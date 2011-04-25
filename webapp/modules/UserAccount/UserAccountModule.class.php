<?php
/**
 * UserAccountモジュール
 *
 * @package jp.co.commons.cfms
 * @subpackage UserAccount
 * @author 小石達也 <tkoishi@b-shock.co.jp>
 */
class UserAccountModule extends BSModule {

	/**
	 * プロジェクトを返す
	 *
	 * @access public
	 * @return Project プロジェクト
	 */
	public function getProject () {
		return BSModule::getInstance('UserProject')->getRecord();
	}
}

/* vim:set tabstop=4: */
