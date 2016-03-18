<?php

	require('Reader.php');

	$reader = new Reader('test.json');
	$test = $reader->getPath('/ticker')->byType('post');
	print_R($test);

