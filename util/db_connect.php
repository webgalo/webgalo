<?php
date_default_timezone_set('America/Sao_Paulo');

require_once("class.dbAccess.php");

ini_set('default_charset', 'ISO-8859-1');

ini_set('mysql.connect_timeout', 300);
ini_set('default_socket_timeout', 300);

global $conn_i;
$conn_i = mysqli_connect(DBAccess::DB_HOST, DBAccess::DB_USER, DBAccess::DB_PASS, DBAccess::DB_NAME) or die("Error connecting to mysqli: (" . mysqli_connect_errno() . ") " . mysqli_connect_error());

global $conn;
$conn = null;//@mysql_connect(DBAccess::DB_HOST, DBAccess::DB_USER, DBAccess::DB_PASS) or die ('Error connecting to mysql');
//mysql_select_db(DBAccess::DB_NAME);

function check_dbconn($conn) {
	/*while (!@mysql_ping($conn)) {

		//@mysql_close($conn);
		$conn = null;//@mysql_connect(DBAccess::DB_HOST, DBAccess::DB_USER, DBAccess::DB_PASS, DBAccess::DB_NAME);

		$dbname = 'wgfp';
		//@mysql_select_db(DBAccess::DB_NAME);
	}*/
	//	return $connection;
}

function check_dbconn_i($conn_i) {
	while (!@mysqli_ping($conn_i)) {

		@mysqli_close($conn_i);
		$ping_conn_i = @mysqli_connect(DBAccess::DB_HOST, DBAccess::DB_USER, DBAccess::DB_PASS, DBAccess::DB_NAME);

		@mysqli_select_db($conn_i, DBAccess::DB_NAME);
	}
}

?>
