<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * CodeIgniter
 *
 * An open source application development framework for PHP 5.1.6 or newer
 *
 * @package		CodeIgniter
 * @author		EllisLab Dev Team
 * @copyright		Copyright (c) 2008 - 2014, EllisLab, Inc.
 * @copyright		Copyright (c) 2014 - 2015, British Columbia Institute of Technology (http://bcit.ca/)
 * @license		http://codeigniter.com/user_guide/license.html
 * @link		http://codeigniter.com
 * @since		Version 1.0
 * @filesource
 */

// ------------------------------------------------------------------------

/**
 * Initialize the database
 *
 * @category	Database
 * @author		EllisLab Dev Team
 * @link		http://codeigniter.com/user_guide/database/
 * @param 	string
 * @param 	bool	Determines if active record should be used or not
 */
function &DB($params = '', $active_record_override = NULL){
	if ( ! file_exists($file_path = getFilePath())){
		show_error('The configuration file does not exist, Contact SIPP Team.');
	}
	// Load the DB config file if a DSN string wasn't passed
	#if($params['dbdriver']=='mysql'){
		$params = parse_config_file();
		$params['hostname'] = decryp($params['hostname']);
		$params['username'] = decryp($params['username']);
		$params['password'] = decryp($params['password']);
		$params['database'] = decryp($params['database']);
	#}
	
	if (is_string($params) AND strpos($params, '://') === FALSE)
	{

		// Is the config file in the environment folder?
		if ( ! defined('ENVIRONMENT') OR ! file_exists($file_path = APPPATH.'config/'.ENVIRONMENT.'/database.php'))
		{
			if ( ! file_exists($file_path = APPPATH.'config/database.php'))
			{
				show_error('The configuration file database.php does not exist.');
			}
		}

		include($file_path);

		if ( ! isset($db) OR count($db) == 0)
		{
			show_error('No database connection settings were found in the database config file.');
		}

		if ($params != ''){
			$active_group = $params;
		}

		if ( ! isset($active_group) OR ! isset($params)){
			show_error('You have specified an invalid database connection group.');
		}

		#$params = $db[$active_group];
		$conns = connecting_test($params['hostname'],$params['username'],$params['password'],$params['database']);

		if(!$conns){
			show_error('Could not connect: '.$conns);
		}
	}
	elseif (is_string($params)){

		/* parse the URL from the DSN string
		 *  Database settings can be passed as discreet
		 *  parameters or as a data source name in the first
		 *  parameter. DSNs must have this prototype:
		 *  $dsn = 'driver://username:password@hostname/database';
		 */

		if (($dns = @parse_url($params)) === FALSE)
		{
			show_error('Invalid DB Connection String');
		}

		$params = array(
							'dbdriver'	=> $dns['scheme'],
							'hostname'	=> (isset($dns['host'])) ? rawurldecode($dns['host']) : '',
							'username'	=> (isset($dns['user'])) ? rawurldecode($dns['user']) : '',
							'password'	=> (isset($dns['pass'])) ? rawurldecode($dns['pass']) : '',
							'database'	=> (isset($dns['path'])) ? rawurldecode(substr($dns['path'], 1)) : ''
						);

		// were additional config items set?
		if (isset($dns['query']))
		{
			parse_str($dns['query'], $extra);

			foreach ($extra as $key => $val)
			{
				// booleans please
				if (strtoupper($val) == "TRUE")
				{
					$val = TRUE;
				}
				elseif (strtoupper($val) == "FALSE")
				{
					$val = FALSE;
				}

				$params[$key] = $val;
			}
		}
	}

	// No DB specified yet?  Beat them senseless...
	if ( ! isset($params['dbdriver']) OR $params['dbdriver'] == '')
	{
		show_error('You have not selected a database type to connect to.');
	}

	// Load the DB classes.  Note: Since the active record class is optional
	// we need to dynamically create a class that extends proper parent class
	// based on whether we're using the active record class or not.
	// Kudos to Paul for discovering this clever use of eval()

	if ($active_record_override !== NULL)
	{
		$active_record = $active_record_override;
	}

	$conns = connecting_test($params['hostname'],$params['username'],$params['password'],$params['database']);
	if($conns===TRUE){
		require_once(BASEPATH.'database/DB_driver.php');

		if ( ! isset($active_record) OR $active_record == TRUE)
		{
			require_once(BASEPATH.'database/DB_active_rec.php');

			if ( ! class_exists('CI_DB'))
			{
				eval('class CI_DB extends CI_DB_active_record { }');
			}
		}
		else{
			if ( ! class_exists('CI_DB')){
				eval('class CI_DB extends CI_DB_driver { }');
			}
		}

		require_once(BASEPATH.'database/drivers/'.$params['dbdriver'].'/'.$params['dbdriver'].'_driver.php');

		// Instantiate the DB adapter
		$driver = 'CI_DB_'.$params['dbdriver'].'_driver';
		$DB = new $driver($params);

		if ($DB->autoinit == TRUE)
		{
			$DB->initialize();
		}

		if (isset($params['stricton']) && $params['stricton'] == TRUE)
		{
			$DB->query('SET SESSION sql_mode="STRICT_ALL_TABLES"');
		}

		return $DB;
	}else{
		$DB = 'xxx';
		return $DB;
	}
	
}

function connecting_test($host,$username,$pass,$dbname){
	try {
		$dbConnection = new PDO('mysql:host='.$host.';dbname='.$dbname, $username, $pass);
		$dbConnection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$dbConnection->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
		return TRUE;
	} catch (Exception $e) {
		if (preg_match("/\bAccess denied for user\b/i", $e->getMessage())) {
			$err =  "Username atau Password Salah";
		} elseif (preg_match("/\bUnknown MySQL server host\b/i", $e->getMessage())){
			$err =  "Alamat server salah";
		} elseif (preg_match("/\bUnknown database\b/i", $e->getMessage())){
			$err =  "DATABASE Tidak ditemukan";
		} else{
			$err = "Problem = ".$e;
		}
		return $err;
	}
}

	function getFilePath(){
		$file_path = APPPATH.'config/config.ini';
		return $file_path;
	}

	function is_config_file_exist(){
		if ( ! file_exists($file_path = getFilePath())){
			show_error('The configuration file does not exist, Contact SIPP Team.');
			return FALSE;
		}
		return TRUE;
	}
	function parse_config_file(){
		$file_path = getFilePath();
		$ini_array = parse_ini_file($file_path, true);
		return $ini_array['db_config'];
	}

	function parse_login_pass(){
		$file_path = getFilePath();
		$ini_array = parse_ini_file($file_path, true);
		return $ini_array['default'];
	}

	function getKeyword(){
		return 'sql_4_4dm1n_MA_R!';
	}

	function encryp($string){
		$key = getKeyword();
		return base64_encode(mcrypt_encrypt(MCRYPT_RIJNDAEL_256, md5($key), $string, MCRYPT_MODE_CBC, md5(md5($key))));
	}

	function decryp($encrypted){
		$key = getKeyword();
		return rtrim(mcrypt_decrypt(MCRYPT_RIJNDAEL_256, md5($key), base64_decode($encrypted), MCRYPT_MODE_CBC, md5(md5($key))), "\0");
	}

	function write_ini_file($assoc_arr, $path, $has_sections=FALSE) { 
        $content = ";<?php \n;die();\n;/*\n \n "; 
        if ($has_sections) { 
            foreach ($assoc_arr as $key=>$elem) { 
                $content .= "\n[".$key."]\n"; 
                foreach ($elem as $key2=>$elem2) { 
                    if(is_array($elem2)){
                        for($i=0;$i<count($elem2);$i++){ 
                            $content .= $key2."[] = \"".$elem2[$i]."\"\n"; 
                        }
                    } 
                    else if($elem2=="") $content .= $key2." = \n"; 
                    else $content .= $key2." = \"".$elem2."\"\n"; 
                } 
            } 
        }else { 
            foreach ($assoc_arr as $key=>$elem) { 
                if(is_array($elem)){
                    for($i=0;$i<count($elem);$i++){
                        $content .= $key2."[] = \"".$elem[$i]."\"\n"; 
                    }
                }
                else if($elem=="") $content .= $key2." = \n"; 
                else $content .= $key2." = \"".$elem."\"\n"; 
            }
        }

        $content .="\n \n;*/ \n;?>\n ";
        if (!$handle = fopen($path, 'w')) { 
            return false; 
        } 
        if (!fwrite($handle, $content)) { 
            return false; 
        }
        fclose($handle); 
        return true; 
    }

    function save_passwd($pass_wd){
        if(!isset($pass_wd)){
            return false;
        }
        try {
        	if (!is_writable(getFilePath())) {
        		return false;
        	}

        	$params = parse_config_file();
	        $conf_data = array(
	                        'default' => array(
	                            'passwd' => $pass_wd,
	                        ),
	                        'db_config' => array(
	                            'hostname' => $params['hostname'],
	                            'username' => $params['username'],
	                            'password' => $params['password'],
	                            'database' => $params['database'],
	                            'dbdriver' => $params['dbdriver'],
	                            'dbprefix' => $params['dbprefix'],
	                            'pconnect' => $params['pconnect'],
	                            'db_debug' => $params['db_debug'],
	                            'cache_on' => $params['cache_on'],
	                            'cachedir' => $params['cachedir'],
	                            'char_set' => $params['char_set'],
	                            'dbcollat' => $params['dbcollat'],
	                            'swap_pre' => $params['swap_pre'],
	                            'autoinit' => $params['autoinit'],
	                            'stricton' => $params['stricton']
	                        ));
			//chmod(getFilePath(), 0777);
	        write_ini_file($conf_data, getFilePath(), true);
	        //chmod(getFilePath(), 0644);
	        return true;
        } catch (Exception $e) {
        	return false;
        }
        
    }

    function update_conf($hostname,$username,$password,$database){
    	if (!is_writable(getFilePath())) {
        	return false;
        }
        $param = parse_login_pass();
        $passwd = $param['passwd'];
        if(!isset($hostname,$username,$password,$database)){
            return false;
        }
        $params = parse_config_file();
        $conf_data = array(
                        'default' => array(
                            'passwd' => $passwd,
                        ),
                        'db_config' => array(
                            'hostname' => $hostname,
                            'username' => $username,
                            'password' => $password,
                            'database' => $database,
                            'dbdriver' => $params['dbdriver'],
                            'dbprefix' => $params['dbprefix'],
                            'pconnect' => $params['pconnect'],
                            'db_debug' => $params['db_debug'],
                            'cache_on' => $params['cache_on'],
                            'cachedir' => $params['cachedir'],
                            'char_set' => $params['char_set'],
                            'dbcollat' => $params['dbcollat'],
                            'swap_pre' => $params['swap_pre'],
                            'autoinit' => $params['autoinit'],
                            'stricton' => $username
                        ));
		//chmod(getFilePath(), 0777);
        write_ini_file($conf_data, getFilePath(), true);
        //chmod(getFilePath(), 0644);
        return true;
    }

    function validateFilePermission(){
    	$file = getFilePath();
    	try {
    		#register_shutdown_function('shutdownFunction');
    		if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
    			return true;
    		}
    		$filepermission = decoct(fileperms($file) & 0777);
			$processUser = posix_getpwuid(posix_geteuid());
			$webserverUser =  $processUser['name'];
			$fileConf = posix_getpwuid(fileowner($file));
			$fileowner = $fileConf['name'];

			if($fileowner!=$webserverUser){
				return false;
			}
			return true;
    	} catch (Exception $e) {
    		return false;
    	}
    }

    ob_start('fatal_error_handler');

	function fatal_error_handler($buffer){
	    $error=error_get_last();
	    if($error['type'] == 1){
	        $newBuffer='<html><header><title>Fatal Error </title></header>
	                    <style>                 
	                    .error_content{                     
	                        background: white;
	                        vertical-align: middle;
	                        margin:0 auto;
	                        padding:10px;
	                        width:50%;
	                        font-family: Century Gothic,sans-serif;                           
	                     } 
	                     .error_content label{color: red;font-family: Georgia;font-size: 16pt;font-style: italic;}
	                     .error_content ul li{ background: none repeat scroll 0 0 FloralWhite;                   
	                                border: 1px solid AliceBlue;
	                                display: block;
	                                font-family: monospace;
	                                padding: 2%;
	                                text-align: left;
	                      }
	                    </style>
	                    <body style="text-align: center;">  
	                      <div class="error_content" style="margin-top:10%;">
	                      	<table style="width:100%;border: 1px solid #5FB85C;">
	                      		<tr style="text-align: center;background:#e74c3c;font-size:24px;height:35px;">
	                      			<td colspan="2">Fatal Error</td>
	                      		</tr>
	                      		<tr>
	                      			<td colspan="2"></td>
	                      		</tr>
	                      		<tr>
	                      			<td><b>Line</b></td>
	                      			<td>: '.$error['line'].'</td>
	                      		</tr>
	                      		<tr>
	                      			<td><b>Message</b></td>
	                      			<td>: '.$error['message'].'</td>
	                      		</tr>
	                      		<tr>
	                      			<td><b>File</b></td>
	                      			<td>: '.$error['file'].'</td>
	                      		</tr>';
	        if($error['message']=='Call to undefined function posix_getpwuid()'){
	        	$solution = 'Install php plugin untuk centos: <br> sudo yum install php-process.x86_64';
	        }else{
	        	$solution = 'Silahkan Menanyakan di SIPP Group';
	        }
	        $newBuffer .= '<tr>
	                      			<td><b>Solusi</b></td>
	                      			<td>: '.$solution.'</td>
	                      		</tr>';
	        $newBuffer .='
	                      	</table>               
	                      </div>
	                    </body></html>';
	        return $newBuffer;

	    }

	    return $buffer;

	}

	function conn_sqlserver(){
		try {
			
			if ( ! file_exists($file_path = APPPATH.'config/database.php')){
				return false;
			}

			include($file_path);
			$user = $db['migrasi']['username'];
			$pass = $db['migrasi']['password'];
			$server = $db['migrasi']['hostname'];
			$database = $db['migrasi']['database'];
			// No changes needed from now on
			$connection_string = "DRIVER={SQL Server};SERVER=$server;DATABASE=$database"; 
			$conn = odbc_connect($connection_string,$user,$pass);
			return $conn;
		} catch (Exception $e) {
			return false;
		}
	}

	function exe_sqlserver($conn,$query){
		try {
			return odbc_exec($conn, $query);
		} catch (Exception $e) {
			
		}
	}
/* End of file DB.php */
/* Location: ./system/database/DB.php */