<?php

/*
PHP nass insert to mysql database
Author: Henri Kauppinen

Tool for inserting lots of rows into db table quickly by minimizing connection count and reducing overall packet overhead.
Safety is off to further increase performance.

Usage:

$table = new mass_insert("tablename", array_of_column_names,[rows_per_insert_adjustment]);
while($data as $row) {
	$table->insert($row);
}
$table->close();
# ATTENTION! Very important to run close() method, it makes sure that the last rows are pushed to database.

*/

class php_mass_insert {

	private $rows_per_insert;
	private $row_index = 0;
	private $query_rows;
	private $query_body;

	public function __construct($table_name, $table_columns, $rows_per_insert = 1000)
	{
		$this->query_body = "INSERT INTO $table_name (".implode(",", $table_columns).") VALUES ";
	}

	public function insert($values)
	{
		# store to row cache
		$query_rows[] = "('".implode("', '", $values)."')";

		if($this->row_index == $this->rows_per_insert) {

			$this->insert_to_db();

			$this->row_index = 0;
		}
		else {
			$this->row_index++;
		}
	}

	private function insert_to_db() {
		$res = mysql_query($this->query_body.implode(",", $this->query_rows)) or die ("Error: ".mysql_error()."\n");
		# empty row cache
		$this->query_rows = array();
	}

	public function close()
	{
		$this->insert_to_db();
	}
}