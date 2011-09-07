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
	 * リストアクションを返す
	 *
	 * @access public
	 * @return BSTableAction リストアクション
	 */
	public function getListAction () {
		$key = $this->getName() . '.ListAction';
		if (BSString::isBlank($name = $this->user->getAttribute($key))) {
			$name = 'Wall';
		}
		return BSModule::getInstance('UserProject')->getAction($name);
	}

	/**
	 * リストアクションを設定
	 *
	 * @access public
	 * @param BSTableAction $action リストアクション
	 */
	public function setListAction (BSAction $action) {
		$this->user->setAttribute($this->getName() . '.ListAction', $action->getName());
	}

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
