<?php
/**
 * @package org.carrot-framework
 * @subpackage service.google
 */

/**
 * YouTubeクライアント
 *
 * @author 小石達也 <tkoishi@b-shock.co.jp>
 */
class BSYouTubeService extends BSCurlHTTP {
	private $useragent;
	const DEFAULT_HOST = 'www.youtube.com';

	/**
	 * @access public
	 * @param BSHost $host ホスト
	 * @param integer $port ポート
	 */
	public function __construct (BSHost $host = null, $port = null) {
		if (!$host) {
			$host = new BSHost(self::DEFAULT_HOST);
		}
		parent::__construct($host, $port);
		$this->useragent = BSRequest::getInstance()->getUserAgent();
	}

	/**
	 * 対象UserAgentを設定
	 *
	 * @access public
	 * @param BSUserAgent $useragent 対象UserAgent
	 */
	public function setUserAgent (BSUserAgent $useragent) {
		$this->useragent = $useragent;
	}

	/**
	 * 要素を返す
	 *
	 * @access public
	 * @param integer $id ビデオID
	 * @param BSParameterHolder $params パラメータ配列
	 * @return BSDivisionElement
	 */
	public function getElement ($id, BSParameterHolder $params = null) {
		$params = new BSArray($params);
		if ($this->useragent->isMobile()) {
			if (BSString::isBlank($params['label'])) {
				$params['label'] = '動画再生';
			}
			$element = new BSAnchorElement;
			$element->setAttribute('target', '_blank');
			$element->setBody($params['label']);
			$element->setURL(self::getURL($id, $this->useragent));
		} else {
			$params->removeParameter('label');
			$info = $this->useragent->getDisplayInfo();
			if ($info['width'] && $params['width'] && ($info['width'] < $params['width'])) {
				$params['width'] = $info['width'];
			}
			$element = new BSYouTubeObjectElement;
			$element->setUserAgent($this->useragent);
			$element->setMovie($id, $params);
			$element->setAttribute('width', $params['width']);
			$element->setAttribute('height', $params['height']);
			if ($params['align']) {
				$element->setStyle('width', $params['width']);
				$element = $element->setAlignment($params['align']);
			}
		}
		return $element;
	}

	/**
	 * サイトを直接開くURLを返す
	 *
	 * @access public
	 * @param integer $id ビデオID
	 * @param string BSUserAgent $useragent 対象ブラウザ
	 * @return BSHTTPURL
	 * @static
	 */
	static public function getURL ($id, BSUserAgent $useragent = null) {
		if (!$useragent) {
			$useragent = BSRequest::getInstance()->getUserAgent();
		}

		$url = BSURL::getInstance();
		if ($useragent->isMobile()) {
			$url['host'] = 'm.youtube.com';
		} else {
			$url['host'] = self::DEFAULT_HOST;
		}
		$url['path'] = '/watch';
		$url->setParameter('v', $id);

		return $url;
	}
}

/* vim:set tabstop=4: */