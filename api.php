<?php

// --- 配置区 ---
// 注意：在代码中，IPv6 的作用域标识通常直接使用 %eth0，而不是命令行里的 %25eth0
$proxy_url = "tcp://[fe80::1%eth0]:8888"; 
// --------------

$cid = getParam('cid', '360new');

switch($cid)
{
    case '360new':  // 360壁纸 新图片
        $start = getParam('start', 0);
        $count = getParam('count', 10);
        $url = "http://wp.birdpaper.com.cn/intf/newestList?pageno={$start}&count={$count}";
        echojson(fetchData($url, $proxy_url));
    break;

    case '360tags':
        $url = "http://wp.birdpaper.com.cn/intf/getCategory";
        echojson(fetchData($url, $proxy_url));
    break;
    
    case 'bing':
        $start = getParam('start', -1);
        $count = getParam('count', 8);
        $url = "http://cn.bing.com/HPImageArchive.aspx?format=js&idx={$start}&n={$count}";
        echojson(fetchData($url, $proxy_url));
    break;
    
    case '360search':
        $content = getParam('content', '');
        $start = getParam('start', 0);
        $count = getParam('count', 10);
        $url = "http://wp.birdpaper.com.cn/intf/search?content={$content}&pageno={$start}&count={$count}";
        echojson(fetchData($url, $proxy_url));
    break;
    
    default:
        $start = getParam('start', 0);
        $count = getParam('count', 10);
        $url = "http://wp.birdpaper.com.cn/intf/GetListByCategory?cids={$cid}&pageno={$start}&count={$count}";
        echojson(fetchData($url, $proxy_url));
}

/**
 * 核心修复：通过代理获取远程数据
 */
function fetchData($url, $proxy)
{
    $opts = [
        "http" => [
            "proxy" => $proxy,
            "request_fulluri" => true,
            "timeout" => 10, // 设置10秒超时
            "header" => "User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36\r\n"
        ]
    ];
    
    $context = stream_context_create($opts);
    
    // 使用 @ 符号抑制警告，通过返回值判断错误
    $result = @file_get_contents($url, false, $context);
    
    if ($result === false) {
        // 如果失败，返回一个标准的 JSON 错误提示
        return json_encode(["error" => "无法连接远程服务器", "debug_url" => $url]);
    }
    
    return $result;
}

/**
 * 获取GET或POST过来的参数
 */
function getParam($key, $default='')
{
    return trim($key && is_string($key) ? (isset($_POST[$key]) ? $_POST[$key] : (isset($_GET[$key]) ? $_GET[$key] : $default)) : $default);
}

/**
 * 输出内容
 */
function echojson($data)
{
    header('Content-Type: application/json; charset=utf-8');
    echo $data;
}