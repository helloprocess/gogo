<?php
header("Status: 301 Moved Permanently");
header('Location: http://kkkk' . $_SERVER['SERVER_NAME'] . ':' . $_SERVER['SERVER_PORT'] . '/submit?' . $_SERVER['QUERY_STRING']);
exit();
?>
