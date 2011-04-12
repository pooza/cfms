<?php
/**
 * @package jp.co.commons.cfms
 */

/**
 * CSSキャッシュ関数
 *
 * テーマ対応
 *
 * @author 小石達也 <tkoishi@b-shock.co.jp>
 */
function smarty_function_css_cache ($params, &$smarty) {
	$params = new BSArray($params);
	if ($theme = new Theme($params['name'])) {
		$element = new BSXHTMLElement('link');
		$element->setEmptyElement(true);
		$element->setAttribute('rel', 'stylesheet');
		$element->setAttribute('charset', 'utf-8');
		$element->setAttribute('type', BSMIMEType::getType('css'));
		$element->setAttribute('href', $theme->getStyleSet()->getURL()->getContents());
		return $element->getContents();
	}
}

/* vim:set tabstop=4: */
