<?php
/**
 * Created by PhpStorm.
 * User: ec
 * Date: 03.07.2015
 * Time: 13:15
 */

namespace bpteam\HttpHeader;

use \PHPUnit_Framework_TestCase;
use \ReflectionClass;

class HttpHeaderTest extends PHPUnit_Framework_TestCase
{
    public static $name;

    public static function setUpBeforeClass()
    {
        self::$name = 'unit_test';
    }

    /**
     * @param        $name
     * @param string $className
     * @return \ReflectionMethod
     */
    protected static function getMethod($name, $className = 'bpteam\HttpHeader\HttpHeader')
    {
        $class = new ReflectionClass($className);
        $method = $class->getMethod($name);
        $method->setAccessible(true);
        return $method;
    }

    /**
     * @param        $name
     * @param string $className
     * @return \ReflectionProperty
     */
    protected static function getProperty($name, $className = 'bpteam\HttpHeader\HttpHeader')
    {
        $class = new ReflectionClass($className);
        $property = $class->getProperty($name);
        $property->setAccessible(true);
        return $property;
    }

    function testCheckMimeType(){
        $http = new HttpHeader();
        $this->assertTrue($http->checkMimeType('audio/mpeg', 'file'));
        $this->assertTrue($http->checkMimeType('image/png', 'img'));
        $this->assertTrue($http->checkMimeType('text/html', 'html'));
        $this->assertFalse($http->checkMimeType('image/png', 'html'));
    }

}