<?php
/**
 * Loginアクション
 *
 * @package jp.co.commons.cfms
 * @subpackage Default
 * @author 小石達也 <tkoishi@b-shock.co.jp>
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
				if (BSString::isBlank($url = $this->user->getAttribute('requested_url'))) {
					$url = BSURL::create();
					$url['path'] = '/UserProject/';
				} else {
					$url = BSURL::create($url);
				}
				$this->user->removeAttribute('requested_url');
				return $url->redirect();
			}
		}

		$role = BSAdministratorRole::getInstance();
		$email = BSMailAddress::create($this->request['email']);
		if ($email->getContents() == $role->getMailAddress()->getContents()) {
			if ($this->user->login($role, $this->request['password'])) {
				$url = BSURL::create();
				$url['path'] = '/AdminProject/';
				return $url->redirect();
			}
		}
		$this->request->setError('email', 'ユーザー又はパスワードが違います。');
		return $this->handleError();
	}

	public function getDefaultView () {
		return BSView::INPUT;
	}

	public function handleError () {
		return $this->getDefaultView();
	}
}

/* vim:set tabstop=4: */
