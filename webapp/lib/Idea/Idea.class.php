<?php
/**
 * @package jp.co.commons.cfms
 */

/**
 * アイデアレコード
 *
 * @author 小石達也 <tkoishi@b-shock.co.jp>
 */
class Idea extends BSRecord {
	private $tags;
	private $parentIdea;
	private $comments;

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
	 * 更新
	 *
	 * @access public
	 * @param mixed $values 更新する値
	 * @param integer $flags フラグのビット列
	 *   BSDatabase::WITHOUT_LOGGING ログを残さない
	 *   BSDatabase::WITHOUT_SERIALIZE シリアライズしない
	 */
	public function update ($values, $flags = null) {
		if ($flags & IdeaHandler::WITH_BACKUP) {
			$prev = clone $this->getAttributes();
			$values['serial'] = IdeaHandler::createSerialNumber($this->getProject());
			parent::update($values, $flags);
			$prev->removeParameter('id');
			$this->getTable()->createRecord($prev);
		} else {
			parent::update($values, $flags);
		}
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
	 * 削除フラグを立てる
	 *
	 * @access public
	 */
	public function trash () {
		if ($file = $this->getAttachment('attachment')) {
			$file->delete();
		}
		$this->update(array(
			'delete_date' => BSDate::getNow('Y-m-d H:i:s'),
			'update_date' => $this['update_date'],
			'status' => 'hide',
		));
		$this->clearTags();
	}

	/**
	 * 返信を投稿
	 *
	 * @access public
	 * @param Account $account 発言者
	 * @param string $body 本文
	 * @return mixed 作成されたアイデアの主キー
	 */
	public function reply (Account $account, $body) {
		$values = new BSArray(array(
			"name" => 'Re:' . $this['name'],
			'body' => $body,
			'parent_idea_id' => $this->getID(),
			'project_id' => $this->getProject()->getID(),
			'account_id' => $account->getID(),
		));
		if (!BSString::isBlank($this['name_en'])) {
			$values['name_en'] = 'Re:' . $this['name_en'];
		}
		return $this->getTable()->createRecord($values);
	}

	/**
	 * コメントを全て返す
	 *
	 * @access public
	 * @return IdeaHandler 全てのコメントを含んだテーブル
	 */
	public function getComments () {
		if (!$this->comments) {
			$this->comments = new IdeaHandler;
			$this->comments->getCriteria()->register('parent_idea_id', $this);
		}
		return $this->comments;
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
	 * 親アイデアを返す
	 *
	 * @access public
	 * @return Idea 親アイデア
	 */
	public function getParentIdea () {
		if (!$this->parentIdea && ($id = $this['parent_idea_id'])) {
			$this->parentIdea = BSTableHandler::create('idea')->getRecord($id);
		}
		return $this->parentIdea;
	}

	/**
	 * 画像か？
	 *
	 * @access public
	 * @return boolean 画像ならTrue
	 */
	public function isImage () {
		$file = $this->getAttachment('attachment');
		return (mb_ereg('^image/', $file->getType())
			|| $file->getType() == BSMIMEType::getType('pdf')
		);
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
	 * @param BSArray $names タグ名の配列
	 */
	public function updateTags (BSArray $names) {
		$this->clearTags();
		$tags = new TagHandler;
		$names->uniquize();
		foreach ($names as $name) {
			$values = new BSArray;
			$values['idea_id'] = $this->getID();
			$values['tag_id'] = $this->getProject()->getTag($name)->getID();
			$sql = BSSQL::getInsertQueryString('idea_tag', $values);
			$this->getDatabase()->exec($sql);
		}

		$this->tags = null;
		$this->touch();
	}

	/**
	 * 全てのタグとの関連を削除
	 *
	 * @access public
	 */
	public function clearTags () {
		$criteria = $this->createCriteriaSet();
		$criteria->register('idea_id', $this);
		$sql = BSSQL::getDeleteQueryString('idea_tag', $criteria);
		$this->getDatabase()->exec($sql);
	}

	/**
	 * メールを送信
	 *
	 * @access public
	 * @param BSArray $ids アカウントIDのリスト
	 */
	public function sendMails (BSArray $ids) {
		$mail = new BSSmartyMail;
		$mail->getRenderer()->setTemplate(get_class($this) . '.mail');

		$values = $this->getAssignableValues();
		$values['project'] = $this->getProject()->getAssignableValues();
		$values['tags'] = new BSArray;
		$values['accounts'] = new BSArray;
		foreach ($this->getTags() as $tag) {
			$values['tags'][$tag->getID()] = $tag->getAssignableValues();
		}

		$accounts = new AccountHandler;
		$accounts->getCriteria()->register('id', $ids);
		foreach ($accounts as $account) {
			$values['accounts'][$account->getID()] = $account->getAssignableValues();
		}

		$mail->getRenderer()->setAttribute('idea', $values);
		$mail->send();
	}

	/**
	 * 添付ファイルのダウンロード時の名を返す
	 *
	 * @access public
	 * @param string $name 名前
	 * @return string ダウンロード時ファイル名
	 */
	public function getAttachmentFileName ($name = null) {
		if ($file = $this->getAttachment($name)) {
			return $this->getName() . $file->getSuffix();
		}
	}

	/**
	 * 添付ファイルをまとめて設定
	 *
	 * @access public
	 * @param BSWebRequest $request リクエスト
	 */
	public function setAttachments (BSWebRequest $request) {
		foreach ($this->getTable()->getAttachmentNames() as $name) {
			if ($info = $request[$name]) {
				$this->setAttachment(new BSFile($info['tmp_name']), $name);
			}
		}
	}

	/**
	 * 全てのファイル属性
	 *
	 * @access protected
	 * @return BSArray ファイル属性の配列
	 */
	protected function getSerializableValues () {
		$values = parent::getSerializableValues();
		$values['account'] = $this->getAccount()->getAssignableValues();
		if ($parent = $this->getParentIdea()) {
			$values['parent'] = $parent->getAssignableValues();
		}
		$values['is_image'] = $this->getAttachment('attachment') && $this->isImage();
		return $values;
	}
}

/* vim:set tabstop=4 */