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
	private $logs;

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
		parent::update($values, $flags);
		if (!($flags & BSDatabase::WITHOUT_LOGGING)) {
			if ($account = AccountHandler::getCurrent()) {
				$values = array(
					'idea_id' => $this->getID(),
					'account_id' => $account->getID(),
					'body' => '更新しました。',
				);
				$this->getLogs()->createRecord($values);
			}
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
	 * 親レコードを返す
	 *
	 * @access public
	 * @return BSRecord 親レコード
	 */
	public function getParent () {
		return $this->getProject();
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
	 * ログを返す
	 *
	 * @access public
	 * @return IdeaLogHandler ログテーブル
	 */
	public function getLogs () {
		if (!$this->logs) {
			$this->logs = new IdeaLogHandler;
			$this->logs->getCriteria()->register('idea_id', $this);
		}
		return $this->logs;
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
	 * @params BSArray $names タグ名の配列
	 */
	public function updateTags (BSArray $names) {
		$criteria = $this->createCriteriaSet();
		$criteria->register('idea_id', $this);
		$sql = BSSQL::getDeleteQueryString('idea_tag', $criteria);
		$this->getDatabase()->exec($sql);

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
	 * タグクラウドを返す
	 *
	 * @access public
	 * @return BSArray タグクラウド
	 */
	public function getTagCloud () {
		$cloud = new BSArray;
		$ids = $this->getTags()->getIDs();
		foreach ($this->getProject()->getTags() as $tag) {
			$row = $tag->getAttributes();
			$row['is_selected'] = $ids->isContain($tag->getID());
			$cloud[$tag->getID()] = $row;
		}
		return $cloud;
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
		if ($this->getAttachment('attachment')) {
			$values['is_image'] = $this->isImage();
		}
		return $values;
	}
}

/* vim:set tabstop=4 */