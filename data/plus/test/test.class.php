<?php
if(!defined('VV_PLUS')){
	exit('Access Denied');
}
/*
ȫ�ֱ���˵����

$GLOBALS['urlext']   ->  url��׺�����磺php��gif
$GLOBALS['geturl']   ->  ��ǰ��Ŀ��վurl
$GLOBALS['html']     ->  ����ҳ���html����

ע�����Ӳ���Ҫreturn��ֱ�Ӹı���ֵ����

*/
class test{
	public $config;
	public $config_file;
	//�����Ϣ
    public $info=array(
        'name' => '���Բ��',
        'info' => '���Բ��˵����',
        'status' => 1,
        'author' => '����',
        'version' => '1.0',
    );
	//��ʼ������
	public function init(){
		$this->config_file=dirname(__FILE__).'/config.php';
		if(is_file($this->config_file)){
			$this->config=require($this->config_file);
		}
	}
	//�ɼ�֮ǰִ��
	public function before_get(){
		
	}
	//����ԭʼhtml
	public function source(){
		$GLOBALS['html']=$GLOBALS['html'];
	}

	//������ǰ��html
	public function before_cache(){

	}

	//��������html
	public function end(){

	}
}
?>