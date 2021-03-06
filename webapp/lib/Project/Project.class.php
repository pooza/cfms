<?php
/**
 * @package jp.co.commons.cfms
 */

/**
 * プロジェクトレコード
 *
 * @author 小石達也 <tkoishi@b-shock.co.jp>
 */
class Project extends BSRecord {
	private $accounts;
	private $ideas;
	private $ideasGrouped;
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
	 * 規定タグを作成
	 *
	 * @access public
	 */
	public function createDefaultTag () {
		$values = new BSArray(array(
			'name' => $this['name'],
			'name_en' => $this['name_en'],
			'project_id' => $this->getID(),
		));
		BSTableHandler::create('tag')->createRecord($values);
	}

	/**
	 * アカウントとの紐づけを更新
	 *
	 * @access public
	 * @param Account $account アカウント
	 * @param boolean $status 状態
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
	 * アイデアをグループ化して返す
	 *
	 * @access public
	 * @param string $key 検索語
	 * @return BSArray グループ化されたアイデアの配列
	 */
	public function getIdeasGrouped ($key) {
		if (!$this->ideasGrouped) {
			$this->ideasGrouped = new BSArray;

			foreach ($this->getTags() as $tag) {
				$this->ideasGrouped[] = $ideas = new BSArray;
				$ideas['tag'] = $tag->getAssignableValues();
				$ideas['ideas'] = new BSArray;

				$table = clone $tag->getIdeas();
				$table->getCriteria()->register('status', 'show');
				$table->getCriteria()->register('delete_date', null);

				if (!BSString::isBlank($key)) {
					$criteria = $this->createCriteriaSet();
					$criteria->setGlue('or');
					foreach (array('name', 'body') as $field) {
						$criteria->register($field, '%' . $key . '%', 'like');
					}
					$table->getCriteria()->setParameter('key', $criteria);
				}

				$table->getOrder()->push('serial DESC');
				$table->query();
				foreach ($table as $idea) {
					if ($idea->getAttachment('attachment')) {
						$ideas['ideas'][$idea->getID()] = $idea->getAssignableValues();
					}
				}
			}
		}
		return $this->ideasGrouped;
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
			$this->tags->getOrder()->clear();
			$this->tags->getOrder()->push('update_date DESC');
		}
		return $this->tags;
	}

	/**
	 * タグを返す
	 *
	 * なければ生成。
	 *
	 * @access public
	 * @param string $name タグ名
	 * @return Tag タグ
	 */
	public function getTag ($name) {
		$tags = $this->getTags();
		$tags->query();

		$values = new BSArray;
		$values['project_id'] = $this->getID();
		$values['name'] = $name;
		if (!$tag = $tags->getRecord($values)) {
			$values = new BSArray;
			$values['project_id'] = $this->getID();
			$values['name'] = $name;
			$id = $tags->createRecord($values);
			$tag = $tags->getRecord($id);
		}
		return $tag;
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
	protected function getSerializableValues () {
		$values = parent::getSerializableValues();
		$values['tags'] = new BSArray;
		foreach ($this->getTags() as $tag) {
			$values['tags'][$tag->getID()] = $tag->getAssignableValues();
		}
		$values['ideas'] = new BSArray;
		foreach ($this->getIdeas() as $idea) {
			$values['ideas'][$idea->getID()] = $idea->getAssignableValues();
		}
		$values['accounts'] = new BSArray;
		foreach ($this->getAccounts() as $idea) {
			$values['accounts'][$idea->getID()] = $idea->getAssignableValues();
		}
		return $values;
	}

	/**
	 * リダイレクト対象
	 *
	 * @access public
	 * @return BSURL
	 */
	public function getURL () {
		if (!$this->url) {
			$this->url = BSURL::create(null, 'carrot');
			$this->url['module'] = 'UserProject';
			$this->url['action'] = 'Wall';
			$this->url['record'] = $this;
		}
		return $this->url;
	}
}

/* vim:set tabstop=4 */