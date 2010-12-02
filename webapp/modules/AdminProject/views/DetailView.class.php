<?php
/**
 * Detailビュー
 *
 * @package jp.co.commons.cfms
 * @subpackage AdminProject
 * @author 小石達也 <tkoishi@b-shock.co.jp>
 * @version $Id$
 */
class DetailView extends BSSmartyView {
	public function execute () {
		$this->setAttribute('themes', Theme::getNames());
	}
}

/* vim:set tabstop=4: */
