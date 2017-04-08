<?php
/**
 * @author S. Martin
 * @link http://www.hevs.ch	
 *
 */
class errorController extends Controller {/**Object Inheritance (http://php.net/manual/en/language.oop5.inheritance.php)*/	
    /**
	 * Method that controls the page 'http404.php'
	 */
    function http404()
    {    	
        $path = parse_url(
	    	(isset($_SERVER['HTTPS']) ? 'https' : 'http') . '://' .	    	                          
	    	$_SERVER['HTTP_HOST'] .                                      
	    	$_SERVER['REQUEST_URI']
	    );
	   	    
	    $parts = explode("/", substr($path['path'], 1));	    
	    $controller = ucfirst(strtolower((@$parts[1]) ? $parts[1] : ""));		
		$method = strtolower((@$parts[2]) ? $parts[2] : "");		
				
		$this->vars['controller'] = $controller;
		$this->vars['method'] = $method;
		$this->vars['title'] = '404_error';				
    }   
}
