<?php
	$redir = isset($_GET['file']) ? $_GET['file'] : '';
    header('location: '.base64_decode($redir));
?>