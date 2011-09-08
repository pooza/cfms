<?php
/**
 * @package jp.co.commons.cfms
 */

/**
 * アイデアテーブル
 *
 * @author 小石達也 <tkoishi@b-shock.co.jp>
 */
class IdeaHandler extends BSTableHandler {
	const WITH_BACKUP = 4096;

	/**
	 * レコード追加可能か？
	 *
	 * @access protected
	 * @return boolean レコード追加可能ならTrue
	 */
	protected function isInsertable () {
		return true;
	}

	/**
	 * レコード追加
	 *
	 * @access public
	 * @param mixed $values 値
	 * @param integer $flags フラグのビット列
	 *   BSDatabase::WITH_LOGGING ログを残さない
	 * @return string レコードの主キー
	 */
	public function createRecord ($values, $flags = null) {
		$values = new BSArray($values);
		if (!$values->hasParameter('serial')) {
			$project = BSTableHandler::create('project')->getRecord($values['project_id']);
			$values['serial'] = self::createSerialNumber($project);
		}
		return parent::createRecord($values, $flags);
	}

	/**
	 * 新しいシリアルナンバーを生成
	 *
	 * @access protected
	 * @param Project $project 対象プロジェクト
	 * @return integer シリアルナンバー
	 * @static
	 */
	static public function createSerialNumber (Project $project) {
		$db = BSDatabase::getInstance();
		$criteria = $db->createCriteriaSet();
		$criteria->register('project_id', $project);
		$sql = BSSQL::getSelectQueryString(
			array('max(serial) as recent'),
			'idea',
			$criteria
		);

		$recent = 0;
		if ($row = $db->query($sql)->fetch()) {
			$recent = $row['recent'];
		}
		return $recent + 1;
	}

	/**
	 * 画像のサイズ名を全てを返す
	 *
	 * @access public
	 * @return BSArray 画像のサイズ名
	 * @static
	 */
	static public function getImageNames () {
		return new BSArray(array(
			'attachment',
		));
	}

	/**
	 * 添付ファイル名を全てを返す
	 *
	 * @access public
	 * @return BSArray 添付ファイル名
	 * @static
	 */
	static public function getAttachmentNames () {
		return new BSArray(array(
			'attachment',
		));
	}
}

/* vim:set tabstop=4 */