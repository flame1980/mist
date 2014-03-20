<?php

namespace mist\mist;

class mistTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var mist
     */
    protected $skeleton;

    protected function setUp()
    {
        $this->skeleton = new mist;
    }

    public function testNew()
    {
        $actual = $this->skeleton;
        $this->assertInstanceOf('\mist\mist\mist', $actual);
    }

    /**
     * @expectedException \mist\mist\Exception\LogicException
     */
    public function testException()
    {
        throw new Exception\LogicException;
    }
}
