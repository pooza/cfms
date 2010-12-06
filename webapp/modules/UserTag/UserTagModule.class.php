<?php
/**
 * UserTagモジュール
 *
 * @package jp.co.commons.cfms
 * @subpackage UserTag
 * @author 小石達也 <tkoishi@b-shock.co.jp>
 * @version $Id$
 */
class UserTagModule extends BSModule {

	/**
	 * プロジェクトを返す
	 *
	 * @access public
	 * @return Project プロジェクト
	 */
	public function getProject () {
		if ($this->getRecord()) {
			$this->getRecord()->getProject();
		} 
		return BSModule::getInstance('UserProject')->getRecord();
	}
}

/* vim:set tabstop=4: */
