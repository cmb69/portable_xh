<?php

/**
 * router.php
 *
 * Simple router script for PHP's built-in webserver.
 *
 * Copyright 2014 Christoph M. Becker <http://3-magi.net/>
 *
 * $Id$
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

/*
 * Work around a bug in the webserver (<https://bugs.php.net/bug.php?id=66711>).
 */
if ($_SERVER['PHP_SELF'] == '/index.php/') {
    $_SERVER['PHP_SELF'] = '/index.php';
}

/*
 * Adds a trailing slash to request URLs if appropriate.
 */
$parts = parse_url($_SERVER['REQUEST_URI']);
if (isDirWithoutTrailingSlash($parts['path'])) {
    header("Location: http://localhost:8080$parts[path]/");
} else {
    return false;
}

?>
