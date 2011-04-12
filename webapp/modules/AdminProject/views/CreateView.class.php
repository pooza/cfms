<?php
/**
 * Createビュー
 *
 * @package jp.co.commons.cfms
 * @subpackage AdminProject
 * @author 小石達也 <tkoishi@b-shock.co.jp>
 */
class CreateView extends BSSmartyView {
	public function execute () {
		$this->setAttribute('themes', Theme::getNames());
	}
}

/* vim:set tabstop=4: */
