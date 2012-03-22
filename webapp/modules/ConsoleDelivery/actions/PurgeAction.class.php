<?php
/**
 * Purgeアクション
 *
 * @package jp.co.commons.cfms
 * @subpackage ConsoleDelivery
 * @author 小石達也 <tkoishi@b-shock.co.jp>
 */
class PurgeAction extends BSTableAction {
	protected function getCriteria () {
		if (!$this->criteria) {
			$this->criteria = $this->database->createCriteriaSet();
			$this->criteria->register('expire_date', BSDate::getNow('Y-m-d H:i:s'), '<');
		}
		return $this->criteria;
	}

	public function execute () {
		foreach ($this->getTable() as $record) {
			try{
				$record->delete();
			} catch (Exception $e) {
			}
		}
		BSLogManager::getInstance()->put('実行しました。', $this);
		return BSView::NONE;
	}
}

/* vim:set tabstop=4: */
