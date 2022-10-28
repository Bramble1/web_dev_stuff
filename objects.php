<?php

//logging errors to a file,could use xml format,whatever,or json.
class log
{

}

//use for security
class filter_information
{
	protected $buffer;
	protected $err_msg;//give to the error_log class for each class

	function clean_input()
	{
		$this->buffer= htmlspecialchars( stripslashes( trim($buffer))) ;
	}

	//returns 0 if clean,else -1
	function restrict_input($option)
	{
		//restrict parameter to only letters allowed
		if(option=='l' || 'L')
		{
			//check if buffer only contains letters and white space
			if(!preg_match("/^[a-zA-Z-']*$/",$this->buffer))
			{
				$err_msg = "input is contaminated with non-letters!";
				return -1;
			}
		}//restrict check to numbers only
		else if(option='n' || 'N')
		{
			if(!preg_match("/^[0-9]*$/",$this->buffer))
			{
				$err_msg = "input is contaminated with letters";
				return -1;
			}
		}
	}

	function get_buffer()
	{
		return $buffer;
	}
	function set_buffer($buffer)
	{
		$this->buffer=$buffer;
	}	
}


//use for logging in the future, as well as for reading the db credentials
class file_manager
{
	protected $filename;
	protected $fd;

	/*filter the data first,so need a filter object in scope relative to stack frame*/
	function open_file($perm)
	{
		$this->fd=fopen($this->filename,perms) or die ("unable to open file");	
	}
	function read_file(){};
	function write_file(){};
	function delete_file(){};
	function close_file(){};	
}


class database_manager
{
	/*
	 * database information,use a file_manager class to read a database info file.
	 *
	 * basic functions, then inherit for our own use and overload and change any functions
	 * specifically
	 * */
	protected $db;
	protected $db_file;


	function __construct($db_file)
	{
		//read the file and open etc.	
	}
}

//then inherite the database class  for our specific ration_table class




?>
