<?php
/**
 * UserIdeaLogモジュール
 *
 * @package jp.co.commons.cfms
 * @subpackage UserIdeaLog
 * @author 小石達也 <tkoishi@b-shock.co.jp>
 */
class UserIdeaLogModule extends BSModule {

	/**
	 * アイデアを返す
	 *
	 * @access public
	 * @return Idea アイデア
	 */
	public function getIdea () {
		return BSModule::getInstance('UserIdea')->getRecord();
	}
}

/* vim:set tabstop=4: */
