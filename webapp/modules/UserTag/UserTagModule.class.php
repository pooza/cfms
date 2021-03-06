<?php
/**
 * UserTagモジュール
 *
 * @package jp.co.commons.cfms
 * @subpackage UserTag
 * @author 小石達也 <tkoishi@b-shock.co.jp>
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
			return $this->getRecord()->getProject();
		} 
		return BSModule::getInstance('UserProject')->getRecord();
	}
}

/* vim:set tabstop=4: */
