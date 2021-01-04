<?php
namespace app\Tools;

class Visit
{
    public function __construct()
    {

    }

    public static function GetLang()
    {
        $Lang = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 4);
        //使用substr()截取字符串，从 0 位开始，截取4个字符
        if (preg_match('/zh-c/i', $Lang)) {
            //preg_match()正则表达式匹配函数
            $Lang = '简体中文';
        } elseif (preg_match('/zh/i', $Lang)) {
            $Lang = '繁體中文';
        } else {
            $Lang = 'English';
        }
        return $Lang;
    }

    public static function GetBrowser()
    {
        $agent = $_SERVER['HTTP_USER_AGENT'];
        if (strpos($agent, "MSIE 9.0")) {
            $browser = "Internet Explorer 9.0";
        } elseif (strpos($agent, "MSIE 8.0")) {
            $browser = "Internet Explorer 8.0";
        } elseif (strpos($agent, "MSIE 7.0")) {
            $browser = "Internet Explorer 7.0";
        } elseif (strpos($agent, "MSIE 6.0")) {
            $browser = "Internet Explorer 6.0";
        } elseif (strpos($agent, "Firefox/4")) {
            $browser = "Firefox 4";
        } elseif (strpos($agent, "Firefox/3")) {
            $browser = "Firefox 3";
        } elseif (strpos($agent, "Firefox/2")) {
            $browser = "Firefox 2";
        } elseif (strpos($agent, "Chrome")) {
            $browser = "Google Chrome";
        } elseif (strpos($agent, "Safari")) {
            $browser = "Safari";
        } elseif (strpos($agent, "Opera")) {
            $browser = "Opera";
        } else {
            $browser = $_SERVER["HTTP_USER_AGENT"];
        }
        return $browser;
    }

    public static function GetOS()
    {
        $agent = $_SERVER['HTTP_USER_AGENT'];
        if (preg_match('/win/i', $agent) && strpos($agent, '95')) {
            $os = 'Windows 95';
        } elseif (preg_match('/win 9x/i', $agent) && strpos($agent, '4.90')) {
            $os = 'Windows ME';
        } elseif (preg_match('/win/i', $agent) && preg_match('/98/', $agent)) {
            $os = 'Windows 98';
        } elseif (preg_match('/win/i', $agent) && preg_match('/nt 6.1/i', $agent)) {
            $os = 'Windows 7';
        } elseif (strpos($agent, 'nt 6.0') !== false) {
            $os = 'Windows Vista';
        } elseif (preg_match('/win/i', $agent) && preg_match('/nt 5.1/i', $agent)) {
            $os = 'Windows XP';
        } elseif (preg_match('/win/i', $agent) && preg_match('/nt 5/i', $agent)) {
            $os = 'Windows 2000';
        } elseif (preg_match('/win/i', $agent) && preg_match('/nt/i', $agent)) {
            $os = 'Windows NT';
        } elseif (preg_match('/win/i', $agent) && preg_match('/32/', $agent)) {
            $os = 'Windows 32';
        } elseif (preg_match('/linux/i', $agent)) {
            $os = 'Linux';
        } elseif (preg_match('/unix/i', $agent)) {
            $os = 'Unix';
        } elseif (preg_match('/sun/i', $agent) && preg_match('/os/i', $agent)) {
            $os = 'SunOS';
        } elseif (preg_match('/ibm/i', $agent) && preg_match('/os/i', $agent)) {
            $os = 'IBM OS/2';
        } elseif (preg_match('/Mac/i', $agent) && preg_match('/PC/i', $agent)) {
            $os = 'Macintosh';
        } elseif (preg_match('/PowerPC/i', $agent)) {
            $os = 'PowerPC';
        } elseif (preg_match('/AIX/i', $agent)) {
            $os = 'AIX';
        } elseif (preg_match('/HPUX/i', $agent)) {
            $os = 'HPUX';
        } elseif (preg_match('/NetBSD/i', $agent)) {
            $os = 'NetBSD';
        } elseif (preg_match('/BSD/i', $agent)) {
            $os = 'BSD';
        } elseif (preg_match('/OSF1/', $agent)) {
            $os = 'OSF1';
        } elseif (preg_match('/IRIX/', $agent)) {
            $os = 'IRIX';
        } elseif (preg_match('/FreeBSD/i', $agent)) {
            $os = 'FreeBSD';
        } elseif (preg_match('/teleport/i', $agent)) {
            $os = 'teleport';
        } elseif (preg_match('/flashget/i', $agent)) {
            $os = 'flashget';
        } elseif (preg_match('/webzip/i', $agent)) {
            $os = 'webzip';
        } elseif (preg_match('/offline/i', $agent)) {
            $os = 'offline';
        } else {
            $os = 'Unknown';
        }
        return $os;
    }

    public static function GetIP()
    {
        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
            //如果变量是非空或非零的值，则 empty()返回 FALSE。
            $IP = explode(',', $_SERVER['HTTP_CLIENT_IP']);
        } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $IP = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);
        } elseif (!empty($_SERVER['REMOTE_ADDR'])) {
            $IP = explode(',', $_SERVER['REMOTE_ADDR']);
        } else {
            $IP[0] = 'None';
        }
        return $IP[0];
    }

    public static function GetAccessTime($url)
    {

    }

    private function GetAddIsp()
    {
        $IP = $this->GetIP();
        $AddIsp = mb_convert_encoding(file_get_contents('http://open.baidu.com/ipsearch/s?tn=ipjson&wd=' . $IP), 'UTF-8', 'GBK');
        //mb_convert_encoding() 转换字符编码。
        if (preg_match('/noresult/i', $AddIsp)) {
            $AddIsp = 'None';
        } else {
            $Sta = stripos($AddIsp, $IP) + strlen($IP) + strlen('来自');
            $Len = stripos($AddIsp, '"}') - $Sta;
            $AddIsp = substr($AddIsp, $Sta, $Len);
        }
        $AddIsp = explode(' ', $AddIsp);
        return $AddIsp;
    }

    public static function GetAdd()
    {
        $Add = self::GetAddIsp();
        return $Add[0];
    }

    public static function GetIsp()
    {
        $Isp = self::GetAddIsp();
        if ($Isp[0] != 'None' && isset($Isp[1])) {
            $Isp = $Isp[1];
        } else {
            $Isp = 'None';
        }
        return $Isp;
    }
}

?>