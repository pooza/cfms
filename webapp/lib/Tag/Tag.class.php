<?php
/**
 * @package jp.co.commons.cfms
 */

/**
 * タグレコード
 *
 * @author 小石達也 <tkoishi@b-shock.co.jp>
 */
class Tag extends BSRecord {
	private $ideas;

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
		return ((1 < $this->getProject()->getTags()->count())
			&& !$this->getIdeas()->count()
		);
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
	 * アイデアを返す
	 *
	 * @access public
	 * @return IdeaHandler アイデア
	 */
	public function getIdeas () {
		if (!$this->ideas) {
			$criteria = $this->createCriteriaSet();
			$criteria->register('tag_id', $this);
			$sql = BSSQL::getSelectQueryString('idea_id', 'idea_tag', $criteria);

			$ids = new BSArray;
			foreach ($this->getDatabase()->query($sql) as $row) {
				$ids[] = $row['idea_id'];
			}

			$this->ideas = new IdeaHandler;
			$this->ideas->getCriteria()->register('id', $ids);
		}
		return $this->ideas;
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