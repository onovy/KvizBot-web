<?php
/**
 * Modul s konverzni tabulkou MIME dat
 *
 * @category    Module
 * @package     Module
 * @author      onovy <onovy@nomi.cz>
 */

/*
 * V tomto souboru jsou pouΎity θαsti kσdu a grafickι obrαzky z projektu
 * PHP Advanced Transfer Manager (http://phpatm.free.fr/) licencovanύ
 * podle licence GNU GPL 2
 */

// Security
if (!defined('ONOVY_PHP_LIB')) die;

define('MODULE_MIME',1);

$mimetypes = array (
'txt'  => array('img' => 'txt.gif',    'mime' => 'text/plain'),
'html' => array('img' => 'html.gif',   'mime' => 'text/html'),
'htm'  => array('img' => 'html.gif',   'mime' => 'text/html'),
'doc'  => array('img' => 'doc.gif',    'mime' => 'application/msword'),
'pdf'  => array('img' => 'pdf.gif',    'mime' => 'application/pdf'),
'xls'  => array('img' => 'xls.gif',    'mime' => 'application/msexcel'),
'gif'  => array('img' => 'gif.gif',    'mime' => 'image/gif'),
'jpg'  => array('img' => 'jpg.gif',    'mime' => 'image/jpeg'),
'jpeg' => array('img' => 'jpg.gif',    'mime' => 'image/jpeg'),
'bmp'  => array('img' => 'bmp.gif',    'mime' => 'image/bmp'),
'png'  => array('img' => 'gif.gif',    'mime' => 'image/png'),
'zip'  => array('img' => 'zip.gif',    'mime' => 'application/zip'),
'rar'  => array('img' => 'rar.gif',    'mime' => 'application/x-rar-compressed'),
'gz'   => array('img' => 'zip.gif',    'mime' => 'application/x-compressed'),
'tgz'  => array('img' => 'zip.gif',    'mime' => 'application/x-compressed'),
'z'    => array('img' => 'zip.gif',    'mime' => 'application/x-compress'),
'exe'  => array('img' => 'exe.gif',    'mime' => 'application/x-msdownload'),
'mid'  => array('img' => 'mid.gif',    'mime' => 'audio/mid'),
'midi' => array('img' => 'mid.gif',    'mime' => 'audio/mid'),
'wav'  => array('img' => 'wav.gif',    'mime' => 'audio/x-wav'),
'mp3'  => array('img' => 'mp3.gif',    'mime' => 'audio/x-mpeg'),
'avi'  => array('img' => 'avi.gif',    'mime' => 'video/x-msvideo'),
'mpg'  => array('img' => 'mpg.gif',    'mime' => 'video/mpeg'),
'mpeg' => array('img' => 'mpg.gif',    'mime' => 'video/mpeg'),
'mov'  => array('img' => 'avi.gif',    'mime' => 'video/quicktime'),
'swf'  => array('img' => 'flash.gif',  'mime' => 'application/x-shockwave-flash'),
'gtar' => array('img' => 'rar.gif',    'mime' => 'application/x-gtar'),
'tar'  => array('img' => 'rar.gif',    'mime' => 'application/x-tar'),
'tiff' => array('img' => 'defaut.gif', 'mime' => 'image/tiff'),
'tif'  => array('img' => 'defaut.gif', 'mime' => 'image/tiff'),
'rtf'  => array('img' => 'doc.gif',    'mime' => 'application/rtf'),
'eps'  => array('img' => 'defaut.gif', 'mime' => 'application/postscript'),
'ps'   => array('img' => 'defaut.gif', 'mime' => 'application/postscript'),
'qt'   => array('img' => 'avi.gif'  ,  'mime' => 'video/quicktime'),
''     => array('img' => 'defaut.gif', 'mime' => 'application/octet-stream')
);

/**
 * Podle pripony souboru vraci obrazek k zobrazeni (ikonka)
 *
 * @param $filename - jmeno souboru
 * @return nazev obrazku
 */
function get_img_by_filename($filename)
{
    global $mimetypes;
    
    $filename=explode('.',$filename);
    $filename=strtolower($filename[count($filename)-1]);

    reset($mimetypes);
    foreach ($mimetypes as $k=>$v) {
    	if ($k == $filename) {
    	    return $v['img'];
	}
    }
    return $mimetypes['']['img'];
}

?>