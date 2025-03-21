<?php
header("Status: 301 Moved Permanently");
header('Location: http://' . $_SERVER['SERVER_NAME'] . '/submit?' . $_SERVER['QUERY_STRING']);
exit();
?>
