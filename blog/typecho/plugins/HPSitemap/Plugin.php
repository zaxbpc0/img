<?php

/**
 * sitemap生成工具。<a href='www.typecho.wiki/archives/typecho-sitemap-generation-plugin-sitemap-bigdata.html'>需要帮助?</a>该版本并不是雷鬼HPtypecho的系统支持的插件，是我基于雷鬼版本进行改良后支持原生Typecho的版本
 * 
 * @category widget
 * @package HPSitemap
 * @author Roogle&雷鬼
 * @version 2.0
 * @link https://www.typecho.wiki
 */

class HPSitemap_Plugin implements Typecho_Plugin_Interface
{
    public static function activate(){
        Helper::addAction('gen_sitemap', 'HPSitemap_Gen');

    }

    public static function deactivate(){
	    Helper::removeAction('gen_sitemap');

    }
	
    public static function config(Typecho_Widget_Helper_Form $form){

        $sitemap_dir = new Typecho_Widget_Helper_Form_Element_Text(
            'sitemap_dir',NULL ,'sitemap',
            _t('设置生成sitemap的目录。'),
            _t('譬如设置sitemap,则会在根目录下新建sitemap目录，且在此处生成sitemap.xml,请保证此目录可访问。<br />使用方法(SSH)：wget https://yourdomain/action/gen_sitemap?_auth=xxxxx 。xxxxx：自己设置的认证信息')
        );
        $form->addInput($sitemap_dir);

        $import_user_auth = new Typecho_Widget_Helper_Form_Element_Text(
            'sitemap_user_auth',NULL ,'',
            _t('设置调用接口时的认证信息'),
            _t('调用接口时,请带上?_auth=xxxxx参数,校验通过后才允许导入')
        );
        $form->addInput($import_user_auth);

    }


    public static function personalConfig(Typecho_Widget_Helper_Form $form){

    }

      
}
