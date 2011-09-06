<?php
/**
 * Detailアクション
 *
 * @package jp.co.commons.cfms
 * @subpackage UserIdea
 * @author 小石達也 <tkoishi@b-shock.co.jp>
 */
class DetailAction extends BSRecordAction {

	/**
	 * メモリ上限を返す
	 *
	 * @access public
	 * @return integer メモリ上限(MB)、設定の必要がない場合はNULL
	 */
	public function getMemoryLimit () {
		return 256;
	}

	/**
	 * レコードのフィールド値を配列で返す
	 *
	 * @access protected
	 * @return mixed[] フィールド値の連想配列
	 */
	protected function getRecordValues () {
		return array(
			'name' => $this->request['name'],
			'name_en' => $this->request['name_en'],
			'name_read' => $this->request['name_read'],
			'body' => $this->request['body'],
		);
	}

	public function execute () {
		try {
			$this->database->beginTransaction();
			$this->getRecord()->clearImageCache('attachment');
			$this->updateRecord();
			$this->getRecord()->updateTags(TagHandler::split($this->request['tags']));
			$this->database->commit();
		} catch (Exception $e) {
			$this->database->rollBack();
			$this->request->setError($this->getTable()->getName(), $e->getMessage());
			return $this->handleError();
		}
		return $this->redirect();
	}

	public function getDefaultView () {
		$tags = new BSArray;
		foreach ($this->getRecord()->getTags() as $tag) {
			$tags[] = $tag->getName();
		}
		$this->request['tags'] = $tags->join("\n");

		$this->request->setAttribute('project', $this->getModule()->getProject());
		$this->request->setAttribute('theme', $this->getModule()->getProject()->getTheme());
		$this->request->setAttribute('accounts', $this->getModule()->getProject()->getAccounts());
		$this->request->setAttribute('tag_cloud', $this->getRecord()->getTagCloud());
		return BSView::INPUT;
	}

	public function handleError () {
		return $this->getDefaultView();
	}

	public function deny () {
		$this->user->setAttribute('requested_url', $this->request->getURL()->getContents());
		return parent::deny();
	}

	public function getCredential () {
		if ($project = $this->getModule()->getProject()) {
			return $project->getCredential();
		}
		return 'NeverMatch';
	}
}

/* vim:set tabstop=4: */
