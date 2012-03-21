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
	if (BSString::isBlank($params['name'])) {
		$params['name'] = 'default';
	}
	if ($theme = new Theme($params['name'])) {
		return $theme->getStyleSet()->createElement()->getContents();
	}
}

/* vim:set tabstop=4: */
