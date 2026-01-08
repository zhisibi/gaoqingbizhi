<?php
function is_https() {
    if ( !empty($_SERVER['HTTPS']) && strtolower($_SERVER['HTTPS']) !== 'off') {
        return true;
    } elseif ( isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] === 'https' ) {
        return true;
    } elseif ( !empty($_SERVER['HTTP_FRONT_END_HTTPS']) && strtolower($_SERVER['HTTP_FRONT_END_HTTPS']) !== 'off') {
        return true;
    }
    return false;
}
?>
<!doctype html>
<html>
<head>
<style>
/* 每日一句容器样式 - 清新毛玻璃风格 */
.hitokoto-container {
    padding: 80px 30px;
    text-align: center;
    color: #333; /* 文字改为深灰色，更清新 */
    
    /* 清新毛玻璃效果 */
    background: rgba(255, 255, 255, 0.4); 
    backdrop-filter: blur(10px); 
    -webkit-backdrop-filter: blur(10px);
    
    border: 1px solid rgba(255, 255, 255, 0.5);
    border-radius: 20px;
    margin: 40px auto;
    max-width: 800px;
    box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.1); /* 淡淡的阴影 */
}

#line-en {
    font-size: 26px;
    font-weight: 500;
    margin-bottom: 20px;
    display: block;
    line-height: 1.5;
    /* 给文字加一点微弱的亮光感 */
    text-shadow: 0 1px 2px rgba(255,255,255,0.5);
}

#line-cn {
    font-size: 16px;
    color: #666;
    letter-spacing: 1px;
    font-style: italic;
}

/* 入场动画效果 */
.animate__fadeIn {
    animation: fadeIn 1s ease-in-out;
}

@keyframes fadeIn {
    from { opacity: 0; transform: translateY(10px); }
    to { opacity: 1; transform: translateY(0); }
}
</style>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>高清壁纸</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <?php
    if(is_https()){
        echo "<meta http-equiv=\"Content-Security-Policy\" content=\"upgrade-insecure-requests\">";
    }
    ?>
    <meta name="robots" content="index,follow"/>
    <meta name="referrer" content="no-referrer" />
    <link rel="stylesheet" href="css/wallpaper.css">
    <link rel="stylesheet" href="https://cdn.staticfile.org/twitter-bootstrap/4.3.1/css/bootstrap.min.css">
</head>
<body>
<nav class="navbar navbar-expand-sm xben-nav  navbar-light fixed-top">
    <a class="navbar-brand xben-title" href="https://www.yydsym.com" >在线壁纸</a>
    <button class="navbar-toggler xben-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse " id="collapsibleNavbar">
        <ul class="navbar-nav">
            <form class="form-inline xben-from">
                <input class="form-control text-360" id="360text" type="text" placeholder="请输入关键字">
                <button class="btn btn-primary " id="xbenSearchBtn" type="button"
                        onclick="loadData360Search();changeTitle(this)">壁纸一下
                </button>
            </form>
            <li class="nav-item">
                <a class="nav-link" href="javascript:void(0)"
                   onclick="loadData('360new', true);changeTitle(this)">最新壁纸</a>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbardrop" data-toggle="dropdown">
                    分类壁纸
                </a>
                <div class="dropdown-menu xben-dropdown-menu" id="xbenTags">

                </div>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="javascript:void(0)"
                   onclick="loadData('bing', true);changeTitle(this)">必应美图</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="javascript:void(0)" onclick="loadData('ciba', true);changeTitle(this);"
                   title="每日一言">每日一言</a>
            </li>
            <!--<li class="nav-item">
                <a class="nav-link" href="https://www.yydsym.com" target="_blank">YYDS源码网</a>
            </li>-->
 
        </ul>

    </div>
</nav>
<div class="xben-container">

    <div class="jigsaw" id="walBox"></div>  <!-- id="walBox" -->

    <a id="toolBall" target="_blank" href="javascript:void(0);" class="uptoTop"></a>

    <div id="loadmore">壁纸加载中……</div>
	<div class="xben-full-img"><img
            src="http://cdn-ali-img-staticbz.shanhutech.cn/bizhi/staticwp/202003/9bd0be8ab5506a7902f36eb4da95ebc1--3977944025.jpg"/>
    <button class="horizontal-btn btn btn-primary">横屏显示</button>
</div>
</div>
<!-- jQuery文件 -->
<script src="https://cdn.bootcss.com/jquery/1.11.3/jquery.min.js"></script>
<!--滚动加载插件-->
<script type="text/javascript" src="js/jquery.lazyload.min.js"></script>
<!--全屏滚动插件-->
<script type="text/javascript" src="js/jquery.onepage-scroll.min.js"></script>
<!--页面核心js文件-->
<script type="text/javascript" src="js/wallpaper.js"></script>
<script src="https://cdn.staticfile.org/twitter-bootstrap/4.3.1/js/bootstrap.min.js"></script>
</body>
