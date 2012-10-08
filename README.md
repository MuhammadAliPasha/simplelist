Simplelist
===========

#### Easy to use flexible list ####

Flexible list with paging, searching, sorting, and adding buttons. 
Simplelist is very powerful tool, you can use it in simple way, but it has possibility to create list for advance queries.


### Quickstart ###

* Clone simplelist into *APPPATH/bundles/*
* Edit *APPPATH/application/bundles.php*

```php

<?php
// APPPATH/application/bundles.php
return array(
  'simplelist' => array('auto' => true),
);
```

###Features###

* Pagination
* Sorting and enable,disable sort in every column
* Search by many or one column
* Adding action buttons, possibility to add button with own attributes 
* Values of columns can be created from many columns and html tags ex. img src="path/@id/file.@ext"
* Set own language file for column names
* Full customization possibility

Content standards for column content and button action is string with @ tag for columns. You can set
which columns will be in this string. You can use it for images, dom attributes, js
scripts and content different than only column value.


### Usage ###

Quick use

```php
$param=new SimpleList_Param();
$param->query = DB::table('banner');//query 
$param->columns=array('id','name');//columns on list

return View::make('admin::banner.index')->with(array('list'=>SimpleList::generate($param)));

```


Simple list use
```php
$param=new SimpleList_Param();
$param->query = DB::table('banner');//query 
$param->columns=array('id','name');//columns on list
$param->sort = true;//is sorting enabled

/**
 * Button is default <a class="simplelist_button"></a> but you can change a to something else and class for different class
 */
$button1=new SimpleList\Button();//create button
$button1->action="/admin/banner/edit/@id/";//button href - @id will be id of row. You can set every column in button action variable ex. @name
$button1->name='Edit'; // name displayed in button


$button2=new SimpleList\Button();
$button2->action="/admin/banner/delete/@id/";
$button2->name='Delete';

$param->buttons=array(
	$button1,$button2
);

return View::make('admin::banner.index')->with(array('list'=>SimpleList::generate($param)));
```

And in your blade view:

```php
{{$list}}
```

Advanced use

```php

/**
 * if we have complex column we create it by param
 */
$cparam = new \SimpleList\Column\Param();
$cparam->db = 'thumbnail_ext'; //column in db
$cparam->sort = false; //no sorting by this column
$cparam->content = '<img src="'.Config::get('admin::video.thumbnail_save_path').'/@id.@thumbnail_ext" />'; //comtent @name will be name column in current row
$img = SimpleList\Column::createByParam($cparam);

$list_param->columns = array('video.id','title','video.created_at','category.name',$img);//columns for list
$list_param->search_cols = array('title','video.id','category.name'); //columns for search
 
$list_param->sort = true;//sort is enabled
$list_param->per_page = 5;//5 per page
$list_param->bundle = 'admin';//if simplelist is used in bundle it will be used to lang file ex. bundlename::lang_filename to lang the columns name
$list_param->lang_filename = Config::get('admin::video.lang_filename');//gets this lang name 

$edit_button = new SimpleList\Button();
$edit_button->action = '/admin/video/edit/@id';
$edit_button->name = 'Edit';
$delete_button = new SimpleList\Button();
$delete_button->action = '/admin/video/delete/@id';
$delete_button->name = 'Delete';

$list_param->buttons = array(
    $edit_button,
    $delete_button
);
 
return View::make('admin::video.list')->with('list',SimpleList::generate($list_param));

```

Simplelist config file:
```php

return array(
'table_class'=>'simplelist',
'td_class'=>'simplelist_td',
'span_class'=>'simplelist_span',
'search_class'=>'simplelist_search',
'button_class'=>'button',//buttons class
'button_element'=>'a',//dom element of buttons
'button_action_attr'=>'href',// attribute of action in buttons
'lang_filename'=>'simplelist', //file name to get
'per_page'=>20
);

```


SimpleList Param file:
```php

	$param = new \SimpleList\Column\Param();
	
	$param->sort=false;// set is sorting
	$param->default_sort_col=false;//set default sort col
	$param->default_sort_type=false;// set default type desc,asc
	
	$param->search_cols=array();//cols to search
	$param->query;//Db::table('name')->where.... 
	$param->per_page=20;
	$param->columns=array();//columns in list
	
	/** 
	 * this values are set from config but can be changed in every instance of list
	 */
	$param->table_class;
	$param->bundle;
	$param->buttons;
	$param->lang_filename;
	$param->span_class;
	$param->td_class;
	$param->search_class;

```

###HELP

Need help? Contact me on maciej.sikora@bossbyte.com.

