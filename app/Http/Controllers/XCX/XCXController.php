<?php

/*
 * 微信小程序（测试）
 */
namespace App\Http\Controllers\XCX;

use App\Http\Controllers\Controller;

class XCXController extends Controller
{
    public function index()
    {
        $signature = $_GET["signature"];
        $timestamp = $_GET["timestamp"];
        $nonce = $_GET["nonce"];
        $echostr = $_GET["echostr"];
        $token = "xyzkoko";
        $tmpArr = array($token, $timestamp, $nonce);
        sort($tmpArr, SORT_STRING);
        $tmpStr = implode( $tmpArr );
        $tmpStr = sha1( $tmpStr );
        if( $tmpStr == $signature ){
            return $echostr;
        }else{
            return false;
        }
    }
}
