<?php

/**
 * Convert UTF-8 emojis to hexadecimal character references.
 *
 * PHP versions 4 and 5
 *
 * Copyright (c) 2009-2011 revulo
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to
 * deal in the Software without restriction, including without limitation the
 * rights to use, copy, modify, merge, publish, distribute, sublicense, and/or
 * sell copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING
 * FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS
 * IN THE SOFTWARE.
 *
 * @category   HTML
 * @package    HTML_Emoji
 * @author     revulo <revulon@gmail.com>
 * @copyright  2009-2011 revulo
 * @license    http://www.opensource.org/licenses/mit-license.php  MIT License
 * @version    Release: 0.8
 * @link       http://libemoji.com/html_emoji
 */

require_once dirname(__FILE__) . '/Abstract.php';

/**
 * HTML_Emoji_Filter_Utf8ToHex
 *
 * A filter converting UTF-8 emojis to hexadecimal character references.
 *
 * @category   HTML
 * @package    HTML_Emoji
 * @author     revulo <revulon@gmail.com>
 * @copyright  2009-2011 revulo
 * @license    http://www.opensource.org/licenses/mit-license.php  MIT License
 * @version    Release: 0.8
 * @link       http://libemoji.com/html_emoji
 */
class HTML_Emoji_Filter_Utf8ToHex extends HTML_Emoji_Filter_Abstract
{
    /**
     * Unicode code area of emoji (with offsets for conversion)
     * @var    array
     */
    var $_convmap = array(
        // docomo Unicode
        0xE63E, 0xE757, 0x0000, 0xFFFF,

        // au Shift_JIS
        0xEC40, 0xECFC, 0x0700, 0xFFFF,
        0xED40, 0xED93, 0x0700, 0xFFFF,
        0xEF40, 0xEFFC, 0x0700, 0xFFFF,
        0xF040, 0xF0FC, 0x0700, 0xFFFF,

        // SoftBank Unicode
        0xE001, 0xE05A, 0x0000, 0xFFFF,
        0xE101, 0xE15A, 0x0000, 0xFFFF,
        0xE201, 0xE25A, 0x0000, 0xFFFF,
        0xE301, 0xE34D, 0x0000, 0xFFFF,
        0xE401, 0xE44C, 0x0000, 0xFFFF,
        0xE501, 0xE53E, 0x0000, 0xFFFF,
    );

    /**
     * Callback function called by the filter() method.
     *
     * This function converts UTF-8 emoji to hexadecimal character reference.
     *
     * @param  array   $matches
     * @return string
     */
    function _convertUtf8ToEntity($matches)
    {
        $utf8   = $matches[0];
        $entity = mb_encode_numericentity($utf8, $this->_convmap, 'UTF-8');

        if ($utf8 !== $entity) {
            $unicode = (int)substr($entity, 2, 5);
            return '&#x' . dechex($unicode) . ';';
        } else {
            return $utf8;
        }
    }

    /**
     * Convert UTF-8 emojis to hexadecimal character references.
     *
     * @param  string  $text
     * @return string
     */
    function filter($text)
    {
        $pattern  = $this->_emoji->getRegexEmoji();
        $callback = array($this, '_convertUtf8ToEntity');
        return preg_replace_callback($pattern, $callback, $text);
    }
}
