<?php
/**
 * Detailビュー
 *
 * @package jp.co.commons.cfms
 * @subpackage UserIdea
 * @author 小石達也 <tkoishi@b-shock.co.jp>
 */
class DetailView extends BSSmartyView {
	public function execute () {
		if ($this->getModule()->getRecord()->getAttachment('attachment')) {
			$this->setTemplate('Detail.file');
		} else {
			$this->setTemplate('Detail.comment');
		}
	}
}

/* vim:set tabstop=4: */
