<?php
/**
 * Listビュー
 *
 * @package jp.co.commons.cfms
 * @subpackage UserProject
 * @author 小石達也 <tkoishi@b-shock.co.jp>
 */
class ListView extends BSSmartyView {
	public function execute () {
		$projects = $this->request->getAttribute('projects');
		$projects = $this->columnize($projects, 5);
		$projects = $this->columnize($projects, 2);
		$this->setAttribute('pages', $projects);
	}

	private function columnize ($array, $columns = 5) {
		if ($array instanceof BSParameterHolder) {
			$array = $array->getParameters();
		}

		$array = new BSArray(array_chunk($array, $columns));
		$last = new BSArray($array->pop());
		for ($i = $last->count() ; $i < $columns ; $i ++) {
			$last[] = null;
		}
		$array[] = $last;
		return $array;
	}
}

/* vim:set tabstop=4: */
