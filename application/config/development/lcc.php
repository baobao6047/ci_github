<?php

// 各站点域名（若定义其它站点，则格式为：domain_主域名_二级域名）
$config['domain_src'] = 'http://src.lcc1.com/';
$config['domain_img'] = 'http://img.o2o1.com/';

//会员模块图片上传
$config['_root_dir'] = 'F:\data';// 网站物理根目录
// $config['_root_dir'] = '/data/img/ci_img';// 网站物理根目录
$config['_allowed_file_type'] = array('jpg', 'jpeg', 'png');
$config['_allowed_file_size'] = '204800';// 200KB
//cookie 站点
$config['cookie_domain'] = 'o2o1.com';