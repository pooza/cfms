<?php
/**
 * Loginアクション
 *
 * @package jp.co.commons.cfms
 * @subpackage Default
 * @author 小石達也 <tkoishi@b-shock.co.jp>
 * @version $Id$
 */
class LoginAction extends BSAction {
	public function execute () {
		$accounts = new AccountHandler;
		$values = new BSArray(array(
			'email' => $this->request['email'],
			'status' => 'show',
		));
		if ($account = $accounts->getRecord($values)) {
			if ($this->user->login($account, $this->request['password'])) {
				$url = BSURL::getInstance();
				$url['path'] = '/UserProject/';
				return $url->redirect();
			}
		}

		$role = BSAdministratorRole::getInstance();
		$email = BSMailAddress::getInstance($this->request['email']);
		if ($email->getContents() == $role->getMailAddress()->getContents()) {
			if ($this->user->login($role, $this->request['password'])) {
				$url = BSURL::getInstance();
				$url['path'] = '/AdminProject/';
				return $url->redirect();
			}
		}
		$this->request->setError('email', 'ユーザー又はパスワードが違います。');
	}

	public function getDefaultView () {
		return BSView::INPUT;
	}

	public function handleError () {
		return $this->getDefaultView();
	}
}

/* vim:set tabstop=4: */
