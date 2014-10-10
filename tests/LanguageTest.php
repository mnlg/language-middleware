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

class LanguageTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Test Language middleware without Accept-Language header
     */
    public function testLanguageWithoutHeader()
    {
        \Slim\Environment::mock(array(
            'SCRIPT_NAME' => '/index.php',
            'PATH_INFO' => '/'
        ));
        $app = new \Slim\Slim(array());
        $app->get('/', function () { });
        $mw = new \Mnlg\Middleware\Language();
        $mw->setApplication($app);
        $mw->setNextMiddleware($app);
        $mw->call();
        $this->assertEquals($app->acceptLanguages, array('en-US'=>1.0));
    }

    /**
     * Test Language middleware with Accept-Language header
     */
    public function testLanguageHeader()
    {
        \Slim\Environment::mock(array(
            'HTTP_ACCEPT_LANGUAGE' => 'en-US,en;q=0.8,es;q=0.6'
        ));
        $app = new \Slim\Slim(array());
        $app->get('/', function () { });
        $mw = new \Mnlg\Middleware\Language();
        $mw->setApplication($app);
        $mw->setNextMiddleware($app);
        $mw->call();
        $this->assertEquals($app->acceptLanguages, array('en-US'=>1.0, 'en'=>0.8, 'es'=>0.6));
    }
}
