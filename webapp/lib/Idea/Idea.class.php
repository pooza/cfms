<?php
/**
 * @package jp.co.commons.cfms
 */

/**
 * アイデアレコード
 *
 * @author 小石達也 <tkoishi@b-shock.co.jp>
 * @version $Id$
 */
class Idea extends BSRecord {
	private $tags;

	/**
	 * 更新可能か？
	 *
	 * @access protected
	 * @return boolean 更新可能ならTrue
	 */
	protected function isUpdatable () {
		return true;
	}

	/**
	 * 削除可能か？
	 *
	 * @access protected
	 * @return boolean 削除可能ならTrue
	 */
	protected function isDeletable () {
		return true;
	}

	/**
	 * 親レコードを返す
	 *
	 * @access public
	 * @return BSRecord 親レコード
	 */
	public function getParent () {
		return $this->getProject();
	}

	/**
	 * タグを返す
	 *
	 * @access public
	 * @return TagHandler タグ
	 */
	public function getTags () {
		if (!$this->tags) {
			$criteria = $this->createCriteriaSet();
			$criteria->register('idea_id', $this);
			$sql = BSSQL::getSelectQueryString('tag_id', 'idea_tag', $criteria);

			$ids = new BSArray;
			foreach ($this->getDatabase()->query($sql) as $row) {
				$ids[] = $row['tag_id'];
			}

			$this->tags = new TagHandler;
			$this->tags->getCriteria()->register('id', $ids);
		}
		return $this->tags;
	}

	/**
	 * タグを更新
	 *
	 * @access public
	 * @params BSArray $ids タグIDの配列
	 */
	public function updateTags (BSArray $ids) {
		$criteria = $this->createCriteriaSet();
		$criteria->register('idea_id', $this);
		$sql = BSSQL::getDeleteQueryString('idea_tag', $criteria);
		$this->getDatabase()->exec($sql);

		$ids->uniquize();
		foreach ($ids as $id) {
			$values = new BSArray;
			$values['idea_id'] = $this->getID();
			$values['tag_id'] = $id;
			$sql = BSSQL::getInsertQueryString('idea_tag', $values);
			$this->getDatabase()->exec($sql);
		}

		$this->tags = null;
		$this->touch();
	}

	/**
	 * シリアライズするか？
	 *
	 * @access public
	 * @return boolean シリアライズするならTrue
	 */
	public function isSerializable () {
		return true;
	}
}

/* vim:set tabstop=4 */