<?php
/**
 * AdminAccountモジュール
 *
 * @package jp.co.commons.cfms
 * @subpackage AdminProject
 * @author 小石達也 <tkoishi@b-shock.co.jp>
 */
class AdminAccountModule extends BSModule {
	private $project;

	/**
	 * リストアクションを返す
	 *
	 * @access public
	 * @return BSTableAction リストアクション
	 */
	public function getListAction () {
		$key = $this->getName() . '.ListAction';
		if (BSString::isBlank($name = $this->user->getAttribute($key))) {
			$name = 'List';
		}
		return $this->getAction($name);
	}

	/**
	 * リストアクションを設定
	 *
	 * @access public
	 * @param BSTableAction $action リストアクション
	 */
	public function setListAction (BSTableAction $action) {
		$this->user->setAttribute($this->getName() . '.ListAction', $action->getName());
	}

	/**
	 * 関連するプロジェクトを返す
	 *
	 * getListActionがListByProjectを返すのでなければ、null
	 *
	 * @access public
	 * @return Project 関連するプロジェクト
	 */
	public function getProject () {
		if ($this->getListAction() instanceof ListByProjectAction) {
			return BSModule::getInstance('AdminProject')->getRecord();
		}
	}
}

/* vim:set tabstop=4: */
