<?php
//error_reporting(0);
class Handsome_Config
{
	const COMMENT_SYSTEM_ROOT = 0;
	const COMMENT_SYSTEM_CHANGYAN = 1;
	const COMMENT_SYSTEM_OTHERS = 2;
	const COMMENT_SYSTEM_NONE = 3;
	//public static $handsome = "5fdde5e20ce9a362749963181c4329f2";
	//public static $handsome_check = "daf365174b79ae87d37c6fed91b9ed3d";
	//public static $root = "aHR0cHM6Ly9hdXRoLmloZXdyby5jb20v";
	//public static $root_use = "aHR0cHM6Ly9hdXRoLmloZXdyby5jb20vdXNlci9ub3RpY2Uy";
	const notice = "";
	public static $versionTag = "20191205";
	const PHP_ERROR_DISPLAY = 'off';
	const HANDSOME_DEBUG_DISPLAY = 'off';
	const NORMAL_PLACEHOLDER = 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAYAAAAfFcSJAAABS2lUWHRYTUw6Y29tLmFkb2JlLnhtcAAAAAAAPD94cGFja2V0IGJlZ2luPSLvu78iIGlkPSJXNU0wTXBDZWhpSHpyZVN6TlRjemtjOWQiPz4KPHg6eG1wbWV0YSB4bWxuczp4PSJhZG9iZTpuczptZXRhLyIgeDp4bXB0az0iQWRvYmUgWE1QIENvcmUgNS42LWMxMzggNzkuMTU5ODI0LCAyMDE2LzA5LzE0LTAxOjA5OjAxICAgICAgICAiPgogPHJkZjpSREYgeG1sbnM6cmRmPSJodHRwOi8vd3d3LnczLm9yZy8xOTk5LzAyLzIyLXJkZi1zeW50YXgtbnMjIj4KICA8cmRmOkRlc2NyaXB0aW9uIHJkZjphYm91dD0iIi8+CiA8L3JkZjpSREY+CjwveDp4bXBtZXRhPgo8P3hwYWNrZXQgZW5kPSJyIj8+IEmuOgAAAA1JREFUCJljePfx038ACXMD0ZVlJAYAAAAASUVORK5CYII=';
	const OPACITY_PLACEHOLDER = 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAYAAAAfFcSJAAABS2lUWHRYTUw6Y29tLmFkb2JlLnhtcAAAAAAAPD94cGFja2V0IGJlZ2luPSLvu78iIGlkPSJXNU0wTXBDZWhpSHpyZVN6TlRjemtjOWQiPz4KPHg6eG1wbWV0YSB4bWxuczp4PSJhZG9iZTpuczptZXRhLyIgeDp4bXB0az0iQWRvYmUgWE1QIENvcmUgNS42LWMxMzggNzkuMTU5ODI0LCAyMDE2LzA5LzE0LTAxOjA5OjAxICAgICAgICAiPgogPHJkZjpSREYgeG1sbnM6cmRmPSJodHRwOi8vd3d3LnczLm9yZy8xOTk5LzAyLzIyLXJkZi1zeW50YXgtbnMjIj4KICA8cmRmOkRlc2NyaXB0aW9uIHJkZjphYm91dD0iIi8+CiA8L3JkZjpSREY+CjwveDp4bXBtZXRhPgo8P3hwYWNrZXQgZW5kPSJyIj8+IEmuOgAAAA1JREFUCJljOHz4cAMAB2ACypfyMOEAAAAASUVORK5CYII=';
	const AUTH = "thx";
	public static $BOOT_CDN = array("css" => array("bootstrap" => 'https://cdn.bootcss.com/bootstrap/3.3.4/css/bootstrap.min.css', "mdui" => 'https://cdn.bootcss.com/mdui/0.4.0/css/mdui.min.css'), "js" => array("bootstrap" => 'https://cdn.bootcss.com/bootstrap/3.3.4/js/bootstrap.min.js', "jquery" => 'https://cdn.bootcss.com/jquery/2.1.4/jquery.min.js', "mdui" => 'https://cdn.bootcss.com/mdui/0.4.0/js/mdui.min.js', "mathjax" => 'https://cdn.bootcss.com/mathjax/2.7.0/MathJax.js', 'mathjax_svg' => 'https://cdn.bootcss.com/mathjax/2.7.0/config/TeX-AMS-MML_SVG.js'));
	public static $BAIDU_CDN = array("css" => array("bootstrap" => 'https://apps.bdimg.com/libs/bootstrap/3.3.4/css/bootstrap.min.css', "mdui" => 'https://cdn.jsdelivr.net/npm/mdui@0.4.1/dist/css/mdui.min.css'), "js" => array("bootstrap" => 'https://apps.bdimg.com/libs/bootstrap/3.3.4/js/bootstrap.min.js', "jquery" => 'https://apps.bdimg.com/libs/jquery/2.1.4/jquery.min.js', "mdui" => 'https://cdn.jsdelivr.net/npm/mdui@0.4.1/dist/js/mdui.min.js', "mathjax" => 'https://cdn.staticfile.org/mathjax/2.7.0/MathJax.js', 'mathjax_svg' => 'https://cdn.staticfile.org/mathjax/2.7.0/config/TeX-AMS-MML_SVG.js'));
	public static $SINA_CDN = array("css" => array("bootstrap" => 'https://lib.sinaapp.com/js/bootstrap/latest/css/bootstrap.min.css', "mdui" => 'https://cdn.jsdelivr.net/npm/mdui@0.4.1/dist/css/mdui.min.css'), "js" => array("bootstrap" => 'https://lib.sinaapp.com/js/bootstrap/latest/js/bootstrap.min.js', "jquery" => 'https://lib.sinaapp.com/js/jquery/2.2.4/jquery-2.2.4.min.js', "mdui" => 'https://cdn.jsdelivr.net/npm/mdui@0.4.1/dist/js/mdui.min.js', "mathjax" => 'https://cdn.staticfile.org/mathjax/2.7.0/MathJax.js', 'mathjax_svg' => 'https://cdn.staticfile.org/mathjax/2.7.0/config/TeX-AMS-MML_SVG.js'));
	public static $QINIU_CDN = array("css" => array("bootstrap" => 'https://cdn.staticfile.org/twitter-bootstrap/3.3.7/css/bootstrap.min.css', "mdui" => 'https://cdn.jsdelivr.net/npm/mdui@0.4.1/dist/css/mdui.min.css'), "js" => array("bootstrap" => 'https://cdn.staticfile.org/twitter-bootstrap/3.3.7/js/bootstrap.min.js', "jquery" => 'https://cdn.staticfile.org/jquery/2.2.4/jquery.min.js', "mdui" => 'https://cdn.jsdelivr.net/npm/mdui@0.4.1/dist/js/mdui.min.js', "mathjax" => 'https://cdn.staticfile.org/mathjax/2.7.0/MathJax.js', 'mathjax_svg' => 'https://cdn.staticfile.org/mathjax/2.7.0/config/TeX-AMS-MML_SVG.js'));
	public static $JSDELIVR_CDN = array("css" => array("bootstrap" => 'https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/css/bootstrap.min.css', "mdui" => 'https://cdn.jsdelivr.net/npm/mdui@0.4.1/dist/css/mdui.min.css'), "js" => array("bootstrap" => 'https://cdn.jsdelivr.net/npm/bootstrap@3.3.4/dist/js/bootstrap.min.js', "jquery" => 'https://cdn.jsdelivr.net/npm/jquery@2.2.4/dist/jquery.min.js', "mdui" => 'https://cdn.jsdelivr.net/npm/mdui@0.4.1/dist/js/mdui.min.js', "mathjax" => 'https://cdn.jsdelivr.net/npm/mathjax@2.7.0/MathJax.js', 'mathjax_svg' => 'https://cdn.jsdelivr.net/npm/mathjax@2.7.0/config/TeX-AMS_SVG.js'));
	public static $CAT_CDN = array("css" => array("bootstrap" => 'https://cdnjs.loli.net/ajax/libs/twitter-bootstrap/3.3.4/css/bootstrap.min.css', "mdui" => 'https://cdnjs.loli.net/ajax/libs/mdui/0.4.0/css/mdui.min.css'), "js" => array("bootstrap" => 'https://cdnjs.loli.net/ajax/libs/twitter-bootstrap/3.3.4/js/bootstrap.min.js', "jquery" => 'https://cdnjs.loli.net/ajax/libs/jquery/2.2.4/jquery.min.js', "mdui" => 'https://cdnjs.loli.net/ajax/libs/mdui/0.4.0/js/mdui.min.js', "mathjax" => 'https://cdnjs.loli.net/ajax/libs/mathjax/2.7.0/MathJax.js', 'mathjax_svg' => 'https://cdnjs.loli.net/ajax/libs/mathjax/2.7.0/config/TeX-AMS_SVG.js'));
	public static $LOCAL_CDN = array("relative" => true, "css" => array("bootstrap" => "bootstrap/css/bootstrap.min.css", "mdui" => "mdui/mdui.min.css"), "js" => array("bootstrap" => "bootstrap/js/bootstrap.min.js", "jquery" => "jquery/jquery.min.js", "mdui" => "mdui/mdui.min.js", "mathjax" => 'https://cdn.staticfile.org/mathjax/2.7.0/MathJax.js', 'mathjax_svg' => 'https://cdn.staticfile.org/mathjax/2.7.0/config/TeX-AMS-MML_SVG.js'));
	//public static $god = "B326B5062B2F0E69046810717534CB09";
	//public static $back_god = "68934A3E9455FA72420237EB05902327";
	//public static $bad = "\\u4e3b\\u9898\\u672a\\u6388\\u6743\\uff0c\\u8bf7\\u8054\\u7cfb\\u4f5c\\u8005\\u0026\\u006c\\u0074\\u003b\\u002f\\u0062\\u0072\\u0026\\u0067\\u0074\\u003b\\u0026\\u006c\\u0074\\u003b\\u002f\\u0062\\u0072\\u0026\\u0067\\u0074\\u003b\\u0026\\u006c\\u0074\\u003b\\u0073\\u006d\\u0061\\u006c\\u006c\\u0026\\u0067\\u0074\\u003b\\u6b63\\u7248\\u4ed8\\u8d39\\u7528\\u6237\\u6dfb\\u52a0\\u57df\\u540d\\u540e\\uff0c\\u6253\\u5f00\\u0026\\u006c\\u0074\\u003b\\u0061\\u0020\\u0068\\u0072\\u0065\\u0066\\u003d\\u0026\\u0071\\u0075\\u006f\\u0074\\u003b\\u0061\\u0064\\u006d\\u0069\\u006e\\u002f\\u006f\\u0070\\u0074\\u0069\\u006f\\u006e\\u0073\\u002d\\u0074\\u0068\\u0065\\u006d\\u0065\\u002e\\u0070\\u0068\\u0070\\u0026\\u0071\\u0075\\u006f\\u0074\\u003b\\u0026\\u0067\\u0074\\u003b\\u0068\\u0061\\u006e\\u0064\\u0073\\u006f\\u006d\\u0065\\u5916\\u89c2\\u8bbe\\u7f6e\\u754c\\u9762\\u0026\\u006c\\u0074\\u003b\\u002f\\u0061\\u0026\\u0067\\u0074\\u003b\\u5237\\u65b0\\u4e00\\u4e0b\\u5373\\u53ef\\u7684\\u0026\\u006c\\u0074\\u003b\\u002f\\u0073\\u006d\\u0061\\u006c\\u006c\\u0026\\u0067\\u0074\\u003b";
	//public static $not_full = "\\u4e3b\\u9898\\u6587\\u4ef6\\u4e0d\\u5b8c\\u6574\\u6216\\u88ab\\u6076\\u610f\\u4fee\\u6539\\u7834\\u574f\\uff0c\\u8bf7\\u8054\\u7cfb\\u4e3b\\u9898\\u4f5c\\u8005\\u83b7\\u53d6\\u89e3\\u51b3\\u65b9\\u6848\n";
	//public static $not_support = "\\u4e3b\\u9898\\u9898\\u4e0d\\u5b8c\\u6574\\u6216\\u8005\\u0070\\u0068\\u0070\\u7f3a\\u5c11\\u5fc5\\u8981\\u51fd\\u6570\\u6216\\u8005\\u006d\\u0062\\u0073\\u0074\\u0072\\u0069\\u006e\\u0067\\u6a21\\u5757\\u652f\\u6301\\u6216\\u006c\\u0069\\u0073\\u0065\\u006e\\u0063\\u0065\\u6587\\u4ef6\\u6743\\u9650\\u4e0d\\u8db3\\uff0c\\u8bf7\\u8054\\u7cfb\\u4f5c\\u8005\\u83b7\\u53d6\\u89e3\\u51b3\\u65b9\\u6848";
	const action = "action/themes-edit";
	public static function returnPath()
	{
		return self::returnThemePath() . 'lisence';
	}
	public static function returnThemePath()
	{
		$_var_0 = '/';
		$_var_1 = $_var_0 . 'usr' . $_var_0 . 'themes' . $_var_0 . 'handsome' . $_var_0;
		$_var_2 = __TYPECHO_ROOT_DIR__ . $_var_1;
		return $_var_2;
	}
	public static function returnHandsomePath()
	{
		$_var_3 = '/';
		$_var_4 = $_var_3 . 'usr' . $_var_3 . 'themes' . $_var_3 . 'handsome' . $_var_3 . 'libs' . $_var_3 . 'Handsome.php';
		$_var_5 = __TYPECHO_ROOT_DIR__ . $_var_4;
		return $_var_5;
	}
	public static function returnHandsomeVersion()
	{
		$_var_6 = '6.0.0';
		return $_var_6;
	}
}