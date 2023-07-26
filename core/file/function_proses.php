<?php
class db
{

	var $mysqli_host     = "localhost";
	var $mysqli_database = "nextg_rw";
	var $mysqli_user     = "root";
	var $mysqli_password = "";
	var $query = "";
	function __construct()
	{
		$this->query = mysqli_connect($this->mysqli_host, $this->mysqli_user, $this->mysqli_password, $this->mysqli_database);
	}

	function select($table, $where, $by, $aksi, $kolom = '*')
	{
		$query = mysqli_query($this->query, "SELECT $kolom FROM $table where $where order by $by $aksi");
		return $query;
	}
	function selectAll($query)
	{
		$query = mysqli_query($this->query, $query);
		return $query;
	}

	function selectDo($data)
	{
		$query = mysqli_query($this->query, $data);
		return $query;
	}



	function selectpage($table, $where, $by, $aksi, $awal, $akhir, $kolom = '*')
	{
		$query = mysqli_query($this->query, "SELECT $kolom FROM $table where $where order by $by $aksi LIMIT {$awal} , {$akhir}");
		return $query;
	}


	function insert($table, $set)
	{
		$query = mysqli_query($this->query, "INSERT INTO $table SET $set");
		return $query;
	}

	function update($table, $set, $where)
	{
		$query = mysqli_query($this->query, "UPDATE $table SET $set WHERE $where");
		return $query;
	}

	function hapus($table, $where)
	{
		$query = mysqli_query($this->query, "DELETE FROM $table WHERE $where");
		return $query;
	}
}
