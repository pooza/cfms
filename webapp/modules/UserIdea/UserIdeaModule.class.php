<?php
/**
 * UserIdeaモジュール
 *
 * @package jp.co.commons.cfms
 * @subpackage UserIdea
 * @author 小石達也 <tkoishi@b-shock.co.jp>
 * @version $Id$
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
			$this->getRecord()->getProject();
		} 
		return BSModule::getInstance('UserProject')->getRecord();
	}
}

/* vim:set tabstop=4: */
