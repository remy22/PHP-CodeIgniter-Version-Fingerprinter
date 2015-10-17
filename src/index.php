<?php
    include 'CiVersionTester.class.php';
    
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
    $CiVersionTests->test('controllersIndexHtml', $version);
    $CiVersionTests->test('userGuideVersion', $version);
    $CiVersionTests->test('applicationFolder', $version);
    $CiVersionTests->test('librariesCalendar', $version);
    $CiVersionTests->test('modelsIndexHtml', $version);
    $CiVersionTests->test('licenseTxt', $version);
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