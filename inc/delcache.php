<?php
if( !defined('VV_INC') ) exit(header("HTTP/1.1 403 Forbidden"));
$deltime_file=VV_DATA.'/deltime.txt';
if($v_config['deloldcache']){
	if ( is_file($deltime_file)) {
		$deltime=file_get_contents($deltime_file);
		if(($deltime+ ($v_config['delcachetime']*24*3600)) < time ()){
			$cachesize = @getRealSize(@getDirSize(VV_CACHE));
			if ($cachesize>$v_config['delcache']) @removedir(VV_CACHE);
			$deltime=time();
			write($deltime_file,$deltime);
		}
	}else{
		$cachesize = @getRealSize(@getDirSize(VV_CACHE));
		if ($cachesize>$v_config['delcache']) @removedir(VV_CACHE);
		$deltime=time();
		write($deltime_file,$deltime);
	}
}