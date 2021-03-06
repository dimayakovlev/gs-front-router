<?php

/**
 * @package FrontRouter
 * @subpackage URL
 */
class FrontRouterURL {
  /**
   * Gets the root URL (@SITEURL)
   *
   * @return string
   */
  static function getSiteURL() {
    $pretty  = (string) $GLOBALS['PRETTYURLS'];
    $root    = $GLOBALS['SITEURL'] . (empty($pretty) ? 'index.php' : null);
    return $root;
  }

  /**
   * Get URL relative to the domain
   *
   * @return string
   */
  static function getRelativePageURL($showQuery = false) {
    $pretty  = (string) $GLOBALS['PRETTYURLS'];
    $root    = self::getSiteURL() . (empty($pretty) ? '?id=' : null);

    return self::getCurrentPageURL($root, $showQuery);
  }

  /**
   * Get the current page's full URL
   * https://css-tricks.com/snippets/php/get-current-page-url/
   *
   * @param string|bool $root Root string to shave off (i.e. domain)
   * @return string
   */
  static function getCurrentPageURL($root = false, $showQuery = false) {
    // Get the full canonical URL
    $url  = self::getURLProtocol() . '://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];

    // Remove the protocol from the current url and root
    $url = strstr($url, '//');
    $root = $root ? strstr($root, '//') : '';

    // Shave off the root
    $url = str_replace($root, '', $url);

    // Remove the query parameters
    if (!$showQuery) {
      $split = explode('?', $url);
      $url   = $split[0];
    }

    // Shave off trailing slashes and double slashes
    $url = ltrim($url, '/');
    $url = rtrim($url, '/');
    $url = preg_replace('~/+~', '/', $url); // http://stackoverflow.com/questions/2217759/regular-expression-replace-multiple-slashes-with-only-one

    return $url;
  }

  /**
   * Gets the URL protocol (http/https)
   *
   * @return string http or https
   */
  private static function getURLProtocol() {
    return  'http' . (@($_SERVER['HTTPS'] != 'on') ? 's' : null);
  }
}