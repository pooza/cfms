<?php
/**
 * Createビュー
 *
 * @package jp.co.commons.cfms
 * @subpackage AdminAccount
 * @author 小石達也 <tkoishi@b-shock.co.jp>
 */
class CreateView extends BSSmartyView {
	public function execute () {
		$this->setAttribute('type_options', AccountHandler::getTypeOptions());
	}
}

/* vim:set tabstop=4: */
