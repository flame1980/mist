<?php

namespace mist\mist\library;

use mist\mist\Exception;

class YamlTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var CsvConverter
     */
    protected $skeleton;

    protected function setUp()
    {
        $this->skeleton = Yaml::getInstance();
    }

    /**
     * @test
     */
    public function testNew()
    {
        $actual = $this->skeleton;
        $this->assertInstanceOf('\mist\mist\library\Yaml', $actual);
    }

    /**
     * @test
     */
    public function 読み込みテスト_yml丸ごと_正常系()
    {
        $actual = $this->skeleton->get('test');
        $expected = [
            'name' => 'test',
            'columns' => [
                'value1' => ['name' => 'value1', 'value' => 1],
                'value2' => ['name' => 'value2', 'value' => 2],
            ],
        ];
        $this->assertEquals($expected, $actual);
    }

    /**
     * @test
     */
    public function 読み込みテスト_1項目取得_正常系()
    {
        $actual = $this->skeleton->get('test', 'name');
        $expected = 'test';
        $this->assertEquals($expected, $actual);
    }

    /**
     * @test
     */
    public function 読み込みテスト_配列項目取得_正常系()
    {
        $actual = $this->skeleton->get('test', 'columns');
        $expected = [
                'value1' => ['name' => 'value1', 'value' => 1],
                'value2' => ['name' => 'value2', 'value' => 2],
        ];
        $this->assertEquals($expected, $actual);
    }

    /**
     * @test
     */
    public function 読み込みテスト_2階層目取得_正常系()
    {
        $actual = $this->skeleton->get('test', 'columns', 'value1');
        $expected = ['name' => 'value1', 'value' => 1];
        $this->assertEquals($expected, $actual);

        $actual = $this->skeleton->get('test', 'columns', 'value2');
        $expected = ['name' => 'value2', 'value' => 2];
        $this->assertEquals($expected, $actual);
    }

    /**
     * @expectedException \mist\mist\Exception\LogicException
     */
    public function 読み込みテスト_ymlファイルがない場合_異常系()
    {
        $this->skeleton->init('test2');
    }

    /**
     * @expectedException \mist\mist\Exception\LogicException
     */
    public function testException()
    {
        throw new Exception\LogicException;
    }
}
