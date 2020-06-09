<?php
//error_reporting(0);
if (!defined('__TYPECHO_ROOT_DIR__')) {
	exit;
}
class Handsome
{
	public static $version;
	public static $times = 0;
	public static $handsome;
	public static $cdnSetting = null;
	public static function SettingsWelcome()
	{
		return self::useIntro() . self::checkupdatejs() . self::styleoutput();
	}
	public static function initCdnSetting()
	{
		$_var_0 = mget();
		if (!defined('THEME_URL')) {
			@define('THEME_URL', rtrim(preg_replace('/^' . preg_quote($_var_0->siteUrl, '/') . '/', $_var_0->rootUrl . '/', $_var_0->themeUrl, 1), '/') . '/');
		}
		if (!defined('PUBLIC_CDN')) {
			switch ($_var_0->publicCDNSelcet) {
				case 0:
					@define('PUBLIC_CDN', serialize(Handsome_Config::$BOOT_CDN));
					@define('PUBLIC_CDN_PREFIX', '');
					break;
				case 1:
					@define('PUBLIC_CDN', serialize(Handsome_Config::$BAIDU_CDN));
					@define('PUBLIC_CDN_PREFIX', '');
					break;
				case 2:
					@define('PUBLIC_CDN', serialize(Handsome_Config::$SINA_CDN));
					@define('PUBLIC_CDN_PREFIX', '');
					break;
				case 3:
					@define('PUBLIC_CDN', serialize(Handsome_Config::$QINIU_CDN));
					@define('PUBLIC_CDN_PREFIX', '');
					break;
				case 4:
					@define('PUBLIC_CDN', serialize(Handsome_Config::$JSDELIVR_CDN));
					@define('PUBLIC_CDN_PREFIX', '');
					break;
				case 5:
					@define('PUBLIC_CDN', serialize(Handsome_Config::$CAT_CDN));
					@define('PUBLIC_CDN_PREFIX', '');
					break;
				case 6:
					@define('PUBLIC_CDN', serialize(Handsome_Config::$LOCAL_CDN));
					@define('PUBLIC_CDN_PREFIX', THEME_URL . 'assets/libs/');
					break;
				default:
					@define('PUBLIC_CDN', serialize(Handsome_Config::$LOCAL_CDN));
					@define('PUBLIC_CDN_PREFIX', THEME_URL . 'assets/libs/');
					break;
			}
		}
	}
	public static function getBackgroundColor()
	{
		$_var_1 = array(array('#673AB7', '#512DA8'), array('#20af42', '#1a9c39'), array('#336666', '#2d4e4e'), array('#2e3344', '#232735'));
		$_var_2 = array_rand($_var_1, 1);
		$_var_3 = $_var_1[$_var_2];
		return $_var_3;
	}
	public static function isPluginAvailable($_var_4, $_var_5)
	{
		if (class_exists($_var_4)) {
			$_var_6 = Typecho_Plugin::export();
			$_var_6 = $_var_6['activated'];
			if (is_array($_var_6) && array_key_exists($_var_5, $_var_6)) {
				return true;
			} else {
				return false;
			}
		} else {
			return false;
		}
	}
	public static function useIntro()
	{
		self::$version = Handsome_Config::returnHandsomeVersion();
		$_var_7 = (string) self::$version;
		$_var_8 = self::getBackgroundColor();
		Handsome::initCdnSetting();
		$_var_9 = unserialize(PUBLIC_CDN);
		$_var_10 = PUBLIC_CDN_PREFIX . $_var_9['css']['mdui'];
		$_var_11 = Typecho_Db::get();
		$_var_12 = '';
		if ($_var_11->fetchRow($_var_11->select()->from('table.options')->where('name = ?', 'theme:HandsomePro-X-Backup'))) {
			$_var_12 = '<div class="mdui-chip" style="color: rgb(26, 188, 156);"><span 
        class="mdui-chip-icon mdui-color-green"><i class="mdui-icon material-icons">&#xe8ba;</i></span><span class="mdui-chip-title">数据库存在主题数据备份</span></div>';
		} else {
			$_var_12 = '<div class="mdui-chip" style="color: rgb(26, 188, 156);"><span 
        class="mdui-chip-icon mdui-color-red"><i class="mdui-icon material-icons">&#xe8ba;</i></span><span 
        class="mdui-chip-title" style="color: rgb(255, 82, 82);">没有主题数据备份</span></div>';
		}
		$_var_13 = '';
		$_var_14 = '';
		if (self::isPluginAvailable('EditorMD_Plugin', 'EditorMD')) {
			if (Helper::options()->plugin('EditorMD')->isActive == '1') {
				$_var_14 = '开启EditorMD插件，请在插件设置里面取消「接管前台解析」，否则会导致首次进入文章页面空白</br>';
			}
		}
		if ($_var_14 == '') {
			$_var_14 = '使用愉快';
		}
		if (!self::isPluginAvailable('Handsome_Plugin', 'Handsome')) {
			$_var_13 = '<div class="mdui-chip" mdui-tooltip="{content: 
    \'' . $_var_14 . '\'}" style="color: rgb(26, 188, 156);"><span 
        class="mdui-chip-icon mdui-color-green"><i class="mdui-icon material-icons">&#xe8ba;</i></span><span class="mdui-chip-title">配套插件已启用</span></div>';
		}
		$_var_15 = Typecho_Widget::widget('Widget_Options')->BlogPic;
		return <<<EOF
<link href="{$_var_10}" rel="stylesheet">
<div class="mdui-card">
  <!-- 卡片的媒体内容，可以包含图片、视频等媒体内容，以及标题、副标题 -->
  <div class="mdui-card-media">    
    <!-- 卡片中可以包含一个或多个菜单按钮 -->
    <div class="mdui-card-menu">
      <button class="mdui-btn mdui-btn-icon mdui-text-color-white"><i class="mdui-icon material-icons">share</i></button>
    </div>
  </div>
  
  <!-- 卡片的标题和副标题 -->

<div class="mdui-card">

  <!-- 卡片头部，包含头像、标题、副标题 -->
  <div id="handsome_header" class="mdui-card-header" mdui-dialog="{target: '#mail_dialog'}">
    <img class="mdui-card-header-avatar" src="{$_var_15}"/>
    <div class="mdui-card-header-title">您好</div>
    <div class="mdui-card-header-subtitle">欢迎使用handsome主题，点击查看一封信</div>
  </div>
  
  <!-- 卡片的标题和副标题 -->
<div class="mdui-card-primary mdui-p-t-1">
    <div class="mdui-card-primary-title">Handsome {$_var_7} Pro</div>
    <div class="mdui-card-primary-subtitle mdui-row mdui-row-gapless  mdui-p-t-1 mdui-p-l-1">
        <div class="mdui-p-b-1" id="handsome_notice">公告信息</div>

        <!--历史公告-->
        <div class="mdui-chip"  mdui-dialog="{target: '#history_notice_dialog'}" id="history_notice" style="color: 
        #607D8B;"><span 
        class="mdui-chip-icon mdui-color-blue-grey"><i 
        class="mdui-icon material-icons">&#xe86b;</i></span><span 
        class="mdui-chip-title" style="color: #607D8B;">查看历史公告</span></div>
        
                <!--备份情况-->
                {$_var_12}
                <!--插件情况-->
                {$_var_13}

     </div>
  </div>  
  <!-- 卡片的按钮 -->
  <div class="mdui-card-actions">
    <button class="mdui-btn mdui-ripple"><a href="https://handsome.ihewro.com/" mdui-tooltip="{content: 
    '主题99%的使用问题都可以通过文档解决，文档有搜索功能快试试！'}"}>使用文档</a></button>
    <button class="mdui-btn mdui-ripple"><a href="https://handsome.ihewro.com/user.html" mdui-tooltip="{content: '勤劳的handsome用户分享内容'}">分享社区</a></button>
    <button class="mdui-btn mdui-ripple"><a href="https://auth.ihewro.com/" mdui-tooltip="{content: 
    '在这里有管理你的授权一切，还有其他更多'}">授权平台</a></button>
    <button class="mdui-btn mdui-ripple showSettings" mdui-tooltip="{content: 
    '展开所有设置后，使用ctrl+F 可以快速搜索🔍某一设置项'}">展开所有设置</button>
    <button class="mdui-btn mdui-ripple hideSettings">折叠所有设置</button>
    <button class="mdui-btn mdui-ripple recover_back_up" mdui-tooltip="{content: '从主题备份恢复数据'}">从主题备份恢复数据</button>
    <button class="mdui-btn mdui-ripple back_up" 
    mdui-tooltip="{content: '1. 仅仅是备份handsome主题的外观数据</br>2. 切换主题的时候，虽然以前的外观设置的会清空但是备份数据不会被删除。</br>3. 所以当你切换回来之后，可以恢复备份数据。</br>4. 备份数据同样是备份到数据库中。</br>5. 如果已有备份数据，再次备份会覆盖之前备份'}">
    备份主题数据</button>
    <button class="mdui-btn mdui-ripple un_back_up" mdui-tooltip="{content: '删除handsome备份数据'}">删除现有handsome备份</button>
  </div>
  
  
</div>

  
</div>


<div class="mdui-dialog" id="updateDialog">
    <div class="mdui-dialog-content">
      <div class="mdui-dialog-title">更新说明</div>
      <div class="mdui-dialog-content" id="update-dialog-content">获取更新内容失败，请稍后重试</div>
    </div>
    <div class="mdui-dialog-actions">
      <button class="mdui-btn mdui-ripple" mdui-dialog-close>取消</button>
      <button class="mdui-btn mdui-ripple" mdui-dialog-confirm>前往更新</button>
    </div>
  </div>
  
  <div class="mdui-dialog mdui-p-a-5" id="mail_dialog" data-status="0">
  <div class="mdui-spinner mdui-center"></div>
    <div class="mdui-dialog-content mdui-hidden">
      <div class="mdui-dialog-content">
    
        </div>
</div>
    </div>  
    
    
      <div class="mdui-dialog mdui-p-a-5" id="history_notice_dialog" data-status="0">
  <div class="mdui-spinner mdui-center"></div>
    <div class="mdui-dialog-content mdui-hidden">
      <div class="mdui-dialog-content">
    
        </div>
</div>
    </div>    
EOF
;
	}
	public static function checkupdatejs()
	{
				$current_version = self::$version;
        Handsome::initCdnSetting();
        $PUBLIC_CDN_ARRAY = unserialize(PUBLIC_CDN);
        $jquery = PUBLIC_CDN_PREFIX.$PUBLIC_CDN_ARRAY['js']['jquery'];
        $mduiJs= PUBLIC_CDN_PREFIX.$PUBLIC_CDN_ARRAY['js']['mdui'];
        $options = mget();
        $blog_url = $options->rootUrl;
        $code = '"'.md5($options->time_code).'"';
        $url = "/?action=notice2";
        return <<<EOF
<script src="{$mduiJs}"></script>
<script>mdui.JQ(function () { $('form:eq(0)').attr('action', $('form:eq(1)').attr('action')); });
    mdui.mutation() </script>
    
<script src="{$jquery}" type="text/javascript"></script>
<script>
var blog_url="{$_var_23}";
var code={$_var_24};
var root="{$_var_25}";
var root_use="{$_var_26}";
var version = "{$_var_16}";
</script>
<script>
var VersionCompare = function (currVer, promoteVer) {
    currVer = currVer || "0.0.0";
    promoteVer = promoteVer || "0.0.0";
    if (currVer == promoteVer) return false;
    var currVerArr = currVer.split(".");
    var promoteVerArr = promoteVer.split(".");
    var len = Math.max(currVerArr.length, promoteVerArr.length);
    for (var i = 0; i < len; i++) {
        var proVal = ~~promoteVerArr[i],
            curVal = ~~currVerArr[i];
        if (proVal < curVal) {
            return false;
        } else if (proVal > curVal) {
            return true;
        }
    }
    return false;
};

(function($){
    $("body").delegate(".appearanceTitle","click",function(){
        $(this).next().slideToggle();
    });
     $(function(){
         $('.showSettings').bind('click',function() {
           $('.mdui-panel-item').addClass('mdui-panel-item-open');
         });
         $('.hideSettings').bind('click',function() {
            $('.mdui-panel-item').removeClass('mdui-panel-item-open');
         });
     });
     
     $('.back_up').click(function() {
         mdui.confirm("确认要备份数据吗", "备份数据", function() {
           $.ajax({
            url: '$blog_url',
            data: {action:"back_up"},
            success: function(data) {
                if (data !== "-1"){
                    mdui.snackbar({
                    message: '备份成功，操作码:' + data +',正在刷新页面……',
                    position: 'bottom'
                });
                    setTimeout(function (){
                    location.reload();
                },1000);
                }else {
                    mdui.snackbar({
                    message: '备份失败,错误码' + data,
                    position: 'bottom'
                });
                }
            }
        })
         },null , {"confirmText":"确认","cancelText":"取消"})

     });
     
     
     $('.un_back_up').click(function() {
         
         mdui.confirm("确认要删除备份数据吗", "删除备份", function() {
            $.ajax({
            url: '$blog_url',
            data: {action:"un_back_up"},
            success: function(data) {
                if (data !== "-1"){
                    mdui.snackbar({
                    message: '删除备份成功，操作码:' + data +',正在刷新页面……',
                    position: 'bottom'
                });
                    setTimeout(function (){
                    location.reload();
                },1000);
                }else {
                    var message = "没有备份，你删什么删，别问我为什么这么冲，因为总有问我为啥删除失败，对不起。";
                    mdui.snackbar({
                    message: message,
                    position: 'bottom'
                });
                }
            }
        })
},null , {"confirmText":"确认","cancelText":"取消"});
         
});
     
     $('.recover_back_up').click(function() {
         
         
        mdui.confirm("确认要恢复备份数据吗", "恢复备份", function() {
    $.ajax({
        url: '$blog_url',
        data: {action:"recover_back_up"},
        success: function(data) {
            if (data !== "-1"){
                mdui.snackbar({
                    message: '恢复备份成功，操作码:' + data +',正在刷新页面……',
                    position: 'bottom'
                });
                setTimeout(function (){
                    location.reload();
                },1000);
            }else {
                mdui.snackbar({
                    message: '恢复备份失败,错误码' + data,
                    position: 'bottom'
                });
            }
        }
    })

},null , {"confirmText":"确认","cancelText":"取消"})
     });
})(jQuery)
</script>
<script src="{$_var_21}"></script>
<script src="{$_var_20}" type="text/javascript"></script>    
<script src="{$_var_17}assets/js/admin/admin.min.js" type="text/javascript"></script>  
EOF
;
    }
    /**
     * 返回handsome主题的信息（版本号和介绍），以便进行检查和显示
     * @return mixed
     */
    public static function returnHandsomeVersion(){
        $version = "6.0.0";
        return $version;

	}
	public static function styleoutput()
	{
		$_var_28 = THEME_URL;
		$_var_29 = Handsome::$version . Handsome_Config::$versionTag;
		$_var_30 = self::getBackgroundColor();
		return <<<EOF
<style>
:root{--randomColor0:{$_var_30[0]};--randomColor1:{$_var_30[1]};}
</style>
    <link rel="stylesheet" href="{$_var_28}assets/css/admin/editor.min.css?v={$_var_29}" type="text/css" />
    <link rel="stylesheet" href="{$_var_28}assets/css/admin/admin.min.css?v={$_var_29}" type="text/css" />
EOF
;
	}
	public static function outputEditorJS()
	{
		$_var_31 = mget();
		self::initCdnSetting();
		$_var_32 = THEME_URL;
		$_var_33 = $_var_32 . 'libs/Get.php';
		$_var_34 = Handsome::$version . Handsome_Config::$versionTag;
		Handsome::$times++;
		$_var_35 = unserialize(PUBLIC_CDN);
		return "\n    <link rel=\"stylesheet\" href=\"{$_var_32}assets/css/owo.min.css?v={$_var_34}\" type=\"text/css\" />\n    <link rel=\"stylesheet\" href=\"{$_var_32}assets/css/admin/editor.min.css?v={$_var_34}\" type=\"text/css\" />\n    \n<script>\nvar hplayerUrl='{$_var_33}';\nvar themeUrl = '{$_var_32}';\nvar themeAssetsUrl ='{$_var_32}assets/';\nwindow['LocalConst'] = {\n    BASE_SCRIPT_URL: themeUrl\n}\n</script>\n\n<script src=\"{$_var_32}assets/js/features/OwO.min.js?v={$_var_34}\"></script>\n    <script>\n    </script>\n<script src=\"{$_var_32}assets/js/editor.min.js?v={$_var_34}\"></script>\n\n\n";
	}
	public static function returnCheckHtml()
	{
		return <<<EOF
EOF
;
	}
}