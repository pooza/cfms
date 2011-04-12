<?php
/**
 * Exportアクション
 *
 * @package jp.co.dipps.minc.core
 * @subpackage UserEvent
 * @author 小石達也 <tkoishi@b-shock.co.jp>
 */
class ExportAction extends BSAttachmentAction {
	public function deny () {
		$this->user->setAttribute('requested_url', $this->request->getURL()->getContents());
		return parent::deny();
	}

	public function getCredential () {
		return $this->getModule()->getProject()->getCredential();
	}

	public function execute () {
		if ($account = AccountHandler::getCurrent()) {
			$idea = $this->getRecord();
			$values = array(
				'idea_id' => $idea->getID(),
				'account_id' => $account->getID(),
				'body' => 'ダウンロードしました。',
			);
			$idea->getLogs()->createRecord($values);
		}
		return parent::execute();
	}
}

/* vim:set tabstop=4: */
