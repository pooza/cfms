<?php
/**
 * Createビュー
 *
 * @package jp.co.commons.cfms
 * @subpackage UserDelivery
 * @author 小石達也 <tkoishi@b-shock.co.jp>
 */
class CreateView extends BSSmartyView {
	public function execute () {
		$this->setAttribute('duration_options', DeliveryHandler::getDurationOptions());
	}
}

/* vim:set tabstop=4: */
