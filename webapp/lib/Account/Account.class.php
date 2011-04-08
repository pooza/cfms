<?php
/**
 * @package jp.co.commons.cfms
 */

/**
 * アカウントレコード
 *
 * @author 小石達也 <tkoishi@b-shock.co.jp>
 * @version $Id$
 */
class Account extends BSRecord implements BSUserIdentifier {
	private $projects;
	private $credentials;

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
		$values = new BSArray($values);
		if (BSString::isBlank($values['password'])) {
			$values->removeParameter('password');
		} else {
			$values['password'] = BSCrypt::getDigest($values['password']);
		}
		parent::update($values, $flags);
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
	 * プロジェクトを返す
	 *
	 * @access public
	 * @return ProjectHandler プロジェクト
	 */
	public function getProjects () {
		if (!$this->projects) {
			$criteria = $this->createCriteriaSet();
			$criteria->register('account_id', $this);
			$sql = BSSQL::getSelectQueryString('project_id', 'account_project', $criteria);

			$ids = new BSArray;
			foreach ($this->getDatabase()->query($sql) as $row) {
				$ids[] = $row['project_id'];
			}

			$this->projects = new ProjectHandler;
			$this->projects->getCriteria()->register('id', $ids);
		}
		return $this->projects;
	}

	/**
	 * プロジェクトとの紐づけを更新
	 *
	 * @access public
	 * @params Project $project プロジェクト
	 * @params boolean $status 状態
	 */
	public function updateProjectStatus (Project $project, $status) {
		if (!!$status) {
			$values = new BSArray;
			$values['account_id'] = $this->getID();
			$values['project_id'] = $project->getID();
			$sql = BSSQL::getInsertQueryString('account_project', $values);
		} else {
			$criteria = $this->createCriteriaSet();
			$criteria->register('account_id', $this);
			$criteria->register('project_id', $project);
			$sql = BSSQL::getDeleteQueryString('account_project', $criteria);
		}
		$this->getDatabase()->exec($sql);

		$this->projects = null;
		$this->touch();
	}

	/**
	 * メールアドレスを返す
	 *
	 * @access public
	 * @return BSMailAddress メールアドレス
	 */
	public function getMailAddress () {
		return BSMailAddress::create($this['email']);
	}

	/**
	 * ユーザーIDを返す
	 *
	 * @access public
	 * @return string ユーザーID
	 */
	public function getUserID () {
		return $this->getID();
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
	 * 認証
	 *
	 * @access public
	 * @params string $password パスワード
	 * @return boolean 正しいユーザーならTrue
	 */
	public function auth ($password = null) {
		return ($this->isVisible()
			&& (BSCrypt::getDigest($password) == $this['password'])
		);
	}

	/**
	 * 認証時に与えられるクレデンシャルを返す
	 *
	 * @access public
	 * @return BSArray クレデンシャルの配列
	 */
	public function getCredentials () {
		if (!$this->credentials) {
			$this->credentials = new BSArray;
			$this->credentials[] = 'User';
			foreach ($this->getProjects() as $project) {
				$this->credentials[] = $project->getCredential();
			}
		}
		return $this->credentials;
	}

	/**
	 * ラベルを返す
	 *
	 * @access public
	 * @param string $language 言語
	 * @return string ラベル
	 */
	public function getLabel ($language = 'ja') {
		$label = new BSArray;
		foreach (array('company', 'name') as $name) {
			foreach (array(null, '_' . $language) as $suffix) {
				if (!BSString::isBlank($value = $this[$name . $suffix])) {
					$label[] = $value;
				}
			}
		}
		return $label->join(' ');
	}
}

/* vim:set tabstop=4 */