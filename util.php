<?php
	$db_url = getenv("DATABASE_URL") ?: "postgres://user:pass@host:port/dbname";    
  $db = pg_connect($db_url);			
?>
