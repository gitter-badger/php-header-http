<?php
/**
 * Created by PhpStorm.
 * User: ec
 * Date: 24.06.15
 * Time: 14:29
 * Project: header-http
 * @author: Evgeny Pynykh bpteam22@gmail.com
 */

namespace bpteam\HttpHeader;


class HttpHeader {

    protected static $redirectCode = [
        300 => null,
        301 => null,
        302 => null,
        303 => null,
        304 => null,
        305 => null,
        306 => null,
        307 => null,
    ];

    const TYPE_CONTENT_TEXT = 'text';
    const TYPE_CONTENT_IMG = 'img';
    const TYPE_CONTENT_HTML = 'html';
    const TYPE_CONTENT_FILE = 'file';

    public static function cutHeader(&$answer){
        $header = array();
        if($answer){
            while(preg_match('%(?<head>^[^<>]*HTTP/\d+\.\d+.*)(\r\n\r\n|\r\r|\n\n)%Ums',$answer,$data)){
                $header[] = $data['head'];
                $answer = ltrim(preg_replace('%'.preg_quote($data['head'],'%').'%ims', '', $answer));
            }
        }
        return $header;
    }

    public static function checkMimeType($mime, $type) {
        switch ($type) {
            case self::TYPE_CONTENT_FILE:
                return true;
            case self::TYPE_CONTENT_IMG:
                return preg_match('%image/(gif|p?jpeg|png|svg\+xml|tiff|vnd\.microsoft\.icon|vnd\.wap\.wbmp)%i', $mime);
            case self::TYPE_CONTENT_HTML:
                return (preg_match('%text/html%i', $mime));
            default:
                return true;
        }
    }

    public static function isRedirect($code){
        return isset(self::$redirectCode[$code]);
    }

    /**
     * Проверает HTTP код ответа на запрос
     * @url http://goo.gl/KKiFi
     * @param int $code
     * @return bool
     * @internal в будущем планируется вести лог с ошибками и из этой функции будет записываться ошибки
     * @internal в запросах и дополнительо будет приниматься решения больше на посылать заросы на текуший URL
     * @internal Пример: Если вернуло ошибку 500, то не повторять запрос
     */
    public static function checkCode($code) {
        switch ((int)$code) {
            case 200 || 201 || 202 || 203 || 204 || 205 || 206 || 207 || 208 || 226 || 300 || 301 || 302 || 304 || 305 || 306 || 307 || 400 || 403 || 404 || 405 || 406:
                return true;
            default:
                return false;
        }
    }
}