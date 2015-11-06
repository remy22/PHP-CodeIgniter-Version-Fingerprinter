<?php namespace CiVersionTester;

class CiVersionTests
{
    public $url;
    private $all_versions;
    private $versions_left;
    
    /**
     * @param string $url
     */
    public function __construct($url = null)
    {
        if (empty($url)) {
            return FALSE;
        }
        $this->all_versions = array('1.0b', '1.1b', '1.2', '1.3', '1.3.1', '1.3.2', '1.3.3', '1.4.1',
                                    '1.5.1', '1.5.2', '1.5.3', '1.5.4', '1.6.0', '1.6.1', '1.6.2', '1.6.3',
                                    '1.7.0', '1.7.1', '1.7.2', '1.7.3', '2.0.0', '2.0.1', '2.0.2', '2.0.3',
                                    '2.1.0', '2.1.1', '2.1.2', '2.1.3', '2.1.4', '2.2.1',
                                    '3.0rc', '3.0rc2', '3.0rc3');
        $this->versions_left = $this->all_versions;
    }
    
    /**
     * @param string $url
     */
    private function getHttpResponseCode($url)
    {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_exec($curl);
        $httpStatusCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        curl_close($curl);
        return intval($httpStatusCode);
    }
    
    /**
     * @param string $search
     */
    private function highlightKeyword($str, $search)
    {
        $occurrences = substr_count(strtolower($str), strtolower($search));
        $newstring = $str;
        $match = array();
        
        for ($i=0; $i < $occurrences; ++$i) {
            $match[$i] = stripos($str, $search, $i);
            $match[$i] = substr($str, $match[$i], strlen($search));
            $newstring = str_replace($match[$i], '[#]' . $match[$i] . '[@]', strip_tags($newstring));
        }
        
        $newstring = str_replace('[#]', '<span style="background:green;color:white;">', $newstring);
        $newstring = str_replace('[@]', '</span>', $newstring);
        return $newstring;
    }
    
    /**
     * @param string $function
     * @param string $testedVersion
     */
    public function test($function, $testedVersion)
    {
        echo $this->highlightKeyword(print_r($this->$function(), true), '=> ' . $testedVersion . "\n");
    }
    
    private function userGuideVersion()
    {
        $return = false;
        $url = $this->url . 'user_guide/';
        if ($this->getHttpResponseCode($url) !== 200) {
            return $return;
        }

        $response = file_get_contents($url, true);
        # check version < 3.0rc
        preg_match('/h1(.*)</', $response, $matched);
        if (substr($matched[1], 0, 11) === '>Code Ignit' || substr($matched[1], 0, 11) === '>CodeIgnite') {
            # version found in user_guide
            $version = trim(strip_tags(str_replace(array('>Code Igniter User Guide Version',
                                                            '>CodeIgniter User Guide Version'), '', $matched[1])));
            $return = $version;
            if ($version == '1.0') {
                $return = '1.0b';
            }
            
            if ($version == 'Beta 1.1') {
                $return = '1.1b';
            }
        }
        
        # check version == 3.0rc
        preg_match('/Jan 26, 2015/', $response, $match);
        if (count($match) > 0) {
            $return = '3.0rc';
        }
        
        # check version == 3.0rc2
        preg_match('/Feb 03, 2015/', $response, $match);
        if (count($match) > 0) {
            $return = '3.0rc2';
        }
        
        # check version == 3.0rc3
        preg_match('/Mar 10, 2015/', $response, $match);
        if (count($match) > 0) {
            $return = '3.0rc3';
        }
        
        $return = array($return);
        $this->versions_left = $return;
        return $return;
    }
    
    private function applicationFolder()
    {
        $url = $this->url . 'application/';
        $possibleV = $this->all_versions;

        if ($this->getHttpResponseCode($url) === 403) {
            # version 2.0.0 or higher
            $akey = array_search('2.0.0', $possibleV);
            $return = array_splice($possibleV, $akey);
            $this->versions_left = $return;
            return $return;
        }
        
        # version 1.7.3 or lower
        $akey = array_search('1.7.3', $possibleV);
        $return = array_splice($possibleV, 0, $akey + 1);
        $this->versions_left = $return;
        
        return $return;
    }

    private function librariesCalendar()
    {
        $url = $this->url . 'system/libraries/Calendar.php';
        if ($this->getHttpResponseCode($url) === 404) {
            return array('1.0b');
        }

        return false;
    }
    
    private function controllersIndexHtml()
    {
        $return = false;
        $url = $this->url . 'system/application/controllers/index.html';

        if ($this->getHttpResponseCode($url) === 404) {
            # version 2.0.0 or higher
            $possibleV = $this->all_versions;
            $akey = array_search('1.2', $possibleV);
            $return = array_splice($possibleV, 0, $akey);
            $this->versions_left = $return;
        }
        
        return $return;
    }
    
    private function modelsIndexHtml()
    {
        $return = false;
        $url = $this->url . 'system/application/models/index.html';

        if ($this->getHttpResponseCode($url) === 404) {
            // if /system/application/models/index.html exists Version 1.3 or higher
            $possibleV = $this->all_versions;
            $akey = array_search('1.2', $possibleV);
            $return = array_splice($possibleV, 0, $akey + 1);
            $this->versions_left = $return;
        }
        return $return;
    }

    private function licenseTxt()
    {
        $return = false;
        $url = $this->url . 'license.txt';
        
        // match pMachine = 1.5.2 or lower, match EllisLab = 1.5.3 or higher
        if ($this->getHttpResponseCode($url) !== 200) {
            return $return;
        }
        
        $possibleV = $this->all_versions;
        $response = file_get_contents($url, true);

        file_get_contents($url, true);
        preg_match('/EllisLab/', $response, $ematch);
        if ($ematch) {
            $akey = array_search('1.5.3', $possibleV);
            $return = array_splice($possibleV, $akey);
            $this->versions_left = $return;
            return $return;
        }
        
        preg_match('/pMachine/', $response, $pmatch);
        if ($pmatch) {
            $akey = array_search('1.5.2', $possibleV);
            $return = array_splice($possibleV, 0, $akey + 1);
            $this->versions_left = $return;
        }
        
        return $return;
    }
    
    private function systemInitUnitTest()
    {
        $return = 0;
        $url = $this->url . 'system/init/init_unit_test.php';
        
        $possibleV = $this->all_versions;
        // als system/init/init_unit_test.php bestaat is het versie 1.3.1 of hoger
        if ($this->getHttpResponseCode($url) === 404) {
            $akey = array_search('1.3.1', $possibleV);
            $return = array_splice($possibleV, $akey);
            $this->versions_left = $return;
        }
        return $return;
    }
}
