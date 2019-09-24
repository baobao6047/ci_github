<?php

function callback_success($data = null)
{
    $ret['success'] = true;
    if ($data !== null) {
        $ret['data'] = $data;
    }

    $json = json_encode($ret);
    die(isset($_GET['callback']) ? $_GET['callback'] . "($json)" : $json);

}

function callback_error($data = null)
{
    $ret['success'] = false;
    if ($data !== null) {
        $ret['data'] = $data;
    }

    $json = json_encode($ret);
    die(isset($_GET['callback']) ? $_GET['callback'] . "($json)" : $json);
}

/**
 * 获取IP地址
 *
 * @param $format 返回IP格式
 *            string（默认）表示传统的127.0.0.1，int或其它表示转化为整型，便于存放到数据库字段
 * @param $side IP来源
 *            client（默认）表示客户端，server或其它表示服务端
 * @return string or int
 */
function ip($format = 'string', $side = 'client')
{
    if ($side === 'client') {
        static $_client_ip = null;
        if ($_client_ip === null) {
            // 获取客户端IP地址
            $ci = &get_instance();
            $_client_ip = $ci->input->ip_address();
        }
        $ip = $_client_ip;
    } else {
        static $_server_ip = null;
        if ($_server_ip === null) {
            // 获取服务器IP地址
            if (isset($_SERVER)) {
                if ($_SERVER['SERVER_ADDR']) {
                    $_server_ip = $_SERVER['SERVER_ADDR'];
                } else {
                    $_server_ip = $_SERVER['LOCAL_ADDR'];
                }
            } else {
                $_server_ip = getenv('SERVER_ADDR');
            }
        }
        $ip = $_server_ip;
    }
    return $format === 'string' ? $ip : bindec(decbin(ip2long($ip)));
}

function soap_call($url, $data = null, $esolve = false, $use_cert = false)
{
    try {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); //将curl_exec()获取的信息以文件流的形式返回，而不是直接输出。
        curl_setopt($ch, CURLOPT_TIMEOUT, 15);
        if ($data) {
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        }

        if($use_cert == true){
            $sslCertPath = SSLCERTPATH;
            $sslKeyPath = SSLKEYPATH;
            curl_setopt($ch,CURLOPT_SSLCERTTYPE,'PEM');
            curl_setopt($ch,CURLOPT_SSLCERT, $sslCertPath);
            curl_setopt($ch,CURLOPT_SSLKEYTYPE,'PEM');
            curl_setopt($ch,CURLOPT_SSLKEY, $sslKeyPath);
        }

        $output = curl_exec($ch);
        if ($esolve) {
            $output = json_decode($output, true);
        }
        curl_close($ch);
    } catch (Exception $e) {
        $this->error = $e->getMessage();
        return false;
    }
    return $output;
}