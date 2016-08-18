<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class behaviorController extends Controller
{

    public function GetLang() {
        $Lang = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 4);
        //使用substr()截取字符串，从 0 位开始，截取4个字符
        if (preg_match('/zh-c/i',$Lang)) {
            //preg_match()正则表达式匹配函数
            $Lang = '简体中文';
        }
        elseif (preg_match('/zh/i',$Lang)) {
            $Lang = '繁體中文';
        }
        else {
            $Lang = 'English';
        }
        return $Lang;
    }
    public function GetBrowser() {
        $Browser = $_SERVER['HTTP_USER_AGENT'];
        if (preg_match('/MSIE/i',$Browser)) {
            $Browser = 'MSIE';
        }
        elseif (preg_match('/Firefox/i',$Browser)) {
            $Browser = 'Firefox';
        }
        elseif (preg_match('/Chrome/i',$Browser)) {
            $Browser = 'Chrome';
        }
        elseif (preg_match('/Safari/i',$Browser)) {
            $Browser = 'Safari';
        }
        elseif (preg_match('/Opera/i',$Browser)) {
            $Browser = 'Opera';
        }
        else {
            $Browser = 'Other';
        }
        return $Browser;
    }
    public function GetOS() {
        $OS = $_SERVER['HTTP_USER_AGENT'];
        if (preg_match('/win/i',$OS)) {
            $OS = 'Windows';
        }
        elseif (preg_match('/mac/i',$OS)) {
            $OS = 'MAC';
        }
        elseif (preg_match('/linux/i',$OS)) {
            $OS = 'Linux';
        }
        elseif (preg_match('/unix/i',$OS)) {
            $OS = 'Unix';
        }
        elseif (preg_match('/bsd/i',$OS)) {
            $OS = 'BSD';
        }
        else {
            $OS = 'Other';
        }
        return $OS;
    }
    public function GetIP() {
        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
            //如果变量是非空或非零的值，则 empty()返回 FALSE。
            $IP = explode(',',$_SERVER['HTTP_CLIENT_IP']);
        }
        elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $IP = explode(',',$_SERVER['HTTP_X_FORWARDED_FOR']);
        }
        elseif (!empty($_SERVER['REMOTE_ADDR'])) {
            $IP = explode(',',$_SERVER['REMOTE_ADDR']);
        }
        else {
            $IP[0] = 'None';
        }
        return $IP[0];
    }
    private function GetAddIsp() {
        $IP = $this->GetIP();
        //API控制台申请得到的ak（此处ak值仅供验证参考使用）
        $ak = 'ead1hzlvCbQFwCtsQmWGWqz4gPkFI401';


        $AddIsp = mb_convert_encoding(file_get_contents('http://api.map.baidu.com/location/ip?ak='.$ak.'&ip='.$IP),'UTF-8','GBK');
        //mb_convert_encoding() 转换字符编码。
        dd($AddIsp);
        if(preg_match('/noresult/i',$AddIsp)) {
            $AddIsp = 'None';
        } else {
            $Sta = stripos($AddIsp,$IP) + strlen($IP) + strlen('来自');
            $Len = stripos($AddIsp,'"}')-$Sta;
            $AddIsp = substr($AddIsp,$Sta,$Len);
        }
        $AddIsp = explode(' ',$AddIsp);
        return $AddIsp;
    }

    public function baiDuMap()
    {
        $IP = $this->GetIP();
        //API控制台申请得到的ak（此处ak值仅供验证参考使用）
        $ak = 'ead1hzlvCbQFwCtsQmWGWqz4gPkFI401';
        $AddIsp = mb_convert_encoding(file_get_contents('http://api.map.baidu.com/location/ip?ak='.$ak.'&ip='.$IP),'UTF-8','GBK');
        $AddIsp = json_decode($AddIsp,true);
        if ($AddIsp['status'] != 0) {
            $AddIsp = [
                  "address" => "",
                  "content" => [
                    "address_detail" => [
                      "province" => "",
                      "city" => "",
                      "district" => "",
                      "street" => "",
                      "street_number" => "",
                      "city_code" => ""
                    ],
                    "address" => "",
                    "point" => [
                      "y" => "",
                      "x" => "",
                    ]
                  ],
                  "status" => 0
                ];
        }

        return $AddIsp;
    }

    public function GetXY()
    {
        return $this->baiDuMap()['content']['point'];
    }

    public function GetAddress()
    {
        $map = $this->baiDuMap();

        $data['province'] = $map['content']['address_detail']['province'];
        $data['city'] = $map['content']['address_detail']['city'];
        $data['district'] = $map['content']['address_detail']['district'];
        $data['street'] = $map['content']['address_detail']['street'];
        $data['street_number'] = $map['content']['address_detail']['street_number'];
        $data['address'] = $map['address'];
        return $data;
    }

    public function GetAdd() {
        $Add = $this->GetAddIsp();
        return $Add[0];
    }
    public function GetIsp() {
        $Isp = $this->GetAddIsp();
        if ($Isp[0] != 'None' && isset($Isp[1])) {
            $Isp = $Isp[1];
        }
        else {
            $Isp = 'None';
        }
        return $Isp;
    }
}
