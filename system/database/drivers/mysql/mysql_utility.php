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
 * MySQL Utility Class
 *
 * @category	Database
 * @author		EllisLab Dev Team
 * @link		http://codeigniter.com/user_guide/database/
 */
class CI_DB_mysql_utility extends CI_DB_utility {

	/**
	 * List databases
	 *
	 * @access	private
	 * @return	bool
	 */
	function _list_databases()
	{
		return "SHOW DATABASES";
	}

	function _list_views(){
		return "SELECT TABLE_NAME FROM information_schema.`TABLES` WHERE TABLE_TYPE LIKE 'VIEW' AND TABLE_SCHEMA = '".$this->db->database."'";
	}

	function _list_procedure(){
		return "SELECT NAME FROM mysql.proc WHERE TYPE = 'PROCEDURE'  AND db = '".$this->db->database."'";
	}

	function _list_function(){
		return "SELECT NAME FROM mysql.proc WHERE TYPE = 'FUNCTION' AND db ='".$this->db->database."'";
	}

	// --------------------------------------------------------------------

	/**
	 * Optimize table query
	 *
	 * Generates a platform-specific query so that a table can be optimized
	 *
	 * @access	private
	 * @param	string	the table name
	 * @return	object
	 */
	function _optimize_table($table)
	{
		return "OPTIMIZE TABLE ".$this->db->_escape_identifiers($table);
	}

	// --------------------------------------------------------------------

	/**
	 * Repair table query
	 *
	 * Generates a platform-specific query so that a table can be repaired
	 *
	 * @access	private
	 * @param	string	the table name
	 * @return	object
	 */
	function _repair_table($table)
	{
		return "REPAIR TABLE ".$this->db->_escape_identifiers($table);
	}

	// --------------------------------------------------------------------
	/**
	 * MySQL Export
	 *
	 * @access	private
	 * @param	array	Preferences
	 * @return	mixed
	 */
	function _backup($params = array())
	{
		if (count($params) == 0)
		{
			return FALSE;
		}

		// Extract the prefs for simplicity
		extract($params);

		// Build the output
		$output = "/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;".$newline."/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;".$newline."/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;".$newline."/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;";
		foreach ((array)$tables as $table)
		{
			// Is the table in the "ignore" list?
			if (in_array($table, (array)$ignore, TRUE))
			{
				continue;
			}

			// Get the table schema
			$query = $this->db->query("SHOW CREATE TABLE `".$this->db->database.'`.`'.$table.'`');

			// No result means the table name was invalid
			if ($query === FALSE)
			{
				continue;
			}

			// Write out the table schema
			$output .= '#'.$newline.'# TABLE STRUCTURE FOR: '.$table.$newline.'#'.$newline.$newline;

			if ($add_drop == TRUE)
			{
				$output .= 'DROP TABLE IF EXISTS '.$table.';'.$newline.$newline;
			}

			$i = 0;
			$result = $query->result_array();
			foreach ($result[0] as $val)
			{
				if ($i++ % 2)
				{
					$output .= $val.';'.$newline.$newline;
				}
			}

			// If inserts are not needed we're done...
			if ($add_insert == FALSE)
			{
				continue;
			}

			// Grab all the data from the current table
			$query = $this->db->query("SELECT * FROM $table");

			if ($query->num_rows() == 0)
			{
				continue;
			}

			// Fetch the field names and determine if the field is an
			// integer type.  We use this info to decide whether to
			// surround the data with quotes or not

			$i = 0;
			$field_str = '';
			$is_int = array();
			while ($field = mysql_fetch_field($query->result_id))
			{
				// Most versions of MySQL store timestamp as a string
				$is_int[$i] = (in_array(
										strtolower(mysql_field_type($query->result_id, $i)),
										array('tinyint', 'smallint', 'mediumint', 'int', 'bigint'), //, 'timestamp'),
										TRUE)
										) ? TRUE : FALSE;

				// Create a string of field names
				$field_str .= '`'.$field->name.'`, ';
				$i++;
			}

			// Trim off the end comma
			$field_str = preg_replace( "/, $/" , "" , $field_str);


			// Build the insert string
			foreach ($query->result_array() as $row)
			{
				$val_str = '';

				$i = 0;
				foreach ($row as $v)
				{
					// Is the value NULL?
					if ($v === NULL)
					{
						$val_str .= 'NULL';
					}
					else
					{
						// Escape the data if it's not an integer
						if ($is_int[$i] == FALSE)
						{
							$val_str .= $this->db->escape($v);
						}
						else
						{
							$val_str .= $v;
						}
					}

					// Append a comma
					$val_str .= ', ';
					$i++;
				}

				// Remove the comma at the end of the string
				$val_str = preg_replace( "/, $/" , "" , $val_str);

				// Build the INSERT string
				$output .= 'INSERT INTO '.$table.' ('.$field_str.') VALUES ('.$val_str.');'.$newline;
			}

			$output .= $newline.$newline;
		}

		$output .= $newline.$newline;
		$output .= '# CREATING PROCEDURE'.$newline;
		foreach ((array)$procedures as $procedure){
			$query = $this->db->query("SHOW CREATE PROCEDURE `".$this->db->database.'`.`'.$procedure.'`');
				// No result means the table name was invalid
			if ($query === FALSE){
				continue;
			}
			
			$output .= 'DROP PROCEDURE IF EXISTS '.$procedure.';'.$newline.$newline;
			$output .= 'DELIMITER $$'.$newline;
			$i = 0;
			$result = $query->result_array();
			foreach ($result[0] as $val){
				if ($i== 2){
					$output .= $val.'$$'.$newline.$newline;
				}
				$i++;
			}
			$output .= 'DELIMITER ;'.$newline.$newline;
		}

		$output .= $newline.$newline;
		$output .= '# CREATING FUNCTION'.$newline;
		foreach ((array)$functions as $function){
			$query = $this->db->query("SHOW CREATE FUNCTION `".$this->db->database.'`.`'.$function.'`');
			// No result means the table name was invalid
			if ($query === FALSE){
				continue;
			}
			

			$output .= 'DROP FUNCTION IF EXISTS '.$function.';'.$newline.$newline;
			$output .= 'DELIMITER $$'.$newline;
			$i = 0;
			$result = $query->result_array();
			foreach ($result[0] as $val){
				if ($i== 2){
					$output .= $val.'$$'.$newline.$newline;
				}
				$i++;
			}
			$output .= 'DELIMITER ;'.$newline;
			
		}

		$output .= $newline.$newline;
		$output .= '# CREATING TABLE FROM VIEWS #';
		foreach ((array)$views as $view){
			$query = $this->db->query("DESCRIBE `".$this->db->database.'`.`'.$view.'`');
			// No result means the table name was invalid
			if ($query === FALSE){
				continue;
			}
			$output .= 'DROP VIEW IF EXISTS '.$view.';'.$newline.$newline;
			$output .= 'DROP TABLE IF EXISTS '.$view.';'.$newline.$newline;
			$i = 1;
			$result = $query->result_array();
			
			$output .= 'CREATE TABLE '.$view.'('.$newline;
			$len = count($result);
			foreach ($result as $val){
				$output .='`'.$val['Field'].'` '.$val['Type'];
				if($len!=$i){
					$output .=','.$newline;
				}
				$i++;
			}
			$output .=$newline.');'.$newline.$newline;
			
		}

		$output .= $newline.$newline;
		$output .= '# CREATING VIEWS #';
		foreach ((array)$views as $view){
			$query = $this->db->query("SHOW CREATE TABLE `".$this->db->database.'`.`'.$view.'`');
			// No result means the table name was invalid
			if ($query === FALSE){
				continue;
			}
			$output .= 'DROP VIEW IF EXISTS '.$view.';'.$newline.$newline;
			$output .= 'DROP TABLE IF EXISTS '.$view.';'.$newline.$newline;
			$i = 0;
			$result = $query->result_array();
			
			foreach ($result[0] as $val){
				if ($i== 1){
					$output .= $val.';'.$newline.$newline;
				}
				$i++;
			}
			
		}

		$output .= $newline.$newline;
		$output .= '/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;'.$newline.'/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;'.$newline.'/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;'.$newline.'/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;';
		
		return $output;
	}
}

/* End of file mysql_utility.php */
/* Location: ./system/database/drivers/mysql/mysql_utility.php */