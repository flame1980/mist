<?php

namespace mist\mist\library;

use mist\mist\Exception;

if (!defined('DS')) {
    define('DS', DIRECTORY_SEPARATOR);
}

/**
* YAMLファイルから値を取得するクラス
*
* @package mist.mist
*/
class Yaml
{

    /**
     * YAMLファイルの拡張子
     */
    const EXTENSION = '.yml';

    /**
     * YAMLファイルのディレクトリ
     */
    private static $instance;

    /**
     * YAMLファイルのディレクトリ
     */
    protected $ymlDir;

    /**
     * YAMLデータ保持用
     */
    protected $datas;

    /**
     * __construct
     *
     * @access public
     * @param none
     * @return none
     */
    public function __construct()
    {
        $this->init();
    }

    /**
     * getInstance
     *
     * @return object instance
     */
    public static function getInstance()
    {
        if (!self::$instance) {
            self::$instance = new self;
        }
        return self::$instance;
    }

    /**
     * init
     *
     * @access public
     * @param string $ymlName YAML名
     * @return none
     */
    public function init()
    {
        $this->datas = array();
        $this->ymlDir = dirname(dirname(__FILE__)).DS."config";
    }

    /**
     * YAMLファイルから値を取得
     *
     * @access public
     * @param string 取得するYAMLファイル名（拡張子なし）
     * @param 第二引数以降は、取得したい項目を記載
     * @return mixed 値
     */
    public function get()
    {
        $args = func_get_args();
        return call_user_func_array(array($this, 'getData'), $args);
    }

    /**
     * YAMLファイルのディレクトリを変更
     *
     * @access public
     * @param string $dir ディレクトリパス
     * @return none
     */
    public function setYmlDir($ymlDir)
    {
        $this->ymlDir = $ymlDir;
    }

    /**
     * YAMLファイルから値を取得する内部関数
     *
     * @access protected
     * @param string 取得するYAMLファイル名（拡張子なし）
     * @param 第二引数以降は、取得したい項目を記載
     * @return mixed 値
     */
    protected function getData()
    {
        $args = func_get_args();
        if (count($args) < 1) {
            throw new Exception('パラメータの数が不正です');
        }
        $name = array_shift($args);

        $ret = null;
        if (!isset($this->datas[$name])) {
            $file = $this->ymlDir.DS.$name.self::EXTENSION;
            if (!file_exists($file)) {
                throw new Exception\LogicException("YAMLファイルが見つかりません({$file})");
            }
            $this->datas[$name] = $this->parse($file);
        }
        $ret = $this->datas[$name];
        foreach ($args as $key) {
            if (!array_key_exists($key, $ret)) {
                $ret = null;
                break;
            }
            $ret = $ret[$key];
        }
        return $ret;
    }

    /**
     * YAMLファイルをパースする
     *
     * @access protected
     * @param string $file YAMLファイルパス
     * @return array YAMLをパースした配列
     */
    protected function parse($file)
    {
        if (!file_exists($file)) {
            throw new Exception\LogicException("YAMLファイルが見つかりません({$file})");
        }
        if (function_exists('yaml_parse_file')) {
            return yaml_parse_file($file);
        } else {
            return \Spyc::YAMLLoad($file);
        }
    }

}
