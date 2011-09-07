<?php
/**
 * WallListアクション
 *
 * @package jp.co.commons.cfms
 * @subpackage UserIdea
 * @author 小石達也 <tkoishi@b-shock.co.jp>
 */
class WallListAction extends BSTableAction {
	protected function getPageSize () {
		return 20;
	}

	public function getCriteria () {
		if (!$this->criteria) {
			$this->criteria = $this->createCriteriaSet();
		}
		return $this->criteria;
	}

	protected function getOrder () {
		if (!$this->order) {
			$this->order = new BSTableFieldSet;
			$this->order->push('update_date DESC');
			$this->order->push('create_date DESC');
		}
		return $this->order;
	}

	public function execute () {
		$this->request->setAttribute('ideas', $this->getRows());
		$this->request->setAttribute('project', $this->getModule()->getProject());
		$this->request->setAttribute('theme', $this->getModule()->getProject()->getTheme());
		return BSView::SUCCESS;
	}

	public function deny () {
		$this->user->setAttribute('requested_url', $this->request->getURL()->getContents());
		return parent::deny();
	}

	public function getCredential () {
		return $this->getModule()->getProject()->getCredential();
	}
}

/* vim:set tabstop=4: */
