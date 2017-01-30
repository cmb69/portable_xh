<?php

/**
 * UTF-8 related string functions.
 *
 * PHP version 5
 *
 * @category  CMSimple_XH
 * @package   XH
 * @author    Harry Fuecks <hfuecks@gmail.com>
 * @author    The CMSimple_XH developers <devs@cmsimple-xh.org>
 * @copyright 2006-2007 Harry Fuecks
 * @copyright 2009-2016 The CMSimple_XH developers <http://cmsimple-xh.org/?The_Team>
 * @license   http://www.gnu.org/licenses/gpl-3.0.en.html GNU GPLv3
 * @link      http://cmsimple-xh.org/
 */

/**
 * Returns the number of Unicode code points in a string.
 *
 * Note: this function does not count bad bytes in the string - these
 * are simply ignored.
 *
 * @param string $string A UTF-8 encoded string.
 *
 * @return int
 */
// @codingStandardsIgnoreStart
function utf8_strlen($string)
{
// @codingStandardsIgnoreEnd
    return mb_strlen($string, 'UTF-8');
}

/**
 * Returns part of a string given character offset and optionally length.
 *
 * @param string $string A UTF-8 encoded string.
 * @param int    $offset A number of UTF-8 code points offset.
 * @param int    $length A length in UTF-8 code points from offset
 *
 * @return string
 */
// @codingStandardsIgnoreStart
function utf8_substr($string, $offset, $length = null)
{
// @codingStandardsIgnoreEnd
    return mb_substr($string, $offset, $length, 'UTF-8');
}

/**
 * Makes a string lowercase.
 *
 * Note: The concept of a characters "case" only exists is some alphabets
 * such as Latin, Greek, Cyrillic, Armenian and archaic Georgian - it does
 * not exist in the Chinese alphabet, for example. See Unicode Standard
 * Annex #21: Case Mappings.
 *
 * @param string $string A UTF-8 encoded string.
 *
 * @return string
 */
// @codingStandardsIgnoreStart
function utf8_strtolower($string)
{
// @codingStandardsIgnoreEnd
    return mb_strtolower($string, 'UTF-8');
}

/**
 * Makes a string uppercase.
 *
 * Note: The concept of a characters "case" only exists is some alphabets
 * such as Latin, Greek, Cyrillic, Armenian and archaic Georgian - it does
 * not exist in the Chinese alphabet, for example. See Unicode Standard
 * Annex #21: Case Mappings.
 *
 * @param string $string A UTF-8 encoded string.
 *
 * @return string
 */
// @codingStandardsIgnoreStart
function utf8_strtoupper($string)
{
// @codingStandardsIgnoreEnd
    return mb_strtoupper($string, 'UTF-8');
}

/**
 * Finds position of first occurrence of a string within another, case
 * sensitive. Returns <var>false</var> if needle is not found.
 *
 * @param string $haystack A haystack.
 * @param string $needle   A needle.
 * @param int    $offset   An offset in Unicode code points.
 *
 * @return int
*/
// @codingStandardsIgnoreStart
function utf8_strpos($haystack, $needle, $offset = 0)
{
// @codingStandardsIgnoreEnd
    return mb_strpos($haystack, $needle, $offset, 'UTF-8');
}

/**
 * Finds position of first occurrence of a string within another, case
 * insensitive. Returns <var>false</var> if needle is not found.
 *
 * @param string $haystack A haystack.
 * @param string $needle   A needle.
 * @param int    $offset   An offset in Unicode code points.
 *
 * @return int
 */
// @codingStandardsIgnoreStart
function utf8_stripos($haystack, $needle, $offset = 0)
{
// @codingStandardsIgnoreEnd
    return mb_stripos($haystack, $needle, $offset, 'UTF-8');
}

/**
 * Makes a string's first character uppercase.
 *
 * @param string $string A UTF-8 encoded string.
 *
 * @return string
 */
// @codingStandardsIgnoreStart
function utf8_ucfirst($string)
{
// @codingStandardsIgnoreEnd
    switch (utf8_strlen($string)) {
    case 0:
        return '';
        break;
    case 1:
        return utf8_strtoupper($string);
        break;
    default:
        preg_match('/^(.{1})(.*)$/us', $string, $matches);
        return utf8_strtoupper($matches[1]) . $matches[2];
        break;
    }
}

/**
 * Tests a string as to whether it's valid UTF-8 and supported by the
 * Unicode standard.
 *
 * @param string $string A UTF-8 encoded string.
 *
 * @return boolean
 */
// @codingStandardsIgnoreStart
function utf8_is_valid($string)
{
// @codingStandardsIgnoreEnd
    if (strlen($string) == 0) {
        return true;
    }
    // If even just the first character can be matched, when the /u
    // modifier is used, then it's valid UTF-8. If the UTF-8 is somehow
    // invalid, nothing at all will match, even if the string contains
    // some valid sequences
    return (bool) preg_match('/^.{1}/us', $string);
}

/**
 * Replace bad bytes with an alternative character - ASCII character
 * recommended is replacement char.
 *
 * PCRE Pattern to locate bad bytes in a UTF-8 string
 * Comes from W3 FAQ: Multilingual Forms.
 *
 * Note: modified to include full ASCII range including control chars
 *
 * @param string $string  A string to search.
 * @param string $replace A string to replace bad bytes with - use ASCII.
 *
 * @return string
 *
 * @see http://www.w3.org/International/questions/qa-forms-utf-8
 */
// @codingStandardsIgnoreStart
function utf8_bad_replace($string, $replace = '?')
{
// @codingStandardsIgnoreEnd
    $bad = '([\x00-\x7F]'                      // ASCII (including control chars)
        . '|[\xC2-\xDF][\x80-\xBF]'            // non-overlong 2-byte
        . '|\xE0[\xA0-\xBF][\x80-\xBF]'        // excluding overlongs
        . '|[\xE1-\xEC\xEE\xEF][\x80-\xBF]{2}' // straight 3-byte
        . '|\xED[\x80-\x9F][\x80-\xBF]'        // excluding surrogates
        . '|\xF0[\x90-\xBF][\x80-\xBF]{2}'     // planes 1-3
        . '|[\xF1-\xF3][\x80-\xBF]{3}'         // planes 4-15
        . '|\xF4[\x80-\x8F][\x80-\xBF]{2}'     // plane 16
        . '|(.{1}))';                          // invalid byte
    $result = '';
    while (preg_match('/' . $bad . '/S', $string, $matches)) {
        if (!isset($matches[2])) {
            $result .= $matches[0];
        } else {
            $result .= $replace;
        }
        $string = substr($string, strlen($matches[0]));
    }
    return $result;
}

?>
