<?php

/**
 * This is the shortcut to DIRECTORY_SEPARATOR
 */
defined('DS') or define('DS', DIRECTORY_SEPARATOR);

/**
 * This is the shortcut to Yii::app()
 */
function app()
{
    return Yii::app();
}

/**
 * This is the shortcut to Yii::app()->clientScript
 */
function cs()
{
// You could also call the client script instance via Yii::app()->clientScript
// But this is faster
    return Yii::app()->getClientScript();
}

/**
 * This is the shortcut to Yii::app()->user.
 */
function user()
{
    return Yii::app()->getUser();
}

/**
 * This is the shortcut to Yii::app()->createUrl()
 */
function url($route, $params = array(), $ampersand = '&')
{
    return Yii::app()->createUrl($route, $params, $ampersand);
}

/**
 * This is the shortcut to CHtml::encode
 */
function h($text)
{
    return htmlspecialchars($text, ENT_QUOTES, Yii::app()->charset);
}

/**
 * This is the shortcut to CHtml::link()
 */
function l($text, $url = '#', $htmlOptions = array())
{
    return CHtml::link($text, $url, $htmlOptions);
}

/**
 * This is the shortcut to Yii::t() with default category = 'stay'
 */
function t($message, $category = 'stay', $params = array(), $source = null, $language = null)
{
    return Yii::t($category, $message, $params, $source, $language);
}

/**
 * This is the shortcut to Yii::app()->request->baseUrl
 * If the parameter is given, it will be returned and prefixed with the app baseUrl.
 */
function bu($url = null)
{
    static $baseUrl;
    if ($baseUrl === null)
        $baseUrl = Yii::app()->getRequest()->getBaseUrl();
    return $url === null ? $baseUrl : $baseUrl . '/' . ltrim($url, '/');
}

/**
 * Returns the named application parameter.
 * This is the shortcut to Yii::app()->params[$name].
 */
function param($name)
{
    return Yii::app()->params[$name];
}

/**
 * Return the base_url path
 * This is the shortcut to Yii::app()->theme->baseUrl
 */
function baseurl(){
    return Yii::app()->theme->baseUrl;
}

function ckacc($permission) {
    return Yii::app()->user->checkAccess($permission);
}

function loadview($view_name,$partial_view='_grid',$data) {
    if (Yii::app()->request->isAjaxRequest) {

        //Yii::app()->clientScript->scriptMap['*.js'] = false;
        $cs = Yii::app()->clientScript;
        $cs->scriptMap = array(
            'jquery.js' => false,
            'bootstrap.js' => false,
            'jquery.min.js' => false,
            'bootstrap.notify.js' => false,
            'bootstrap.bootbox.min.js' => false,
            'bootstrap.min.js' => false,
            'jquery-ui.min.js' => false,
            //'EModalDlg.js'=>false,
        );

        Yii::app()->clientScript->scriptMap['jquery-ui.css'] = false;
        Yii::app()->clientScript->scriptMap['box.css'] = false;
        Yii::app()->controller->renderPartial($partial_view, $data, false, true);

    } else {
        Yii::app()->controller->render($view_name, $data);
    }
}

function ajaxRequest() {
    if (!Yii::app()->request->isAjaxRequest) {
        throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
    }
}

function authorized($permission)
{
    if (!ckacc($permission)) {
        Yii::app()->controller->redirect(array('site/ErrorException', 'err_no' => 403));
    }
}