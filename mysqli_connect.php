<?php
$dbc = @mysqli_connect('localhost', 'root', '', 'member_rivero') 
OR die('Could not connect to MySQL Server: ' . mysqli_connect_error());

mysqli_set_charset($dbc, 'utf8');