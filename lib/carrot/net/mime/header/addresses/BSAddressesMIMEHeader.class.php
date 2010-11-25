<?php
/**
 * @package org.carrot-framework
 * @subpackage net.mime.header.addresses
 */

/**
 * 複数のメールアドレスを格納する抽象ヘッダ
 *
 * @author 小石達也 <tkoishi@b-shock.co.jp>
 * @version $Id: BSAddressesMIMEHeader.class.php 1812 2010-02-03 15:15:09Z pooza $
 * @abstract
 */
abstract class BSAddressesMIMEHeader extends BSMIMEHeader {
	private $addresses;

	/**
	 * 実体を返す
	 *
	 * @access public
	 * @return BSMailAddress 実体
	 */
	public function getEntity () {
		if (!$this->addresses) {
			$this->addresses = new BSArray;
		}
		return $this->addresses;
	}

	/**
	 * 内容を設定
	 *
	 * @access public
	 * @param mixed $contents 内容
	 */
	public function setContents ($contents) {
		$this->addresses = new BSArray;
		$this->appendContents($contents);
	}

	/**
	 * 内容を追加
	 *
	 * @access public
	 * @param string $contents 内容
	 */
	public function appendContents ($contents) {
		$addresses = $this->getEntity();
		if ($contents instanceof BSMailAddress) {
			$addresses[] = $contents;
		} else if (BSArray::isArray($contents)) {
			foreach ($contents as $address) {
				if ($address instanceof BSMailAddress) {
					$addresses[] = $address;
				} else {
					$addresses[] = BSMailAddress::getInstance($address);
				}
			}
		} else {
			$contents = BSMIMEUtility::decode($contents);
			foreach (mb_split('[;,]', $contents) as $address) {
				if ($address = BSMailAddress::getInstance($address)) {
					$addresses[] = $address;
				}
			}
		}

		$contents = new BSArray;
		foreach ($addresses as $address) {
			$contents[] = $address->format();
		}
		$this->contents = $contents->join(', ');
	}
}

/* vim:set tabstop=4: */
