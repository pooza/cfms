<?php
/**
 * CookieDisabledアクション
 *
 * @package org.carrot-framework
 * @subpackage Default
 * @author 小石達也 <tkoishi@b-shock.co.jp>
 */
class CookieDisabledAction extends BSAction {
	public function execute () {
		return BSView::ERROR;
	}
}

/* vim:set tabstop=4: */
