<?php
/**
 * 蜘蛛来访日志插件，记录蜘蛛爬行的时间及其网址
 * 
 * @package RobotsPlusPlus
 * @author  Ryan, YoviSun, Shion
 * @version 2.0.1
 * @update: 2018.10.06
 * @link http://doufu.ru
 */
class RobotsPlusPlus_Plugin implements Typecho_Plugin_Interface
{
    public static function activate()
    {
        $meg = RobotsPlusPlus_Plugin::install();
        Helper::addPanel(1, 'RobotsPlusPlus/Logs.php', '蜘蛛日志', '查看蜘蛛日志', 'administrator');
        Typecho_Plugin::factory('Widget_Archive')->header = array('RobotsPlusPlus_Plugin', 'isbot');
        return _t($meg.'。请进行<a href="options-plugin.php?config=RobotsPlusPlus">初始化设置</a>');
    }
    public static function deactivate()
    {
        $config  = Typecho_Widget::widget('Widget_Options')->plugin('RobotsPlusPlus');
        $isdrop = $config->droptable;
        if ($isdrop == 0)
        {
            $db = Typecho_Db::get();
            $prefix = $db->getPrefix();
            $db->query("DROP TABLE `".$prefix."robots_logs`", Typecho_Db::WRITE);
        }
        Helper::removePanel(1, 'RobotsPlusPlus/Logs.php');
        if ($isdrop != 0)
        {
            return "插件已被禁用，数据表未被清除";
        }
    }
    public static function config(Typecho_Widget_Helper_Form $form)
    {
        $options = array (
            'baidu' => '百度',
            'google' => '谷歌',
            'sogou' => '搜狗',
            'youdao' => '有道',
            'soso' => '搜搜',
            'bing' => '必应',
            'yahoo' => '雅虎',
            '360' => '360搜索'
            );
        $botlist = new Typecho_Widget_Helper_Form_Element_Checkbox(
            'botlist', $options, '',
              '蜘蛛记录设置:', '请选择要记录的蜘蛛日志');
            
        $pagecount = new Typecho_Widget_Helper_Form_Element_Text(
          'pagecount', NULL, '',
          '分页数量', '每页显示的日志数量');
        $dbool = array (
            '0' => '删除',
            '1' => '不删除'
            );
        $droptable = new Typecho_Widget_Helper_Form_Element_Radio(
            'droptable', $dbool, '',
              '删除数据表:', '请选择是否在禁用插件时，删除日志数据表');
        $form->addInput($botlist);
        $form->addInput($pagecount);
        $form->addInput($droptable);
    }
    public static function personalConfig(Typecho_Widget_Helper_Form $form)
    {
    }
    public static function install()
    {
        $db = Typecho_Db::get();
        $adapter = $db->getAdapterName();
        $robots = $db->getPrefix() . "robots_logs";
        try {
            if("Pdo_SQLite" === $adapter || "SQLite" === $adapter){
                $db->query(" CREATE TABLE IF NOT EXISTS ". $robots ." (
                        lid INTEGER PRIMARY KEY,
                        bot TEXT,
                        url TEXT,
                        ip TEXT,
                        ltime INTEGER)");
            }
            if("Pdo_Mysql" === $adapter || "Mysql" === $adapter){
                $result = $db->fetchRow($db->query("SELECT `ENGINE` FROM `information_schema`.`TABLES` a WHERE a.`TABLE_NAME`='$db->getPrefix()contents' "));
                $db->query("CREATE TABLE IF NOT EXISTS ". $robots ." (
                        `lid` int(10) unsigned NOT NULL auto_increment,
                        `bot` varchar(16) default NULL,
                        `url` varchar(64) default NULL,
                        `ip` varchar(16) default NULL,
                        `ltime` int(10) unsigned default '0',
                        PRIMARY KEY  (`lid`)
                    ) DEFAULT CHARSET=utf8; AUTO_INCREMENT=1");
            }
            return('数据表 '.$robots.' 创建成功, 插件已经成功激活!');
        } catch (Typecho_Db_Exception $e) {
            $code = $e->getCode();
            if(('Mysql' == $type && 1050 == $code)) {
                    $script = 'SELECT `lid`, `bot`, `url`, `ip`, `ltime` from `' . $robots . '`';
                    $db->query($script, Typecho_Db::READ);
                    return '数据表已存在，插件启用成功';
            } else {
                throw new Typecho_Plugin_Exception('数据表建立失败，插件启用失败。错误号：'.$code);
            }
        }
    }
    public static function isbot($rule = NULL)
    {
        $config  = Typecho_Widget::widget('Widget_Options')->plugin('RobotsPlusPlus');
        $bot = NULL;
        $botlist = $config->botlist;
        if (sizeof($botlist)>0) {
            @ $useragent = strtolower($_SERVER['HTTP_USER_AGENT']);
            foreach ($botlist as $value) {
                if (strpos($useragent,$value)!== false) {
                    $bot = $value;
                }
            }
            if ($bot !== NULL) {
                $request = new Typecho_Request;
                $ip = $request->getIp();
                $url = $_SERVER['REQUEST_URI'];
                if ($ip == NULL){
                    $ip = 'UnKnow';
                }
                $options = Typecho_Widget::widget('Widget_Options');
                $timeStamp = $options->gmtTime;
                $offset = $options->timezone - $options->serverTimezone;
                $gtime = $timeStamp + $offset;
                $db = Typecho_Db::get();
                $rows = array (
                    'bot' => $bot,
                    'url' => $url,
                    'ip' => $ip,
                    'ltime' => $gtime,
                    );
                $db->query($db->insert('table.robots_logs')->rows($rows));
            }
        }
    }
}
