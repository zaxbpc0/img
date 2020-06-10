<?php
/**
 * <strong style="color:red;">handsomePro 唯一配套插件</strong>
 *
 * @package Handsome
 * @author hewro,hanny
 * @version 2.0.0
 * @dependence 14.10.10-*
 * @link https://www.ihewro.com
 *
 */

class Handsome_Plugin implements Typecho_Plugin_Interface
{
    /**
     * 激活插件方法,如果激活失败,直接抛出异常
     * 
     * @access public
     * @return string
     * @throws Typecho_Plugin_Exception
     */
    public static function activate()
    {
		$info = Handsome_Plugin::linksInstall();
		Helper::addPanel(3, 'Handsome/manage-links.php', '友情链接', '管理友情链接', 'administrator');
		Helper::addAction('links-edit', 'Handsome_Action');
        Typecho_Plugin::factory('Widget_Abstract_Contents')->contentEx = array('Handsome_Plugin', 'parse');
        Typecho_Plugin::factory('Widget_Abstract_Contents')->excerptEx = array('Handsome_Plugin', 'parse');
        Typecho_Plugin::factory('Widget_Abstract_Comments')->contentEx = array('Handsome_Plugin', 'parse');

        //置顶功能
        Typecho_Plugin::factory('Widget_Archive')->indexHandle = array('Handsome_Plugin', 'sticky');
        //分类过滤，默认过滤相册
        Typecho_Plugin::factory('Widget_Archive')->indexHandle = array('Handsome_Plugin', 'CateFilter');

        //过滤私密评论
        Typecho_Plugin::factory('Widget_Abstract_Contents')->excerptEx = array('Handsome_Plugin','exceptFeed');
        Typecho_Plugin::factory('Widget_Abstract_Contents')->contentEx = array('Handsome_Plugin','exceptFeed');

        Typecho_Plugin::factory('Widget_Archive')->footer = array('Handsome_Plugin', 'footer');

        // 注册文章、页面保存时的 hook（JSON 写入数据库）
        Typecho_Plugin::factory('Widget_Contents_Post_Edit')->finishPublish = array('Handsome_Plugin', 'buildSearchIndex');
        Typecho_Plugin::factory('Widget_Contents_Post_Edit')->finishDelete = array('Handsome_Plugin', 'buildSearchIndex');
        Typecho_Plugin::factory('Widget_Contents_Page_Edit')->finishPublish = array('Handsome_Plugin', 'buildSearchIndex');
        Typecho_Plugin::factory('Widget_Contents_Page_Edit')->finishDelete = array('Handsome_Plugin', 'buildSearchIndex');

        return _t($info);
    }
    
    /**
     * 禁用插件方法,如果禁用失败,直接抛出异常
     * 
     * @static
     * @access public
     * @return void
     * @throws Typecho_Plugin_Exception
     */
    public static function deactivate()
	{
		Helper::removeAction('links-edit');
		Helper::removePanel(3, 'Links/manage-links.php');
		Helper::removePanel(3, 'Handsome/manage-links.php');
	}
    
    /**
     * 获取插件配置面板
     * 
     * @access public
     * @param Typecho_Widget_Helper_Form $form 配置面板
     * @return void
     */
    public static function config(Typecho_Widget_Helper_Form $form) {


        if (isset($_GET['action']) && $_GET['action'] == 'buildSearchIndex') {
            self::buildSearchIndex();
        }

        $form->addInput(new Title_Plugin('btnTitle', NULL, NULL, _t('致谢'), NULL));


        $thanks = new Typecho_Widget_Helper_Form_Element_Select("thanks",array(
            1 => "友情链接功能由<a href='http://www.imhan.com'>hanny</a>开发，感谢！"
        ),"1","友情链接","<strong style='color: red'> 请在typecho的后台-管理-友情链接 设置</strong>");
        $form->addInput($thanks);

        $form->addInput(new Title_Plugin('btnTitle', NULL, NULL, _t('文章设置'), NULL));


        $sticky_cids = new Typecho_Widget_Helper_Form_Element_Text(
            'sticky_cids', NULL, '',
            '置顶文章的 cid', '按照排序输入, 请以半角逗号或空格分隔 cid.</br><strong style=\'color: red\'>cid查看方式：</strong>后台的文章管理中，进入具体的文章编辑页面，地址栏中会有该数字。如<code>http://localhost/build/admin/write-post.php?cid=120</code>表示该篇文章的cid为120');
        $form->addInput($sticky_cids);

        $form->addInput(new Title_Plugin('btnTitle', NULL, NULL, _t('分类设置'), NULL));


        $CateId = new Typecho_Widget_Helper_Form_Element_Text('CateId', NULL, '', _t('首页不显示的分类的mid'), _t('多个请用英文逗号隔开</br><strong style="color: red">mid查看方式：</strong> 在分类管理页面点击分类，地址栏中会有该数字，比如<code>http://localhost/build
/admin/category.php?mid=2</code> 表示该分类的mid为2</br><strong style="color: rgba(255,0,18,1)">默认不过滤相册分类，请自行过滤</strong>'));
        $form->addInput($CateId);

        $LockId = new Typecho_Widget_Helper_Form_Element_Text('LockId', NULL, '', _t('加密分类mid'), _t('多个请用英文逗号隔开</br><strong style="color: red">mid查看方式：</strong> 在分类管理页面点击分类，地址栏中会有该数字，比如<code>http://localhost/build
/admin/category.php?mid=2</code> 表示该分类的mid为2</br><strong style="color: rgba(255,0,18,1)">加密分类的密码需要在分类描述按照指定格式填写<a 
href="https://handsome.ihewro.com/#/lock" target="_blank">使用文档</a></strong></br><strong style="color: rgba(255,0,18,1)">加密分类仍然会在首页显示标题列表，但不会显示具体内容，也不会出现在rss地址中</strong>'));
        $form->addInput($LockId);

//        $search = new
        $form->addInput(new Title_Plugin('btnTitle', NULL, NULL, _t('搜索设置'), NULL));

        $queryBtn = new Typecho_Widget_Helper_Form_Element_Submit();
        $queryBtn->value(_t('构建文章索引'));
        $queryBtn->description(_t('通常只需要在第一次启用插件的时候，手动点击该按钮。在发布、修改文章的时候会自动构建新的索引。如果发现搜索数据不对，请再次手动点击此按钮'));
        $queryBtn->input->setAttribute('class','btn btn-s btn-warn btn-operate');
        $queryBtn->input->setAttribute('formaction',Typecho_Common::url('/options-plugin.php?config=Handsome&action=buildSearchIndex',Helper::options()->adminUrl));
        $form->addItem($queryBtn);

    }


    public static function buildSearchIndex($contents=null,$edit=null){
        //生成索引数据
        if ($edit != null){
            //如果是新增文章或者修改文章无需构建整个索引，速度太慢

            $code = json_decode(file_get_contents(__DIR__.'/cache/search.json'));

            $data = @$edit->stack[0]['categories'][0]['description'];
            $data = json_decode($data,true);

            //寻找当前编辑的文章在数组中的位置
            $cid = -1;
            if ('delete' == $edit->request->do){//文章删除
                $cid = $contents;
            }else{
                $cid = $edit->cid;
            }
            $flag = -1;
            for ($i = 0; $i < count($code);$i++){
                $item = $code[$i];
                if ($item->cid == $cid){
                    //匹配成功
                    $flag = $i;
                    break;
                }
            }
            if ($flag != -1){//找到了当前保存的文章，直接修改内容即可或者删除一篇文章
                //不是加密文章、草稿、私密、隐藏文章
                if ('delete' == $edit->request->do){//文章删除
                    unset($code[$flag]);
                }else if((@$data["password"] == null || @$data["password"] == "") && strpos($contents['type'],"draft") === FALSE &&  $contents['visibility'] == "publish"){
                    //修改值
                    $code[$flag]->title = $contents["title"];
                    $code[$flag]->date = $edit->permalink;
                    $code[$flag]->path = date('c', $edit->created);
                    $code[$flag]->content= $contents["text"];

                }else{
                    //不用管，这类文章不应该出现在搜索结果中
                    //删除这个元素
                    unset($code[$flag]);
                }
            }else{//新增一篇文章
                if ((@$data["password"] == null || @$data["password"] == "") && strpos($contents['type'],"draft") ===
                    FALSE &&  $contents['visibility'] == "publish"){

                    //新增一条记录，也有一种可能是编辑的时候把链接地址也改了，就导致错误增加了一条
                    $code[] = (object)  array(
                        'title' => $contents['title'],
                        'date' => date('c', $edit->created),
                        'path' => $edit->permalink,
                        'content' => trim(strip_tags($contents['text']))
                    );
                }
            }
            file_put_contents(__DIR__.'/cache/search.json', json_encode(array_values($code)));


        }else{//插件设置界面的构建索引，如果数据太大则速度较慢
            //判断是否有写入权限
            // 获取搜索范围配置，query 对应内容
            $cache = array();
            $cache = array_merge($cache,self::build('post'));
            $cache = array_merge($cache,self::build('page'));

            $cache = json_encode($cache);

            //写入文件
            $code = file_put_contents(__DIR__.'/cache/search.json', $cache);
            //写入数据库
            if($code < 1) {
                Typecho_Widget::widget('Widget_Notice')->set(_t("Handsome插件下的cache文件夹没有写入权限"), 'error');
            }else{
                Typecho_Widget::widget('Widget_Notice')->set(_t("索引构建成功，去博客试试搜索效果吧"), 'success');
            }
        }
    }

    /**
     * 生成对象
     *
     * @access private
     * @param $type
     * @return array
     */
    private static function build($type)
    {
        $db = Typecho_Db::get();
        $rows = $db->fetchAll($db->select()->from('table.contents')
            ->where('table.contents.type = ?', $type)
            ->where('table.contents.status = ?', 'publish')
            ->where('table.contents.password IS NULL'));
        $cache = array();
        foreach ($rows as $row) {
            $widget = self::widget('Contents', $row['cid']);
//            print_r(strip_tags($widget->content));
            $data = @$widget->stack[0]['categories'][0]['description'];
            $data = json_decode($data,true);

            if (@$data["password"] == null || @$data["password"] == ""){//过滤加密分类的文章
                $item = array(
                    'title' => $row['title'],
                    'date' => date('c', $row['created']),
                    'path' => $widget->permalink,
                    'cid' => $row['cid'],
                    'content' => trim(strip_tags($widget->content))
                );
                $cache[]=$item;
            }
        }
        return $cache;
    }

    /**
     * 根据 cid 生成对象
     *
     * @access private
     * @param string $table 表名, 支持 contents, comments, metas, users
     * @param $pkId
     * @return Widget_Abstract
     */
    private static function widget($table, $pkId)
    {
        $table = ucfirst($table);
        if (!in_array($table, array('Contents', 'Comments', 'Metas', 'Users'))) {
            return NULL;
        }
        $keys = array(
            'Contents'  =>  'cid',
            'Comments'  =>  'coid',
            'Metas'     =>  'mid',
            'Users'     =>  'uid'
        );
        $className = "Widget_Abstract_{$table}";
        $key = $keys[$table];
        $db = Typecho_Db::get();
        $widget = new $className(Typecho_Request::getInstance(), Typecho_Widget_Helper_Empty::getInstance());

        $db->fetchRow(
            $widget->select()->where("{$key} = ?", $pkId)->limit(1),
            array($widget, 'push'));
        return $widget;
    }

    /**
     * 个人用户的配置面板
     * 
     * @access public
     * @param Typecho_Widget_Helper_Form $form
     * @return void
     */
    public static function personalConfig(Typecho_Widget_Helper_Form $form) {}

	public static function linksInstall()
	{
		$installDb = Typecho_Db::get();
		$type = explode('_', $installDb->getAdapterName());
		$type = array_pop($type);
		$prefix = $installDb->getPrefix();
		$scripts = file_get_contents('usr/plugins/Handsome/'.$type.'.sql');
		$scripts = str_replace('typecho_', $prefix, $scripts);
		$scripts = str_replace('%charset%', 'utf8', $scripts);
		$scripts = explode(';', $scripts);
		try {
			foreach ($scripts as $script) {
				$script = trim($script);
				if ($script) {
					$installDb->query($script, Typecho_Db::WRITE);
				}
			}
			return '建立友情链接数据表，插件启用成功';
		} catch (Exception $e) {
            print_r($e);
			$code = $e->getCode();
			
			if(('Mysql' == $type || 1050 == $code) ||
					('SQLite' == $type && ('HY000' == $code || 1 == $code))) {
				try {
					$script = 'SELECT `lid`, `name`, `url`, `sort`, `image`, `description`, `user`, `order` from `' . $prefix . 'links`';
					$installDb->query($script, Typecho_Db::READ);
					return '检测到友情链接数据表，友情链接插件启用成功';					
				} catch (Typecho_Db_Exception $e) {
					$code = $e->getCode();
					if(('Mysql' == $type && 1054 == $code) ||
							('SQLite' == $type && ('HY000' == $code || 1 == $code))) {
						return Handsome_Plugin::linksUpdate($installDb, $type, $prefix);
					}
					throw new Typecho_Plugin_Exception('数据表检测失败，友情链接插件启用失败。错误号：'.$code);
				}
			} else {
				throw new Typecho_Plugin_Exception('数据表建立失败，友情链接插件启用失败。错误号：'.$code);
			}
		}
	}
	
	public static function linksUpdate($installDb, $type, $prefix)
	{
		$scripts = file_get_contents('usr/plugins/Handsome/Update_'.$type.'.sql');
		$scripts = str_replace('typecho_', $prefix, $scripts);
		$scripts = str_replace('%charset%', 'utf8', $scripts);
		$scripts = explode(';', $scripts);
		try {
			foreach ($scripts as $script) {
				$script = trim($script);
				if ($script) {
					$installDb->query($script, Typecho_Db::WRITE);
				}
			}
			return '检测到旧版本友情链接数据表，升级成功';
		} catch (Typecho_Db_Exception $e) {
			$code = $e->getCode();
			if(('Mysql' == $type && 1060 == $code) ) {
				return '友情链接数据表已经存在，插件启用成功';
			}
			throw new Typecho_Plugin_Exception('友情链接插件启用失败。错误号：'.$code);
		}
	}

	public static function form($action = NULL)
	{
		/** 构建表格 */
		$options = Typecho_Widget::widget('Widget_Options');
		$form = new Typecho_Widget_Helper_Form(Typecho_Common::url('/action/links-edit', $options->index),
		Typecho_Widget_Helper_Form::POST_METHOD);
		
		/** 链接名称 */
		$name = new Typecho_Widget_Helper_Form_Element_Text('name', NULL, NULL, _t('链接名称*'));
		$form->addInput($name);
		
		/** 链接地址 */
		$url = new Typecho_Widget_Helper_Form_Element_Text('url', NULL, "http://", _t('链接地址*'));
		$form->addInput($url);

        $sort = new Typecho_Widget_Helper_Form_Element_Select('sort', array(
            'ten'=>'全站链接，首页左侧边栏显示',
            'one'=>'内页链接，在独立页面中显示（需要新建独立页面<a href="https://handsome2.ihewro.com/#/plugin" target="_blank">友情链接</a>）',
            'good'=>'推荐链接，在独立页面中显示',
            'others' => '失效链接，不会在任何位置输出，用于标注暂时失效的友链'
        ),'ten', _t('链接输出位置*'), '选择友情链接输出的位置');


		$form->addInput($sort);
		
		/** 链接图片 */
		$image = new Typecho_Widget_Helper_Form_Element_Text('image', NULL, NULL, _t('链接图片'),  _t('需要以http://开头，留空表示没有链接图片'));
		$form->addInput($image);
		
		/** 链接描述 */
		$description =  new Typecho_Widget_Helper_Form_Element_Textarea('description', NULL, NULL, _t('链接描述'),"链接的一句话简单介绍");
		$form->addInput($description);
		
		/** 链接动作 */
		$do = new Typecho_Widget_Helper_Form_Element_Hidden('do');
		$form->addInput($do);
		
		/** 链接主键 */
		$lid = new Typecho_Widget_Helper_Form_Element_Hidden('lid');
		$form->addInput($lid);
		
		/** 提交按钮 */
		$submit = new Typecho_Widget_Helper_Form_Element_Submit();
		$submit->input->setAttribute('class', 'btn primary');
		$form->addItem($submit);
		$request = Typecho_Request::getInstance();

        if (isset($request->lid) && 'insert' != $action) {
            /** 更新模式 */
			$db = Typecho_Db::get();
			$prefix = $db->getPrefix();
            $link = $db->fetchRow($db->select()->from($prefix.'links')->where('lid = ?', $request->lid));
            if (!$link) {
                throw new Typecho_Widget_Exception(_t('链接不存在'), 404);
            }
            
            $name->value($link['name']);
            $url->value($link['url']);
            $sort->value($link['sort']);
            $image->value($link['image']);
            $description->value($link['description']);
//            $user->value($link['user']);
            $do->value('update');
            $lid->value($link['lid']);
            $submit->value(_t('编辑链接'));
            $_action = 'update';
        } else {
            $do->value('insert');
            $submit->value(_t('增加链接'));
            $_action = 'insert';
        }
        
        if (empty($action)) {
            $action = $_action;
        }

        /** 给表单增加规则 */
        if ('insert' == $action || 'update' == $action) {
			$name->addRule('required', _t('必须填写链接名称'));
			$url->addRule('required', _t('必须填写链接地址'));
			$url->addRule('url', _t('不是一个合法的链接地址'));
			$image->addRule('url', _t('不是一个合法的图片地址'));
        }
        if ('update' == $action) {
            $lid->addRule('required', _t('链接主键不存在'));
            $lid->addRule(array(new Handsome_Plugin, 'LinkExists'), _t('链接不存在'));
        }
        return $form;
	}

	public static function LinkExists($lid)
	{
		$db = Typecho_Db::get();
		$prefix = $db->getPrefix();
		$link = $db->fetchRow($db->select()->from($prefix.'links')->where('lid = ?', $lid)->limit(1));
		return $link ? true : false;
	}

    /**
     * 控制输出格式
     */
	public static function output_str($pattern=NULL, $links_num=0, $sort=NULL)
	{
		$options = Typecho_Widget::widget('Widget_Options');
		if (!isset($options->plugins['activated']['Handsome'])) {
			return '友情链接插件未激活';
		}
		if (!isset($pattern) || $pattern == "" || $pattern == NULL || $pattern == "SHOW_TEXT") {
			$pattern = "<li><a href=\"{url}\" title=\"{title}\" target=\"_blank\">{name}</a></li>\n";
		} else if ($pattern == "SHOW_IMG") {
			$pattern = "<li><a href=\"{url}\" title=\"{title}\" target=\"_blank\"><img src=\"{image}\" alt=\"{name}\" /></a></li>\n";
		} else if ($pattern == "SHOW_MIX") {
			$pattern = "<li><a href=\"{url}\" title=\"{title}\" target=\"_blank\"><img src=\"{image}\" alt=\"{name}\" /><span>{name}</span></a></li>\n";
		}
		$db = Typecho_Db::get();
		$prefix = $db->getPrefix();
		$options = Typecho_Widget::widget('Widget_Options');
		$nopic_url = Typecho_Common::url('/usr/plugins/Handsome/nopic.jpg', $options->siteUrl);
		$sql = $db->select()->from($prefix.'links');
		if (!isset($sort) || $sort == "") {
			$sort = NULL;
		}
		if ($sort) {
			$sql = $sql->where('sort=?', $sort);
		}
		$sql = $sql->order($prefix.'links.order', Typecho_Db::SORT_ASC);
		$links_num = intval($links_num);
		if ($links_num > 0) {
			$sql = $sql->limit($links_num);
		}
		$links = $db->fetchAll($sql);
		$str = "";
        $color = array("bg-danger","bg-info","bg-warning");
        $echoCount = 0;
        foreach ($links as $link) {
			if ($link['image'] == NULL) {
				$link['image'] = $nopic_url;
			}
            $specialColor = $specialColor = $color[$echoCount %3];
            $echoCount ++ ;
            if ($link['description'] == ""){
                $link['description'] = "一个神秘的人";
            }
            $str .= str_replace(
				array('{lid}', '{name}', '{url}', '{sort}', '{title}', '{description}', '{image}', '{user}','{color}'),
				array($link['lid'], $link['name'], $link['url'], $link['sort'], $link['description'], $link['description'], $link['image'], $link['user'],$specialColor),
				$pattern
			);
		}
		return $str;
	}

	//输出
	public static function output($pattern=NULL, $links_num=0, $sort=NULL)
	{
		echo Handsome_Plugin::output_str($pattern, $links_num, $sort);
	}
	
    /**
     * 解析
     * 
     * @access public
     * @param array $matches 解析值
     * @return string
     */
    public static function parseCallback($matches)
    {
		$db = Typecho_Db::get();
		$pattern = $matches[3];
		$links_num = $matches[1];
		$sort = $matches[2];
		return Handsome_Plugin::output_str($pattern, $links_num, $sort);
    }

    public static function parse($text, $widget, $lastResult)
    {
        $text = empty($lastResult) ? $text : $lastResult;
        
        if ($widget instanceof Widget_Archive || $widget instanceof Widget_Abstract_Comments) {
            return preg_replace_callback("/<links\s*(\d*)\s*(\w*)>\s*(.*?)\s*<\/links>/is", array('Handsome_Plugin', 'parseCallback'), $text);
        } else {
            return $text;
        }
    }


    /**
     * 选取置顶文章
     *
     * @access public
     * @param object $archive , $select
     * @param $select
     * @return void
     * @throws Typecho_Db_Exception
     * @throws Typecho_Exception
     */
    public static function sticky($archive, $select)
    {
        $config  = Typecho_Widget::widget('Widget_Options')->plugin('Handsome');
        $sticky_cids = $config->sticky_cids ? explode(',', strtr($config->sticky_cids, ' ', ',')) : '';
        if (!$sticky_cids) return;

        $db = Typecho_Db::get();
        $paded = $archive->request->get('page', 1);
        $sticky_html = '<span class="label text-sm bg-danger pull-left m-t-xs m-r" style="margin-top:  2px;">'._t("置顶").'</span>';

        foreach($sticky_cids as $cid) {
            if ($cid && $sticky_post = $db->fetchRow($archive->select()->where('cid = ?', $cid))) {
                if ($paded == 1) {                               // 首頁 page.1 才會有置頂文章
                    $sticky_post['sticky'] = $sticky_html;
                    $archive->push($sticky_post);                  // 選取置頂的文章先壓入
                }
                $select->where('table.contents.cid != ?', $cid); // 使文章不重覆
            }
        }
    }

    public static function CateFilter($archive, $select){
        if('/feed' == strtolower(Typecho_Router::getPathInfo()) || '/feed/' == strtolower(Typecho_Router::getPathInfo())){//加密分类的文章不显示在rss内容中
            $LockIds = Typecho_Widget::widget('Widget_Options')->plugin('Handsome')->LockId;
            if(!$LockIds) return $select;       //没有写入值，则直接返回
            $select = $select->select('table.contents.cid', 'table.contents.title', 'table.contents.slug', 'table.contents.created', 'table.contents.authorId','table.contents.modified', 'table.contents.type', 'table.contents.status', 'table.contents.text', 'table.contents.commentsNum', 'table.contents.order','table.contents.template', 'table.contents.password', 'table.contents.allowComment', 'table.contents.allowPing', 'table.contents.allowFeed','table.contents.parent')->join('table.relationships','table.relationships.cid = table.contents.cid','left')->join('table.metas','table.relationships.mid = table.metas.mid','left')->where('table.metas.type=?','category');
            $LockIds = explode(',', $LockIds);
            $LockIds = array_unique($LockIds);  //去除重复值
            foreach ($LockIds as $k => $v) {
                $select = $select->where('table.relationships.mid != '.intval($v))->group('table.relationships.cid');//确保每个值都是数字；排除重复文章，由qqdie修复
            }
            return $select;
        }else{//分类隐藏在首页不显示，但在rss中要显示
            $CateIds = Typecho_Widget::widget('Widget_Options')->plugin('Handsome')->CateId;
            if(!$CateIds) return $select;       //没有写入值，则直接返回
            $select = $select->select('table.contents.cid', 'table.contents.title', 'table.contents.slug', 'table.contents.created', 'table.contents.authorId','table.contents.modified', 'table.contents.type', 'table.contents.status', 'table.contents.text', 'table.contents.commentsNum', 'table.contents.order','table.contents.template', 'table.contents.password', 'table.contents.allowComment', 'table.contents.allowPing', 'table.contents.allowFeed','table.contents.parent')->join('table.relationships','table.relationships.cid = table.contents.cid','left')->join('table.metas','table.relationships.mid = table.metas.mid','left')->where('table.metas.type=?','category');
            $CateIds = explode(',', $CateIds);
            $CateIds = array_unique($CateIds);  //去除重复值
            foreach ($CateIds as $k => $v) {
                $select = $select->where('table.relationships.mid != '.intval($v))->group('table.relationships.cid');//确保每个值都是数字；排除重复文章，由qqdie修复
            }
            return $select;
        }
    }

    /**
     * 为feed过滤掉加密的分类内容
     * @param $archive
     * @param $select
     * @return mixed
     */
    public static function CateFilterForFeed($archive, $select){
        if('/feed' != strtolower(Typecho_Router::getPathInfo()) && '/feed/' != strtolower
            (Typecho_Router::getPathInfo())) return $select;//

        $CateIds = Typecho_Widget::widget('Widget_Options')->plugin('Handsome')->LockId;
        if(!$CateIds) return $select;       //没有写入值，则直接返回
        $select = $select->select('table.contents.cid', 'table.contents.title', 'table.contents.slug', 'table.contents.created', 'table.contents.authorId','table.contents.modified', 'table.contents.type', 'table.contents.status', 'table.contents.text', 'table.contents.commentsNum', 'table.contents.order','table.contents.template', 'table.contents.password', 'table.contents.allowComment', 'table.contents.allowPing', 'table.contents.allowFeed','table.contents.parent')->join('table.relationships','table.relationships.cid = table.contents.cid','left')->join('table.metas','table.relationships.mid = table.metas.mid','left')->where('table.metas.type=?','category');
        $CateIds = explode(',', $CateIds);
        $CateIds = array_unique($CateIds);  //去除重复值
        foreach ($CateIds as $k => $v) {
            $select = $select->where('table.relationships.mid != '.intval($v))->group('table.relationships.cid');//确保每个值都是数字；排除重复文章，由qqdie修复
        }
        return $select;
    }

    public static function exceptFeed($con,$obj,$text)
    {
        $text = empty($text)?$con:$text;
        if(!$obj->is('single')){
            $text = preg_replace("/\[login\](.*?)\[\/login\]/sm",'',$text);
            $text = preg_replace("/\[hide\](.*?)\[\/hide\]/sm",'',$text);
        }
        return $text;
    }


    public static function  footer(){
?>
<script>
SearchConfig = {
    url : "<?php Helper::options()->pluginUrl('Handsome/cache/search.json'); ?>"
}
</script>

<?php

}

}

class Title_Plugin extends Typecho_Widget_Helper_Form_Element
{

    public function label($value)
    {
        /** 创建标题元素 */
        if (empty($this->label)) {
            $this->label = new Typecho_Widget_Helper_Layout('label', array('class' => 'typecho-label', 'style'=>'font-size: 2em;border-bottom: 1px #ddd solid;padding-top:2em;'));
            $this->container($this->label);
        }

        $this->label->html($value);
        return $this;
    }

    public function input($name = NULL, array $options = NULL)
    {
        $input = new Typecho_Widget_Helper_Layout('p', array());
        $this->container($input);
        $this->inputs[] = $input;
        return $input;
    }

    protected function _value($value) {}

}