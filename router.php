<?php

/**
 * router.php
 *
 * Simple router script for PHP's built-in webserver.
 *
 * Copyright (c) 2012-2021 Christoph M. Becker <http://3-magi.net/>
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 */

/**
 * Returns an array of direct subfolders of the webroot.
 *
 * @return array
 */
function subfolders()
{
    $result = array();
    $dir = opendir('./www');
    if ($dir) {
        while (($entry = readdir($dir)) !== false) {
            if ($entry[0] != '.' && is_dir("./www/$entry")) {
                $result[] = $entry;
            }
        }
    }
    natcasesort($result);
    return $result;
}

/**
 * Returns whether the requested path points to a directory, but the trailing
 * slash is missing.
 *
 * @param string $path A path.
 *
 * @return bool
 */
function isDirWithoutTrailingSlash($path)
{
    $filename = "./www$path";
    return is_dir($filename) && !preg_match('/\/$/', $filename);
}

/**
 * Returns whether the webroot is requested, but there's neither index.php nor
 * index.html.
 *
 * @return bool
 */
function isRootRequestedButIndexIsMissing()
{
    return $_SERVER['REQUEST_URI'] == '/'
        && !is_file('./www/index.php')
        && !is_file('./www.index.html');
}

/*
 * Works around a bug in the webserver (<https://bugs.php.net/bug.php?id=66711>).
 */
if (preg_match('/\/index\.(php|html)\/$/', $_SERVER['PHP_SELF'])) {
    $_SERVER['PHP_SELF'] = substr($_SERVER['PHP_SELF'], 0, -1);
}

if (!isset($_SERVER["QUERY_STRING"])) {
    $_SERVER["QUERY_STRING"] = "";
}

/*
 * Per-define a fake XH_isAccessProtected(), if the portable_xh_helper extension
 * is available, because the function defined in adminfuncs.php blocks on the
 * built-in webserver.
 */
if (extension_loaded('portable_xh_helper')) {
    function XH_isAccessProtected()
    {
        return true;
    }
}

/*
 * Delivers a menu page, if the webroot is requested and there is neither
 * index.php nor index.html.
 */
if (isRootRequestedButIndexIsMissing()) {
    include './menu.php';
    exit;
}

$parts = parse_url($_SERVER['REQUEST_URI']);
if (!file_exists("./www{$parts['path']}")) {
    // Non existent resources should respond with 404
    // Work around PHP issue #75061
    header('HTTP/1.1 404 Not found');
    exit;
} elseif (isDirWithoutTrailingSlash($parts['path'])) {
    // Add trailing slash to requested folder
    header("Location: http://localhost:8080$parts[path]/");
} else {
    return false;
}
