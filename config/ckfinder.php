<?php

/*
 * CKFinder Configuration File
 *
 * For the official documentation visit http://docs.cksource.com/ckfinder3-php/
 */

/*============================ PHP Error Reporting ====================================*/
// http://docs.cksource.com/ckfinder3-php/debugging.html

// Production
//error_reporting(E_ALL & ~E_DEPRECATED & ~E_STRICT);
//ini_set('display_errors', 0);

// Development
// error_reporting(E_ALL);
// ini_set('display_errors', 1);

/*============================ General Settings =======================================*/
// http://docs.cksource.com/ckfinder3-php/configuration.html

$config = array();

// $config['authentication'] = function () {
//     return true;
// };
$config['authentication'] = 'ckfinder';

/*============================ License Key ============================================*/
// http://docs.cksource.com/ckfinder3-php/configuration.html#configuration_options_licenseKey

$config['licenseName'] = 'localhost';
$config['licenseKey']  = '*8?A-*1**-R**K-*R**-*H**-E*Z*-3**H';

/*============================ CKFinder Internal Directory ============================*/
// http://docs.cksource.com/ckfinder3-php/configuration.html#configuration_options_privateDir

$config['privateDir'] = array(
    'backend' => 'laravel_cache',
    'tags'    => 'ckfinder/tags',
    'cache'   => 'ckfinder/cache',
    'thumbs'  => 'ckfinder/cache/thumbs',
    'logs'    => array(
        'backend' => 'laravel_logs',
        'path'    => 'ckfinder/logs'
    )
);

/*============================ Images and Thumbnails ==================================*/
// http://docs.cksource.com/ckfinder3-php/configuration.html#configuration_options_images

$config['images'] = array(
    'maxWidth'  => 1920,
    'maxHeight' => 980,
    'quality'   => 80,
    'sizes' => array(
        'small'  => array('width' => 480, 'height' => 320, 'quality' => 80),
        // 'medium' => array('width' => 600, 'height' => 480, 'quality' => 80),
        // 'large'  => array('width' => 800, 'height' => 600, 'quality' => 80)
    )
);

/*=================================== Backends ========================================*/
// http://docs.cksource.com/ckfinder3-php/configuration.html#configuration_options_backends

// The two backends defined below are internal CKFinder backends for cache and logs.
// Plase do not change these, unless you really want it.
$config['backends']['laravel_cache'] = array(
    'name'         => 'laravel_cache',
    'adapter'      => 'local',
    'root'         => storage_path('framework/cache'),
	// "useProxyCommand" => "false"
);

$config['backends']['laravel_logs'] = array(
    'name'         => 'laravel_logs',
    'adapter'      => 'local',
    'root'         => storage_path('logs'),
	// "useProxyCommand" => "false"
);

// Backends

$config['backends']['default'] = array(
    'name'         => 'default',
    'adapter'      => 'local',
    'baseUrl'      => env('APP_URL').'/public/uploads/',
    'root'         => public_path('/uploads/'),
    'chmodFiles'   => 0644,
    'chmodFolders' => 0755,
    'filesystemEncoding' => 'UTF-8',
	// "useProxyCommand" => "false"
);

/*================================ Resource Types =====================================*/
// http://docs.cksource.com/ckfinder3-php/configuration.html#configuration_options_resourceTypes

$config['defaultResourceTypes'] = '';

// $config['resourceTypes'][] = array(
//     'name'              => 'Files', // Single quotes not allowed.
//     'directory'         => 'files',
//     'maxSize'           => 0,
//     'allowedExtensions' => 'bmp,jpeg,jpg,mpeg,mpg,png',
//     'deniedExtensions'  => 'exe,bat,php',
//     'backend'           => 'default'
// );

$config['resourceTypes'][] = array(
    'name'              => 'Images',
    'directory'         => 'images',
    'maxSize'           => '5M',
    'allowedExtensions' => 'bmp,gif,jpeg,jpg,png',
    'deniedExtensions'  => 'exe,php,mp4,pdf,zip,bat,dll',
    'backend'           => 'default'
);

/*================================ Access Control =====================================*/
// http://docs.cksource.com/ckfinder3-php/configuration.html#configuration_options_roleSessionVar

// $config['roleSessionVar'] = 'admin';
$_SESSION['CKFinder_UserRole'] = 'ckfinder_auth';

// http://docs.cksource.com/ckfinder3-php/configuration.html#configuration_options_accessControl
$config['accessControl'][] = array(
    'role'                => '*',
    'resourceType'        => '*',
    'folder'              => '/',

    'FOLDER_VIEW'         => false,
    'FOLDER_CREATE'       => false,
    'FOLDER_RENAME'       => false,
    'FOLDER_DELETE'       => false,

    'FILE_VIEW'           => false,
    'FILE_UPLOAD'         => false,
    'FILE_RENAME'         => false,
    'FILE_DELETE'         => false,

    'IMAGE_RESIZE'        => false,
    'IMAGE_RESIZE_CUSTOM' => false
);

$config['accessControl'][] = array(
    'role'                => 'ckfinder_auth',
    'resourceType'        => '*',
    'folder'              => '/',

    'FOLDER_VIEW'         => true,
    'FOLDER_CREATE'       => false,
    'FOLDER_RENAME'       => false,
    'FOLDER_DELETE'       => false,

    'FILE_VIEW'           => true,
    'FILE_UPLOAD'         => true,
    'FILE_RENAME'         => true,
    'FILE_DELETE'         => true,

    'IMAGE_RESIZE'        => false,
    'IMAGE_RESIZE_CUSTOM' => false
);


/*================================ Other Settings =====================================*/
// http://docs.cksource.com/ckfinder3-php/configuration.html

$config['overwriteOnUpload'] = false;
$config['checkDoubleExtension'] = true;
$config['disallowUnsafeCharacters'] = true;
$config['secureImageUploads'] = true;
$config['checkSizeAfterScaling'] = true;
$config['htmlExtensions'] = array('html', 'htm', 'xml', 'js');
$config['hideFolders'] = array('.*', 'CVS', '__thumbs');
$config['hideFiles'] = array('.*');
$config['forceAscii'] = true;
$config['xSendfile'] = false;

// http://docs.cksource.com/ckfinder3-php/configuration.html#configuration_options_debug
$config['debug'] = false;

/*==================================== Plugins ========================================*/
// http://docs.cksource.com/ckfinder3-php/configuration.html#configuration_options_plugins

$config['plugins'] = array();

/*================================ Cache settings =====================================*/
// http://docs.cksource.com/ckfinder3-php/configuration.html#configuration_options_cache

$config['cache'] = array(
    'imagePreview' => 24 * 3600,
    'thumbnails'   => 24 * 3600 * 365
);

/*============================ Temp Directory settings ================================*/
// http://docs.cksource.com/ckfinder3-php/configuration.html#configuration_options_tempDirectory

$config['tempDirectory'] = sys_get_temp_dir();

/*============================ Session Cause Performance Issues =======================*/
// http://docs.cksource.com/ckfinder3-php/configuration.html#configuration_options_sessionWriteClose

$config['sessionWriteClose'] = true;

/*================================= CSRF protection ===================================*/
// http://docs.cksource.com/ckfinder3-php/configuration.html#configuration_options_csrfProtection

$config['csrfProtection'] = true;

/*============================== End of Configuration =================================*/

/**
 * Config must be returned - do not change it.
 */
return $config;
