<?php
/**
 * @package jp.co.commons.cfms
 */

/**
 * プロジェクトレコード
 *
 * @author 小石達也 <tkoishi@b-shock.co.jp>
 * @version $Id$
 */
class Project extends BSRecord {
	private $accounts;
	private $ideas;
	private $tags;
	private $credential;
	private $theme;

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
	 * テーマを返す
	 *
	 * @access public
	 * @return Theme テーマ
	 */
	public function getTheme () {
		if (!$this->theme) {
			$this->theme = new Theme($this['theme']);
		}
		return $this->theme;
	}

	/**
	 * アカウントを返す
	 *
	 * @access public
	 * @return AccountHandler アカウント
	 */
	public function getAccounts () {
		if (!$this->accounts) {
			$criteria = $this->createCriteriaSet();
			$criteria->register('project_id', $this);
			$sql = BSSQL::getSelectQueryString('account_id', 'account_project', $criteria);

			$ids = new BSArray;
			foreach ($this->getDatabase()->query($sql) as $row) {
				$ids[] = $row['account_id'];
			}

			$this->accounts = new AccountHandler;
			$this->accounts->getCriteria()->register('id', $ids);
		}
		return $this->accounts;
	}

	/**
	 * アカウントとの紐づけを更新
	 *
	 * @access public
	 * @params Account $account アカウント
	 * @params boolean $status 状態
	 */
	public function updateAccountStatus (Account $account, $status) {
		if (!!$status) {
			$values = new BSArray;
			$values['account_id'] = $account->getID();
			$values['project_id'] = $this->getID();
			$sql = BSSQL::getInsertQueryString('account_project', $values);
		} else {
			$criteria = $this->createCriteriaSet();
			$criteria->register('account_id', $account);
			$criteria->register('project_id', $this);
			$sql = BSSQL::getDeleteQueryString('account_project', $criteria);
		}
		$this->getDatabase()->exec($sql);

		$this->accounts = null;
		$this->touch();
	}

	/**
	 * アイデアを返す
	 *
	 * @access public
	 * @return IdeaHandler アイデア
	 */
	public function getIdeas () {
		if (!$this->ideas) {
			$this->ideas = new IdeaHandler;
			$this->ideas->getCriteria()->register('project_id', $this);
		}
		return $this->ideas;
	}

	/**
	 * タグを返す
	 *
	 * @access public
	 * @return TagHandler タグ
	 */
	public function getTags () {
		if (!$this->tags) {
			$this->tags = new TagHandler;
			$this->tags->getCriteria()->register('project_id', $this);
		}
		return $this->tags;
	}

	/**
	 * 認証時に与えられるクレデンシャルを返す
	 *
	 * @access public
	 * @return string クレデンシャル
	 */
	public function getCredential () {
		if (!$this->credential) {
			$credential = new BSStringFormat('%s.%04d');
			$credential[] = get_class($this);
			$credential[] = $this->getID();
			$this->credential = $credential->getContents();
		}
		return $this->credential;
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

	/**
	 * 全てのファイル属性
	 *
	 * @access protected
	 * @return BSArray ファイル属性の配列
	 */
	protected function getFullAttributes () {
		$values = parent::getFullAttributes();
		$values['tags'] = new BSArray;
		foreach ($this->getTags() as $tag) {
			$values['tags'][$tag->getID()] = $tag->getAssignValue();
		}
		$values['ideas'] = new BSArray;
		foreach ($this->getIdeas() as $idea) {
			$values['ideas'][$idea->getID()] = $idea->getAssignValue();
		}
		return $values;
	}
}

/* vim:set tabstop=4 */