<?php
/**
 * Exportアクション
 *
 * @package jp.co.dipps.minc.core
 * @subpackage UserEvent
 * @author 小石達也 <tkoishi@b-shock.co.jp>
 * @version $Id$
 */
class ExportAction extends BSAttachmentAction {
	public function deny () {
		$this->user->setAttribute('requested_url', $this->request->getURL()->getContents());
		return parent::deny();
	}

	public function getCredential () {
		return $this->getModule()->getProject()->getCredential();
	}
}

/* vim:set tabstop=4: */
