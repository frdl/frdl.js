<?php
  $u = ltrim($_SERVER['REQUEST_URI'], '/ ');
  $dirs = explode('/', $u);
  $p = explode('.', $dirs[count($dirs)-1], 2);
  
 
  $jsf = __DIR__.\DIRECTORY_SEPARATOR.'app.js';
  if(!file_exists($jsf)){
	file_put_contents($jsf, file_get_contents('https://domainundhomepagespeicher.webfan.de/app.js'));  
  }

  chmod($jsf, 0644);

  if('/'!==$_SERVER['REQUEST_URI'] /*&& file_exists($f) */ && 1===count($p) || (2===count($p) && 'js'===$p[1])){
	foreach([__DIR__.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'bin'.DIRECTORY_SEPARATOR.str_replace(['.', '//'], ['',''], $p[0]),
			__DIR__.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'lib'.DIRECTORY_SEPARATOR.str_replace(['.', '//'], ['',''], $p[0]),
			__DIR__.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'bin'.DIRECTORY_SEPARATOR.str_replace(['.', '//'], ['',''], $p[0]).'.'.$p[1]]  
	as $f){
	    if(!file_exists($f))continue;
		
		header('Content-Type: application/javascript');		
		$lines = file($f);
	  
	    if(substr($lines[0], 0,2) === '#!'){
		  array_shift($lines);  
	    }
	  echo implode("\n", $lines);
	  die();
	}	
  }elseif('/'===$_SERVER['REQUEST_URI'] || '/index.html'===$_SERVER['REQUEST_URI']){
	echo file_get_contents(__DIR__.\DIRECTORY_SEPARATOR.'index.html');
	die();  
  }elseif(''!==$u){
	header('HTTP/1.1 404 Not found'); 
	die(sprintf('Not found %s %s', $u, $_SERVER['REQUEST_URI']));  
  }

	header('HTTP/1.1 404 Not found'); 
	die(sprintf('Not found %s %s', $u, $_SERVER['REQUEST_URI'])); 
 