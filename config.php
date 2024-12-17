<?php

return [
    'restrict_ip' => [
	'1.2.3.4', //my IP
	'1.2.3.0/24', //my NETWORK
	'192.168.0.0/16', //locals
	'10.0.0.0/8', //locals
    ],

    //enable/disable app authentication
    'auth' => true,
    'users' => [
	// username => password
	'admin' => 'admin'
    ],

    'server' => [
	'name' => 'Localhost', //mongo server name
	'uri' => 'mongodb://127.0.0.1:27017',

	'auth' => false,
	'uriOptions' => [],
	//'authSource' => 'MONGO_DATABASE',
	//'username' => 'MONGO_USERNAME',
	//'password' => 'MONGO_PASSWORD',
    ],

    //ui options
    'ui_only_dbs' => [], //databases to display
    'ui_hide_dbs' => [], //databases to hide
    'ui_hide_collections' => [], //collections to hide
    'ui_hide_system_collections' => false, //whether hide the system collections
];
