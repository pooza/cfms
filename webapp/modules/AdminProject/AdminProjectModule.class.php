<?php
/**
 * AdminProjectモジュール
 *
 * @package jp.co.commons.cfms
 * @subpackage AdminProject
 * @author 小石達也 <tkoishi@b-shock.co.jp>
 */
class AdminProjectModule extends BSModule {
	private $account;

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
	 * 関連するアカウントを返す
	 *
	 * getListActionがListByAccountを返すのでなければ、null
	 *
	 * @access public
	 * @return Account 関連するアカウント
	 */
	public function getAccount () {
		if ($this->getListAction() instanceof ListByAccountAction) {
			return BSModule::getInstance('AdminAccount')->getRecord();
		}
	}
}

/* vim:set tabstop=4: */
