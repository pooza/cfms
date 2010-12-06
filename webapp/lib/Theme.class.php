<?php
/**
 * @package jp.co.commons.cfms
 */

/**
 * テーマ
 *
 * @author 小石達也 <tkoishi@b-shock.co.jp>
 * @version $Id$
 */
class Theme implements BSAssignable {
	protected $name;
	protected $file;
	static private $names;

	/**
	 * @access public
	 */
	public function __construct ($name = 'default') {
		$this->name = $name;
	}

	/**
	 * テーマ名を返す
	 *
	 * @access public
	 * @return string テーマの名前
	 */
	public function getName () {
		return $this->name;
	}

	/**
	 * CSSファイルを返す
	 *
	 * @access public
	 * @return BSCSSFile CSSファイル
	 */
	public function getFile () {
		if (!$this->file) {
			$this->file = BSFileUtility::getDirectory('themes')->getEntry($this->getName());
		}
		return $this->file;
	}

	/**
	 * アサインすべき値を返す
	 *
	 * @access public
	 * @return mixed アサインすべき値
	 */
	public function getAssignValue () {
		return new BSArray(array(
			'name' => $this->getName(),
		));
	}

	/**
	 * @access public
	 * @return string 基本情報
	 */
	public function __toString () {
		return sprintf('テーマ "%s"', $this->name);
	}

	/**
	 * テーマ名の配列を返す
	 *
	 * @access public
	 * @return BSArray テーマ名
	 * @static
	 */
	static public function getNames () {
		if (!self::$names) {
			self::$names = new BSArray;
			foreach (BSFileUtility::getDirectory('themes') as $entry) {
				if (!$entry->isIgnore()) {
					self::$names[$entry->getBaseName()] = $entry->getBaseName();
				}
			}
		}
		return self::$names;
	}
}

/* vim:set tabstop=4: */
