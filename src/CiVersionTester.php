<?php namespace CiVersionTester;

class CiVersionTests 
{
    
    public function __construct()
    {
	    $this->url			= 'http://localhost:8080/codeigniter-version-detect/test/';
        $this->all_versions = array('1.0b', '1.1b', '1.2', '1.3', '1.3.1', '1.3.2', '1.3.3', '1.4.1',
                                    '1.5.1', '1.5.2', '1.5.3', '1.5.4', '1.6.0', '1.6.1', '1.6.2', '1.6.3',
                                    '1.7.0', '1.7.1', '1.7.2', '1.7.3', '2.0.0', '2.0.1', '2.0.2', '2.0.3',
                                    '2.1.0', '2.1.1', '2.1.2', '2.1.3', '2.1.4', '2.2.1',
                                    '3.0rc', '3.0rc2', '3.0rc3');
        $this->versions_left = $this->all_versions;
    }
    
    private function get_http_response_code($url)
    {
    	$headers = get_headers($url);
		return intval(substr($headers[0], 9, 3));
	}
	
    private function highlightkeyword($str, $search)
    {
        $occurrences = substr_count(strtolower($str), strtolower($search));
        $newstring = $str;
        $match = array();
        
        for ($i=0; $i<$occurrences; ++$i) {
            $match[$i] = stripos($str, $search, $i);
            $match[$i] = substr($str, $match[$i], strlen($search));
            $newstring = str_replace($match[$i], '[#]' . $match[$i] . '[@]', strip_tags($newstring));
        }
        
        $newstring = str_replace('[#]', '<span style="background:green;color:white;">', $newstring);
        $newstring = str_replace('[@]', '</span>', $newstring);
        return $newstring;
    }
    
    public function test($function, $testedVersion)
    {
        echo '<tr><td style="width:150px">', $function,
        	 '</td><td><pre>',
			 $this->highlightkeyword(print_r($this->$function(), true), '=> ' . $testedVersion . "\n"),
			 '</pre></tr></tr>';
    }
    
    public function user_guide_version()
    {
        $return     = false;
        $url        = $this->url . 'user_guide/';
        if ($this->get_http_response_code($url) !== 200)
        {               
            return $return;
        }

        $response = file_get_contents($url, true);
        # check version < 3.0rc
        preg_match('/h1(.*)</', $response, $m);
        if (substr($m[1], 0, 11) === '>Code Ignit' || substr($m[1], 0, 11) === '>CodeIgnite')
        {
            # version found in user_guide
            $version    = trim(strip_tags(str_replace(array('>Code Igniter User Guide Version', '>CodeIgniter User Guide Version'), '', $m[1])));	
            $return     = $version;
            if($version == '1.0'){ $return = '1.0b'; }
            if($version == 'Beta 1.1'){ $return = '1.1b'; }
        }
        
        # check version == 3.0rc
        preg_match('/Jan 26, 2015/', $response, $m);
        if (count($m)>0) { $return  = '3.0rc'; }
        
        # check version == 3.0rc2
        preg_match('/Feb 03, 2015/', $response, $m);
        if (count($m)>0) { $return  = '3.0rc2'; }
        
        # check version == 3.0rc3
        preg_match('/Mar 10, 2015/', $response, $m);
        if (count($m)>0) { $return  = '3.0rc3'; }
        
        $return = array($return);
        $this->versions_left = $return;
        
        return $return;
    }
    
    public function application_folder()
    {
        $return     = false;
        $url        = $this->url . 'application/';
        $possibleV  = $this->all_versions;
        
        if ($this->get_http_response_code($url) === 403)
        {
            # version 2.0.0 or higher
            $ak         = array_search('2.0.0', $possibleV);
            $return     = array_splice($possibleV, $ak);
            $this->versions_left = $return;
            return $return;
        }
        
        # version 1.7.3 or lower
        $ak         = array_search('1.7.3', $possibleV);
        $return     = array_splice($possibleV, 0, $ak+1);
        $this->versions_left = $return;
        
        return $return;
    }

    public function libraries_calendar()
    {
        $url = $this->url . 'system/libraries/Calendar.php';
        if ($this->get_http_response_code($url) === 404)
        {
            return array('1.0b');
        }
        
        return false;
    }
    
    public function controllers_index_html()
    {
        $return     = false;
        $url        = $this->url . 'system/application/controllers/index.html';
                                
        if ($this->get_http_response_code($url) === 404)
        {
            # version 2.0.0 or higher
			$possibleV  = $this->all_versions;
            $ak         = array_search('1.2', $possibleV);
            $return     = array_splice($possibleV, 0, $ak);
            $this->versions_left = $return;
        }
        
        return $return;
    }
    
    public function models_index_html()
    {
        $return     = false;
        $url        = $this->url . 'system/application/models/index.html';

        if ($this->get_http_response_code($url) === 404)
        {
            // if /system/application/models/index.html exists Version 1.3 or higher
			$possibleV  = $this->all_versions;
            $ak         = array_search('1.2', $possibleV);
            $return     = array_splice($possibleV, 0, $ak + 1);
            $this->versions_left = $return;
        }
        return $return;
    }
    
    public function license_txt()
    {
        $return     = false;
        $url        = $this->url . 'license.txt';
        
        // match pMachine = 1.5.2 or lower, match EllisLab = 1.5.3 or higher
        if ($this->get_http_response_code($url) !== 200)
        {
            return $return; 
        }
        
        $possibleV = $this->all_versions;
        $response = file_get_contents($url, true);

        file_get_contents($url, true);
        preg_match('/EllisLab/', $response, $m);
        if ($m){
            $ak         = array_search('1.5.3', $possibleV);
            $return     = array_splice($possibleV, $ak);
            $this->versions_left = $return;
            return $return; 
        }
        
        preg_match('/pMachine/', $response, $n);
        if ($n){
            $ak         = array_search('1.5.2', $possibleV);
            $return     = array_splice($possibleV, 0, $ak+1);
            $this->versions_left = $return;
        }
        
        return $return; 
    }
    
    /*public function system_init_unit_test()
    {
        //$return   = $this->versions_left;
        $return     = 0;
        $url        = $this->url . 'system/init/init_unit_test.php';
        $response   = file_get_contents($url, true);
        $headers    = $http_response_header[0];
        //$possibleV    = $this->versions_left;
        $possibleV  = $this->all_versions;
            // als system/init/init_unit_test.php bestaat is het versie 1.3.1 of hoger
            if($http_response_header[0] === 'HTTP/1.1 404 Not Found')
            {
                //echo 'CodeIgniter version 1.3 or version 1.5.1 or higher<br>';
                $ak         = array_search('1.3.1', $possibleV);
                $return     = array_splice($possibleV, $ak);
                $this->versions_left = $return;
            }
        return $return; 
    }*/
}





  







// TEST CASE

$opendir = opendir('C:\Users\KM\Desktop\CodeIgniterVersionTester\root\codeigniter-version-detect');

$versions = array();
while ($dirname = readdir($opendir))
{
    if ($dirname != '.' && $dirname != '..')
    {
        if (substr($dirname,0,11) == 'CodeIgniter')
        {
            $versions[] = $dirname;
        }
    }
}


foreach ($versions as $version)
{
    $CiVersionTests = new CiVersionTests;
    $uri = 'http://localhost:8080/codeigniter-version-detect/'.$version.'/'.$version.'/';
    $CiVersionTests->url = $uri;

    //$avv = $_POSSIBLE_VERSIONS;
    $evv = explode('_', $version);
    $version = $evv[1];

    //echo '<strong>URL</strong>: ' . $CiVersionTests->url . '<br>';
    echo '<br>Testing version ' . $version . ' ... ';

    echo '<table style="font-size:11px">';
    $CiVersionTests->test('controllers_index_html', $version);
    $CiVersionTests->test('user_guide_version', $version);
    $CiVersionTests->test('application_folder', $version);
    $CiVersionTests->test('libraries_calendar', $version);
    $CiVersionTests->test('models_index_html', $version);
    $CiVersionTests->test('license_txt', $version);
    //$CiVersionTests->test('system_init_unit_test', $version);
    echo '</table>';
}
    
    
    
    
    
    
    
    
// rebuild below to functions in class above
/*
        
        $GO = false;
        
        if($GO){
            $GO = false;

            
            

            
            
            if($GO){
                $GO = false;
                // als system/init/init_unit_test.php bestaat is het versie 1.3.1 of hoger
                $response6 = file_get_contents($uri.'system/init/init_unit_test.php', true);
                $response6header = $http_response_header[0];
                
                if($http_response_header[0] === 'HTTP/1.1 404 Not Found'){
                    echo 'CodeIgniter version 1.3 or version 1.5.1 or higher<br>';
                }else{
                    $GO = true;
                    // go on
                }
            }
            
            if($GO){
                $GO = false;
                // als system/init/init_unit_test.php bestaat is het versie 1.3.1 of hoger
                $response7 = file_get_contents($uri.'system/init/init_unit_test.php', true);
                $response7header = $http_response_header[0];
                
                if($http_response_header[0] === 'HTTP/1.1 404 Not Found'){
                    echo '<strong>CodeIgniter version 1.3.1 or higher</strong><br>';

                }else{
                    $GO = true;
                    // go on
                }
            }
            
            if($GO){
                $GO = false;
                // als system/application/scripts bestaat is het versie 1.3.1 of hoger
                $response8 = file_get_contents($uri.'system/application/scripts/', true);
                $response8header = $http_response_header[0];
                
                if($http_response_header[0] === 'HTTP/1.1 200 OK'){
                    echo '<strong>CodeIgniter version 1.3.1 or 1.3.2 or 1.3.3</strong><br>';
                }else{
                    $GO = true;
                    // go on
                }
            }
            
            if($GO){
                $GO = false;
                // /system/application/config/smileys.php bestaat = 1.4.1 of hoger
                $response8 = file_get_contents($uri.'system/application/config/smileys.php', true);
                $response8header = $http_response_header[0];
                
                if($http_response_header[0] === 'HTTP/1.1 404 Not Found'){
                    echo '<strong>CodeIgniter version 1.4.1</strong><br>';
                }else{
                    $GO = true;
                    // go on
                }
            }
        
            //print_r($avv);
        }
        echo '<hr>';
        
    }
*/