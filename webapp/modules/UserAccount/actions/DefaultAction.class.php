<?php
/**
 * Defaultアクション
 *
 * @package jp.co.commons.cfms
 * @subpackage UserAccount
 * @author 小石達也 <tkoishi@b-shock.co.jp>
 * @version $Id$
 */
class DefaultAction extends BSAction {
	public function execute () {
		return $this->getModule()->getAction('Detail')->forward();
	}
}

/* vim:set tabstop=4: */
