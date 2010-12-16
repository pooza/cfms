<?php
/**
 * Listビュー
 *
 * @package jp.co.commons.cfms
 * @subpackage UserIdea
 * @author 小石達也 <tkoishi@b-shock.co.jp>
 * @version $Id$
 */
class ListView extends BSSmartyView {
	public function execute () {
		$this->setAttribute('tags', $this->getModule()->getProject()->getTags());
	}
}

/* vim:set tabstop=4: */
