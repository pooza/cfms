<?php
/**
 * @package org.carrot-framework
 * @author 小石達也 <tkoishi@b-shock.co.jp>
 */
class BSExcelExporterTest extends BSTest {
	public function execute () {
		$this->assert('__construct', $exporter = new BSExcelExporter);
		$exporter->addRecord(new BSArray(array(
			'name' => 'pooza',
			'point' => 100,
		)));
		$exporter->addRecord(new BSArray(array(
			'name' => 'ビーショック',
			'point' => 900,
		)));
		$this->assert('getType', $exporter->getType() == 'application/vnd.ms-excel');
		$this->assert('getContents', !BSString::isBlank($exporter->getContents()));
		$exporter->getFile()->delete();
	}
}

/* vim:set tabstop=4: */
