<?php
if(!defined('VV_PLUS')){
	exit('Access Denied');
}
/*
全局变量说明：

$GLOBALS['urlext']   ->  url后缀名，如：php，gif
$GLOBALS['geturl']   ->  当前的目标站url
$GLOBALS['html']     ->  整个页面的html代码

注：钩子不需要return，直接改变量值即可

*/
class test{
	public $config;
	public $config_file;
	//插件信息
    public $info=array(
        'name' => '测试插件',
        'info' => '测试插件说明！',
        'status' => 1,
        'author' => '作者',
        'version' => '1.0',
    );
	//初始化参数
	public function init(){
		$this->config_file=dirname(__FILE__).'/config.php';
		if(is_file($this->config_file)){
			$this->config=require($this->config_file);
		}
	}
	//采集之前执行
	public function before_get(){
		
	}
	//处理原始html
	public function source(){
		$GLOBALS['html']=$GLOBALS['html'];
	}

	//处理缓存前的html
	public function before_cache(){

	}

	//处理最终html
	public function end(){

	}
}
?>