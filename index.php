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
/* 默认状态下的 walBox（首页壁纸模式）保持原样或相对定位 */
#walBox {
    position: relative;
    width: 100%;
    margin: 0 auto;
    z-index: 1;
}

/* 当处于“每日一言”模式时，通过父级类名控制居中 */
body.hitokoto-mode #walBox {
    position: fixed !important; 
    top: 50% !important;        
    left: 50% !important;       
    transform: translate(-50%, -50%) !important; 
    
    width: auto !important;
    min-width: 80vw;            
    height: auto !important;
    
    display: flex !important;
    justify-content: center !important;
    align-items: center !important;
    
    z-index: 9999;              
    pointer-events: none;       
    margin: 0 !important;
    padding: 0 !important;
}

/* 每日一言内容容器 */
.hitokoto-container {
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    background: transparent !important;
    border: none !important;
    box-shadow: none !important;
    width: 100%;
    text-align: center;
    pointer-events: auto;
}

/* 放大主句并设置彩色渐变 */
#line-en {
    font-size: 68px; 
    font-weight: 900;
    margin-bottom: 30px;
    padding: 0 20px;
    display: block;
    line-height: 1.2;
    background: linear-gradient(135deg, #FF3CAC 0%, #784BA0 50%, #2B86C5 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    filter: drop-shadow(0 4px 10px rgba(0,0,0,0.1));
}

/* 来源文字样式 */
#line-cn {
    font-size: 24px;
    color: #444;
    letter-spacing: 4px;
    font-weight: 500;
    opacity: 0.8;
}

#line-cn::before {
    content: "——";
    margin-right: 15px;
}

/* 动画效果 */
.animate__fadeIn {
    animation: centerZoomIn 1.2s cubic-bezier(0.19, 1, 0.22, 1) both;
}

@keyframes centerZoomIn {
    0% { opacity: 0; transform: scale(0.9); }
    100% { opacity: 1; transform: scale(1); }
}

/* 移动端适配 */
@media (max-width: 768px) {
    #line-en { font-size: 32px; }
    #line-cn { font-size: 18px; }
    body.hitokoto-mode #walBox { width: 95vw !important; }
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
