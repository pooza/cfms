<?php
/**
 * AdminTagモジュール
 *
 * @package jp.co.commons.cfms
 * @subpackage AdminTag
 * @author 小石達也 <tkoishi@b-shock.co.jp>
 * @version $Id$
 */
class AdminTagModule extends BSModule {

	/**
	 * プロジェクトを返す
	 *
	 * @access public
	 * @return Project プロジェクト
	 */
	public function getProject () {
		return BSModule::getInstance('AdminProject')->getRecord();
	}
}

/* vim:set tabstop=4: */
