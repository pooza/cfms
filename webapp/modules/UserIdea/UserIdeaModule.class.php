<?php
/**
 * UserIdeaモジュール
 *
 * @package jp.co.commons.cfms
 * @subpackage UserIdea
 * @author 小石達也 <tkoishi@b-shock.co.jp>
 */
class UserIdeaModule extends BSModule {

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
