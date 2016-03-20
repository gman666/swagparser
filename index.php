<?php

	require('Reader.php');

	$reader = new Reader('test.json');
	//$test = $reader->getPath('/ticker')->byType('post')->get();

    $test = $reader->getPath('/ticker')->byKey('post/responses/200/description')->get();
	print_R($test);

