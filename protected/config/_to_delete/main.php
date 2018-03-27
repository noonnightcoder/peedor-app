<?php

require_once( dirname(__FILE__) . '/../components/globals.php');
require_once( dirname(__FILE__) . '/../components/helpers.php');


// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');

// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
return array(
    'basePath' => dirname(__FILE__) . DIRECTORY_SEPARATOR . '..',
    'name' => Yii::t('app', 'Peedor System - Simply the Best'),
    'sourceLanguage' => 'en',
    //'language' => 'kh_kh',
    'timeZone' => 'Asia/Phnom_Penh',
    'aliases' => array(
        'bootstrap' => realpath(__DIR__ . '/../extensions/bootstrap'), // yiistrap configuration
        'yiiwheels' => realpath(__DIR__ . '/../extensions/yiiwheels'),
        //'ePdf' => realpath(__DIR__ . '/../extensions/yii-pdf'),
        //'RestfullYii' =>realpath(__DIR__ . '/../extensions/starship/RestfullYii'),
    ),
    // preloading 'log' component
    'preload' => array(
        'log',
    ),
    // auto-loading model and component classes
    'import' => array(
        'application.models.*',
        'application.components.*',
        'application.helpers.*', //helper for image extension
        'application.extensions.PasswordHash', // PHPass
        //'bootstrap.helpers.TbHtml', //application.extensions.bootstrap.helpers.TbHtml
        //'bootstrap.helpers.TbHtml', //application.extensions.bootstrap.helpers.TbHtml
        'bootstrap.helpers.*', //application.extensions.bootstrap.helpers.TbHtml
        'bootstrap.behaviors.*', //application.extensions.bootstrap.helpers.TbHtml
        'bootstrap.components.*', //application.extensions.bootstrap.helpers.TbHtml
        'bootstrap.widgets.*',
        'application.extensions.EExcelView.*',
        'application.modules.auth.*',
        'application.modules.auth.components.*',
    ),
    'theme' => 'ace',
    'modules' => array(
        // uncomment the following to enable the Gii to
        'gii' => array(
            'class' => 'system.gii.GiiModule',
            'password' => '123456',
            // If removed, Gii defaults to localhost only. Edit carefully to taste.
            'ipFilters' => array('127.0.0.1', '::1', '192.168.10.1'),
            'generatorPaths' => array('bootstrap.gii'),
        ),
        // Configure auth extension to use CDbAuthManager schema
        'auth' => array(
            'strictMode' => true, // when enabled authorization items cannot be assigned children of the same type.
            'userClass' => 'RbacUser', // the name of the user model class.
            'userIdColumn' => 'id', // the name of the user id column.
            'userNameColumn' => 'user_name', // the name of the user name column.
            'appLayout' => 'webroot.themes.ace.views.layouts.column1', // the layout used by the module.
            'viewDir' => null, // the path to view files to use with this module.
        ),
        // Configure backup db extension
        'backup' => array('path' => __DIR__ . '/../_backup/'),
    ),
    // application components
    'components' => array(
        // yiistrap configuration
        'bootstrap' => array(
            'class' => 'bootstrap.components.TbApi',
        ),
        // yiiwheels configuration
        'yiiwheels' => array(
            'class' => 'yiiwheels.YiiWheels',
        ),
        'shoppingCart' => array(
            'class' => 'ShoppingCart',
        ),
        'paymentCart' => array(
            'class' => 'PaymentCart',
        ),
        'rpaymentCart' => array(
            'class' => 'RpaymentCart',
        ),
        'receivingCart' => array(
            'class' => 'ReceivingCart',
        ),
        'reportCart' => array(
            'class' => 'ReportCart',
        ),
        'user' => array(
            // enable cookie-based authentication
            'allowAutoLogin' => true,
        ),
        // uncomment the following to enable URLs in path-format
        'urlManager' => array(
            'urlFormat' => 'path',
            //'showScriptName'=>false, //http://bit.ly/1exuqQf  LoadModule rewrite_module modules/mod_rewrite.so - D:\wamp\bin\apache\apache2.2.22\conf
            'rules' => array(
                '<controller:\w+>/<id:\d+>' => '<controller>/view',
                '<controller:\w+>/<action:\w+>/<id:\d+>' => '<controller>/<action>',
                '<controller:\w+>/<action:\w+>' => '<controller>/<action>',
            ),
        ),
        // uncomment the following to use a MySQL database
        'db' => array(
            'connectionString' => 'mysql:host=localhost;dbname=peedor_app',
            'emulatePrepare' => true,
            'username' => 'root',
            'password' => '',
            'charset' => 'utf8mb4',
            'schemaCachingDuration' => 180,
            'initSQLs' => array(
                "SET time_zone = '+7:00'" //for my country (Cambodia)
            ),
        ),
        'session' => array(
            //'class' => 'CCacheHttpSession',
            //'timeout' => 36000,
            'class' => 'CDbHttpSession',
            'connectionID' => 'db',
            'sessionTableName' => 'sessions',
        ),
//		'cache' => array(
//			'class' => 'CApcCache',
//		),
        'errorHandler' => array(
            // use 'site/error' action to display errors
            'errorAction' => 'site/error',
        ),
        'log' => array(
            'class' => 'CLogRouter',
            'routes' => array(
                array(
                    'class' => 'CFileLogRoute',
                    'levels' => 'error, warning',
                ),
                // uncomment the following to show log messages on web pages
                /*
                array(
                    'class'=>'CWebLogRoute',
                ),
                */
            ),
        ),
        'cache' => array(
            'class' => 'system.caching.CFileCache',
        ),
        'settings' => array(
            'class' => 'CmsSettings',
            'cacheComponentId' => 'cache',
            'cacheId' => 'global_website_settings',
            'cacheTime' => 84000,
            'tableName' => 'settings',
            'dbComponentId' => 'db',
            'createTable' => true,
            'dbEngine' => 'InnoDB',
        ),
        // Auth extension
        'authManager' => array(
            'class' => 'CDbAuthManager',
            'connectionID' => 'db',
            'behaviors' => array(
                'auth' => array(
                    'class' => 'auth.components.AuthBehavior',
                    //'admins' => array('admin'), // users with full access
                ),
            ),
        ),
        'user' => array(
            // enable cookie-based authentication
            //'allowAutoLogin'=>true,
            'loginRequiredAjaxResponse' => '<h3> Session had expired, re-login require </h3>',
            'class' => 'auth.components.AuthWebUser',
            'admins' => array('admin'),
            //'authTimeout'=>500,//5 minutes.
        ),
        'image' => array(
            'class' => 'application.extensions.image.CImageComponent',
            // GD or ImageMagick
            'driver' => 'GD',
            // ImageMagick setup path
            'params' => array('directory' => '/opt/local/bin'),
        ),
    ),
    // application-level parameters that can be accessed
    // using Yii::app()->params['paramName']
    'params' => require(dirname(__FILE__).'/params.php')
    //'catchAllRequest' => file_exists(dirname(__FILE__) . '/.maintenance.php') && !(isset($_COOKIE['secret']) && $_COOKIE['secret'] == "password") ? array('maintenance/index') : null,
);