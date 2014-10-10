<?php
/**
 * Slim Language Middleware
 *
 * MIT LICENSE
 *
 * Permission is hereby granted, free of charge, to any person obtaining
 * a copy of this software and associated documentation files (the
 * "Software"), to deal in the Software without restriction, including
 * without limitation the rights to use, copy, modify, merge, publish,
 * distribute, sublicense, and/or sell copies of the Software, and to
 * permit persons to whom the Software is furnished to do so, subject to
 * the following conditions:
 *
 * The above copyright notice and this permission notice shall be
 * included in all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND,
 * EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF
 * MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND
 * NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE
 * LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION
 * OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION
 * WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
 */
namespace Mnlg\Middleware;

/**
 * Language Middleware
 *
 * Parse the Accept-Language header and convert it into an array sorted by language preference.
 */
class Language extends \Slim\Middleware
{
    /**
     * Call
     */
    public function call()
    {
        $languageHeader = explode(',', $this->app->request()->headers('Accept-Language', 'en-US'));

        $languages = array(); 
        foreach($languageHeader as $lang){
          $name = preg_replace('/([^;]+);.*$/', '${1}', $lang);
          $q = preg_replace('/^[^q]*q=([^\,]+)*$/', '${1}', $lang);
          $q = is_numeric($q) ? floatval($q) : 1.0; 
          $languages[$name] = $q;
        }
        array_multisort($languages, SORT_DESC , SORT_NATURAL);

        $this->app->acceptLanguages = $languages;
        $this->next->call();
    }
}
