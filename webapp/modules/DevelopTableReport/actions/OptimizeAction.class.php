<?php
/**
 * Optimizeアクション
 *
 * @package org.carrot-framework
 * @subpackage DevelopTableReport
 * @author 小石達也 <tkoishi@b-shock.co.jp>
 */
class OptimizeAction extends BSAction {
	private $database;

	private function getDatabase () {
		if (!$this->database) {
			$this->database = BSDatabase::getInstance($this->request['database']);
		}
		return $this->database;
	}

	public function execute () {
		$this->getDatabase()->optimize();

		$url = $this->getModule()->getAction('Database')->createURL();
		$url->setParameter('database', $this->getDatabase()->getName());
		return $url->redirect();
	}

	public function handleError () {
		return $this->controller->getAction('not_found')->forward();
	}

	public function validate () {
		return !!$this->getDatabase();
	}
}

/* vim:set tabstop=4: */
