php mass insert class
=====================

Php mass insert is a tool for speeding up insertion of lots of rows into mySQL database. It reduces the total amount of queries by combining multiple rows into one INSERT query.

http://dev.mysql.com/doc/refman/5.0/en/insert-speed.html

Usage:
```php
$tbl = new php_mass_insert('tablename', array_of_column_names);

while($data as $row) {
 $tbl->insert($row);
}

# important to "close" the table, this will flush rows to database
$tbl->close();
```
