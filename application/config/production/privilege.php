
<?php 
/**
 * 权限控制配置
 * 
 * 编辑本文件时，请注意以下几点：
 * 1、_id_字段是一个版本4的UUID，可以在 https://1024tools.com/uuid 生成。
 * 2、不要重复使用UUID（即使旧UUID已经被删除）。每需要添加一个新的操作时，就生成一个新的UUID。
 * 3、如果用规范的生成方式（例如上面的网站），几乎可以不用担心重复。
 * 4、操作的层级只有3层，并且总是有3层。
 * 5、第1、2层没有 codes 字段，只有第3层有。
 * 6、直接移动项目来进行排序。
 * 7、设置is_open = false来关闭某个操作，这样所有人都不能访问其中的方法。
 * 8、关闭了某操作后，其下层操作也会被关闭。
 * 9、编辑本文件后，在项目根目录运行 sk privilege check 来检查错误。
 */
$config['privilege'] = array (
	'会员管理' => array (
		'_id_' => 'd7d778c3-87d1-49e6-bbf4-1dc56aad68ed',
		'children' => array (
			'商家列表' => array (
				'_id_' => '2280ed39-681d-472c-9e78-1a53a1d6a4c0',
				'children' => array (
					'浏览商家列表' => array (
						'_id_' => 'e2377ba2-4884-448d-904e-04eeba5fa3b9',
						'codes' => array ( 'userlist-sellers~view' ),
					),
				    '屏蔽商家帐号' => array (
				        '_id_' => '9a4fb5c1-612c-40d1-a323-eafa5226d7ce',
				        'codes' => array ( 'user-block~seller' ),
				    ),
					'封杀商家帐号' => array (
						'_id_' => '1b3998f4-f2e9-4211-9c34-d50619a68589',
						'codes' => array ( 'user-ban~seller' ),
					),
					'重置登录密码' => array (
						'_id_' => '2177e727-6b08-4663-ab07-100d548b1cf0',
						'codes' => array ( 'user-edit_password~seller_login' ),
					),
					'重置支付密码' => array (
						'_id_' => 'ef459598-5bdc-4b68-a159-bf1a583bb452',
						'codes' => array ( 'user-edit_password~seller_pay' ),
					),
					'发站内信' => array (
						'_id_' => '9f16c5bd-92c1-4643-9b53-6b7c18c4d3c0',
						'codes' => array ( 'sendmsg-usersend~seller' ),
					),
					'变更昵称' => array (
						'_id_' => '3e794f4a-cfc0-4c65-a69e-77e0005ab9a0',
						'codes' => array ( 'user-edit_nickname~seller' ),
					),
					'清空商家邮箱/手机' => array (
						'_id_' => '96c3d6aa-79f7-4e5d-81c0-1ccb60cfbcea',
						'codes' => array ( 'user-clear_email_mobile~seller' ),
					),
					'封号且删活动' => array (
						'_id_' => '3e13b2ec-d099-4ac9-9522-8ad81bc9923d',
						'codes' => array ( 'user-wipe_out_seller' ),
					),
					'变更维护人员' => array (
						'_id_' => 'cb77675c-0750-42d6-bf27-bf49ef9947af',
						'codes' => array ( 'user-edit_maintainer', 'user-update_salesman' ),
					),
					'导出xls' => array (
						'_id_' => '6e7fbf8b-d293-419a-abf7-a610c33754b5',
						'codes' => array ( 'userlist-sellers~export' ),
					),
					'赠送VIP' => array (
						'_id_' => 'd3535e78-9a1b-485c-9c2c-507d0eb85208',
						'codes' => array ( 'user-give_vip' ),
					),
				),
			),
			'试客列表' => array (
				'_id_' => '403be249-51a8-4aa6-8ac8-20aaa4b6addf',
				'children' => array (
					'浏览试客列表' => array (
						'_id_' => 'f04eef2f-374f-4f21-95a8-a247c63ad775',
						'codes' => array ( 'userlist-buyers' ),
					),
					'封杀试客帐号' => array (
						'_id_' => '5b5e7154-2c89-4232-9fb2-b392611017c6',
						'codes' => array ( 'user-ban~buyer' ),
					),
					'屏蔽试客帐号' => array (
						'_id_' => '54065649-0053-445a-8a71-58c7fc6bc75b',
						'codes' => array ( 'user-block~buyer' ),
					),
					'重置登录密码' => array (
						'_id_' => '2a1b40f2-2656-4f1a-9f7a-bcf41e9da5d4',
						'codes' => array ( 'user-edit_password~buyer_login' ),
					),
					'重置支付密码' => array (
						'_id_' => '215be129-89b4-4d14-93c9-0a61fee47951',
						'codes' => array ( 'user-edit_password~buyer_pay' ),
					),
					'发站内信' => array (
						'_id_' => '1cb530a8-59c7-410b-88ab-0d5c264e0695',
						'codes' => array ( 'sendmsg-usersend~buyer' ),
					),
					'变更昵称' => array (
						'_id_' => '96d4d53b-a09f-41b6-96bf-70dd65d66c52',
						'codes' => array ( 'user-edit_nickname~buyer' ),
					),
					'清空试客邮箱/手机' => array (
						'_id_' => 'd199ec72-f7df-4ac8-bcb7-5dbb8e289c60',
						'codes' => array ( 'user-clear_email_mobile~buyer' ),
					),
					'清空淘宝账号' => array (
						'_id_' => '020bc7cf-ca34-4c40-8f37-3f52ba2a6291',
						'codes' => array ( 'userlist-unbind_taobao' ),
					),
					'清除违规记录' => array (
						'_id_' => '6ffb1137-a5f0-45aa-8138-eb1650432943',
						'codes' => array ( 'user-user_lock_detail~buyer' ),
					),
					'绑定淘宝号' => array (
						'_id_' => '530f3cfe-abf2-488b-9d96-c621843dde43',
						'codes' => array ( 'user-add_bind_taobao~buyer' ),
					),
				),
			),
			'封号列表' => array (
				'_id_' => '3f0c0d2b-59f7-47fc-8165-bae1fe7ee6e9',
				'children' => array (
					'浏览封号列表' => array (
						'_id_' => '6aed74e2-109c-4dff-8c56-ddc3f48c3abd',
						'codes' => array ( 'userlist-banned' ),
					),
					'解封帐号' => array (
						'_id_' => '670254f8-ec1c-4114-a3e8-17f25bbacdb4',
						'codes' => array ( 'user-unban' ),
					),
				),
			),
			'屏蔽列表' => array (
				'_id_' => 'a00c8062-4e56-4798-80b8-5cfc03b4380b',
				'children' => array (
					'浏览屏蔽列表' => array (
						'_id_' => '83398cbf-bd84-4dab-b323-8bdfdb2825cf',
						'codes' => array ( 'userlist-blocked' ),
					),
					'解屏帐号' => array (
						'_id_' => 'cf4b3c7f-9a77-49cf-bdf1-5370c23a6c20',
						'codes' => array ( 'user-unblock' ),
					),
					'封杀帐号' => array (
						'_id_' => '9bfa1f0a-eaca-4704-be91-63cf72ab1850',
						'codes' => array ( 'user-ban~seller', 'user-ban~buyer' ),
					),
				),
			),
			'店铺列表' => array (
				'_id_' => 'fba5b0e6-8392-4d2f-9bfb-074835687ef8',
				'children' => array (
					'浏览店铺列表' => array (
						'_id_' => 'c24a294c-6340-4c59-9e20-4dcb74280a30',
						'codes' => array ( 'userlist-vips' ),
					),
				),
			),
			'群发消息' => array (
				'_id_' => 'b1ca20ac-2e9a-40c7-a270-b1e441973651',
				'children' => array (
					'指定用户发送' => array (
						'_id_' => '6dd28ffa-857c-4c01-846d-32b9accd01db',
						'codes' => array ( 'sendmsg-sendm~by_user', 'sendmsg-index' ),
					),
					'指定用户类型发送' => array (
						'_id_' => '67361d1d-fa04-4138-a50f-4ed45ddd50fe',
						'codes' => array ( 'sendmsg-sendm~by_group', 'sendmsg-index' ),
					),
				),
			),
			'试用报告' => array (
				'_id_' => 'c9823404-ab67-43e7-825d-f96f41457dfc',
				'children' => array (
					'查看报告列表' => array (
						'_id_' => 'a8adc7aa-0610-4bce-a14c-8f5266f3f34e',
						'codes' => array ( 'report-rlist' ),
					),
					'查看不通过原因' => array (
						'_id_' => 'c7895ac6-d058-419c-bd6f-957cbf0e78e6',
						'codes' => array ( 'report-get_failure_reason' ),
					),
					'报告加精' => array (
						'_id_' => '00bf585c-cc29-4aca-bad8-2efe1479bfce',
						'codes' => array ( 'report-essence~set' ),
					),
					'取消加精' => array (
						'_id_' => 'b225fca4-4ae0-47bf-a92d-eb2669f40b77',
						'codes' => array ( 'report-essence~cancel' ),
					),
					'报告劣质' => array (
						'_id_' => '24112bfb-ac52-4b4e-9de7-2f5623add086',
						'codes' => array ( 'report-poor~set' ),
					),
					'取消劣质' => array (
						'_id_' => 'd9e9347f-b747-47c9-bb7c-0c9758bfec78',
						'codes' => array ( 'report-poor~cancel' ),
					),
					'编辑标签' => array (
						'_id_' => 'a0fe9cc7-4b0f-4cdd-8d3e-afc25e858da0',
						'codes' => array ( 'report-edit_tags' ),
					),
					'报告审核' => array (
						'_id_' => '85b13e2d-ca06-4dc8-99b7-8ba6a97ea75c',
						'codes' => array ( 'report-check_report', 'report-review' ),
					),
				),
			),
			'赠送VIP列表' => array (
				'_id_' => 'e9b14dcb-655e-4996-80ca-f96095642af4',
				'children' => array (
					'浏览赠送VIP列表' => array (
						'_id_' => '2dae0b5e-c4a7-4b9d-ba54-79df75e8668d',
						'codes' => array ( 'userlist-experience_vips' ),
					),
				),
			),
			'达人秀管理列表' => array (
				'_id_' => '3a79a3e1-673b-42bf-bfcf-53a416529bf4',
				'children' => array (
					'浏览达人秀会员列表' => array (
						'_id_' => '8b6a96e4-88a8-4b0e-9f30-af998e404844',
						'codes' => array ( 'daren-daren-index' ),
					),
					'浏览达人认证申请列表' => array (
						'_id_' => 'dff48fa2-6951-413c-b3f9-86996da3c2af',
						'codes' => array ( 'daren-apply-index' ),
					),
					'取消认证' => array (
						'_id_' => '6e8393e7-0710-4439-8a5d-04bbe15902b4',
						'codes' => array ( 'daren-daren-cancel' ),
					),
					'通过认证' => array (
						'_id_' => '6c03e6fb-6234-4a89-8529-e63553011ea8',
						'codes' => array ( 'daren-apply-handle~pass' ),
					),
					'不通过认证' => array (
						'_id_' => '22ed940b-27d0-40df-bc28-015ef5ac37c0',
						'codes' => array ( 'daren-apply-handle~reject' ),
					),
					'删除达人秀' => array (
						'_id_' => '969c80b7-bbb2-4e99-bc05-f60e3e38bf64',
						'codes' => array ( 'daren-daren-delete_post' ),
					),
				),
			),
		),
	),
	'活动管理' => array (
		'_id_' => '881492c7-9e5c-43b6-baa1-115393ca2972',
		'children' => array (
			'活动列表' => array (
				'_id_' => '3d1fe443-1164-405b-af4c-32e5b17a69da',
				'children' => array (
					'所有活动列表' => array (
						'_id_' => '7c4bc10f-6c57-4356-b0cc-aecf96a4e5e7',
						'codes' => array ( 'trys-alllist~unlimited' ),
					),
					'浏览待审核活动' => array (
						'_id_' => 'c533f80e-87e7-4b25-a5c8-9acc0310632b',
						'codes' => array ( 'trys-plist~unlimited' ),
					),
					'浏览待上线活动' => array (
						'_id_' => 'ad2100f1-43d5-4c20-9b8e-0c55c91fecc6',
						'codes' => array ( 'trys-uplist~unlimited' ),
					),
					'所有活动列表（代理商）' => array (
						'_id_' => '4bbcd881-e458-47d6-8ed2-444c05f163c7',
						'codes' => array ( 'trys-alllist~dailishang' ),
					),
					'浏览待审核活动（代理商）' => array (
						'_id_' => '0ccfe68e-0a1b-4f7e-ad5a-4d8d1aa4290f',
						'codes' => array ( 'trys-plist~dailishang' ),
					),
					'浏览待上线活动（代理商）' => array (
						'_id_' => 'b5efbf6c-9cb1-48ac-ae51-cd309074a9d0',
						'codes' => array ( 'trys-uplist~dailishang' ),
					),
					'浏览进行中活动' => array (
						'_id_' => 'a59aa9c0-08f6-42f3-980f-231abd585f3f',
						'codes' => array ( 'trys-inlist' ),
					),
					'浏览已结束活动' => array (
						'_id_' => '40e581dc-7637-4c4e-84a7-f753484947e0',
						'codes' => array ( 'trys-ulist' ),
					),
					'浏览已结算活动' => array (
						'_id_' => '115aa3ae-ed44-4eec-878c-1aa6a4ebb868',
						'codes' => array ( 'trys-settled' ),
					),
					'浏览已屏蔽活动' => array (
						'_id_' => 'd2bb3d74-0f66-4836-abf8-0ddf67461eee',
						'codes' => array ( 'trys-masked' ),
					),
					'浏览已违规活动' => array (
						'_id_' => '20b73783-b3ca-4405-9f4c-a2475adc194d',
						'codes' => array ( 'trys-violate' ),
					),
					'修改活动' => array (
						'_id_' => '56483d84-b373-44e4-8181-e2a7d1d7e236',
						'codes' => array ( 'trys-edit' ),
					),
					'删除活动' => array (
						'_id_' => 'd980acc6-b593-4a1c-a459-237b5a593796',
						'codes' => array ( 'trys-trydel' ),
					),
					'审核通过活动' => array (
						'_id_' => '1a861fb0-61a7-4000-a79e-1c33357e6d8d',
						'codes' => array ( 'trys-pass' ),
					),
					'取消通过活动' => array (
						'_id_' => 'ed0fffd4-4e81-4580-bedf-417a1efb6905',
						'codes' => array ( 'trys-cancle' ),
					),
					'上线活动' => array (
						'_id_' => '4c3a098a-aeb3-4de0-8c22-b66b80078c86',
						'codes' => array ( 'trys-upline' ),
					),
					'设置活动屏蔽' => array (
						'_id_' => 'e80f563b-e918-4dc7-b6e0-f1dfd88a36c7',
						'codes' => array ( 'trys-locktry' ),
					),
					'解除活动屏蔽' => array (
						'_id_' => '630e4e4f-3e44-4908-8ae1-c4a581921472',
						'codes' => array ( 'trys-unlockall' ),
					),
					'设置活动违规' => array (
						'_id_' => 'c5228f20-2dc5-4674-ab98-eedd5f344573',
						'codes' => array ( 'trys-vtry' ),
					),
					'解除活动违规' => array (
						'_id_' => '7ecca201-ef2d-445b-b595-773f479e858f',
						'codes' => array ( 'trys-unlockallv' ),
					),
					'执行结算活动' => array (
						'_id_' => 'cd2daec4-ce5b-44ec-ac68-ebf31ee1f4e3',
						'codes' => array ( 'trys-settlement', 'trys-untry', 'trys-untrysave' ),
					),
					'放入通过劵' => array (
						'_id_' => 'fafc6d16-e7e5-46f7-847b-7a3df00e5bcd',
                        'is_open' => false,
						'codes' => array ( 'trys-punish' ),
					),
					'导出xls' => array (
						'_id_' => 'bf1175f6-f43a-4812-b4ab-e418b53f1f57',
						'codes' => array ( 'trys-exportxls' ),
					),
					'批量屏蔽活动' => array (
						'_id_' => 'e83b430f-ef9e-48d8-aa9c-04a82e29d2cb',
						'codes' => array ( 'trys-batch_postlocktry' ),
					),
					'浏览待审核付费试用列表' => array (
						'_id_' => '9afc4051-7cc4-4ae1-9098-52317e07c531',
						'codes' => array ( 'trys-plist_pay' ),
					),
					'浏览待上线付费试用列表' => array (
						'_id_' => '02f643c3-86ef-46ea-a33e-6317f5df39e5',
						'codes' => array ( 'trys-uplist_pay' ),
					),
					'审核通过付费试用活动' => array (
						'_id_' => '20414e14-81ab-421c-818f-bebb3f4b6123',
						'codes' => array ( 'trys-pass~pay' ),
					),
					'取消通过付费试用活动' => array (
						'_id_' => '92d282ed-1a19-4436-9b67-a3fe09ae5a8c',
						'codes' => array ( 'trys-cancle~pay' ),
					),
					'上线付费试用活动' => array (
						'_id_' => 'f60bf106-d805-4fa7-850d-5e9fa84015a1',
						'codes' => array ( 'trys-upline~pay' ),
					),
					'隐藏活动' => array (
						'_id_' => 'a455a113-ab60-41dd-880e-b541a03f9fdb',
						'codes' => array ( 'trys-show_switch' ),
					),
					'搜索认领人员' => array (
						'_id_' => '2d947b2e-36f9-492e-a2f2-85a2c4b56d67',
						'codes' => array ( 'trys-search_salesman' ),
					),
					'搜索维护人员' => array (
						'_id_' => '3f9792c8-82d4-4640-a197-1f18fa19aea0',
						'codes' => array ( 'trys-search_maintainer' ),
					),
				),
			),
			'参与管理' => array (
				'_id_' => '1044f106-24aa-4425-8f99-06a8a857ee94',
				'children' => array (
					'进入审批试客' => array (
						'_id_' => '252bcd9f-9db3-4ea7-bc7e-f2fc7a5ccc9a',
						'codes' => array ( 'trys-approval' ),
					),
					'通过试客资格' => array (
						'_id_' => 'c0af8817-a964-400c-8b5c-e3f72d8e01af',
						'codes' => array ( 'trys-passmore' ),
					),
					'取消试客资格' => array (
						'_id_' => 'b9d88868-cf3b-451a-a765-6cb3817d3ec2',
						'codes' => array ( 'trys-cancletryuser', 'trys-downuser' ),
					),
				),
			),
			'活动分类' => array (
				'_id_' => 'aaa0d0a7-d7a4-44c5-83d5-1c9d0c564c7c',
				'children' => array (
					'查看活动分类' => array (
						'_id_' => '81e6d026-1543-4091-9ca6-9d17bd55554e',
						'codes' => array ( 'trycate-index' ),
					),
					'添加活动分类' => array (
						'_id_' => '2e309c7e-6d09-4f95-b83a-74b14796a269',
						'codes' => array ( 'trycate-save~new' ),
					),
					'修改活动分类' => array (
						'_id_' => 'c890bc70-0d47-47b9-8644-3d0d2be46cd6',
						'codes' => array ( 'trycate-edit', 'trycate-save~old' ),
					),
					'删除活动分类' => array (
						'_id_' => '7c6f0dd1-1428-4452-98cb-87e70d154fec',
						'codes' => array ( 'trycate-del' ),
					),
				),
			),
			'申诉管理' => array (
				'_id_' => '7b7a182e-677e-4684-8d11-ca497aa069e7',
				'children' => array (
					'查看待处理申诉' => array (
						'_id_' => '2e1798c7-6a45-44e2-9b24-8bab91101bbb',
						'codes' => array ( 'appeal-unhandled' ),
					),
					'查看已处理申诉' => array (
						'_id_' => '5bac8ed6-8d11-49df-ad88-d03d1c8f63e2',
						'codes' => array ( 'appeal-handled' ),
					),
					'查看申诉分类' => array (
						'_id_' => '2ade8186-f5ab-4130-afaa-06757f5c5b79',
						'codes' => array ( 'appeal-types' ),
					),
					'介入处理' => array (
						'_id_' => 'a6876bd3-ddfd-48b2-b11d-b577609a65ab',
						'codes' => array ( 'appeal-handle' ),
					),
					'申诉分类修改' => array (
						'_id_' => '8ebad784-232c-448a-9b08-77fda5c3089d',
						'codes' => array ( 'appeal-edit_type' ),
					),
					'申诉分类添加' => array (
						'_id_' => '7e71f0c7-e930-44d3-9fa2-26741efb8770',
						'codes' => array ( 'appeal-add_type' ),
					),
					'批量完成试用' => array (
						'_id_' => 'c7ca164c-0886-4db9-9588-e7e34dcd587a',
						'codes' => array ( 'appeal-batch_finish' ),
					),
					'批量终止试用' => array (
						'_id_' => 'f4f57a85-87c6-48bd-8a46-35e324828ec5',
						'codes' => array ( 'appeal-batch_finish_failure' ),
					),
					'申诉数据统计' => array (
						'_id_' => 'c388ebc3-7eab-4c59-8ce6-4543744c5a81',
						'codes' => array ( 'appeal-handled_stat' ),
					),
				    '批量撤销申诉' => array (
				        '_id_' => '12e0a8f6-2544-456d-8800-2abc63f68397',
				        'codes' => array ( 'appeal-batch_repeal' ),
				    ),
					'查看商家维护人员备注' => array (
						'_id_' => '544193a6-f9db-4a5c-8604-789073d54bec',
						'codes' => array ( 'appeal-get_maintainer_tips' ),
					),
					'编辑商家维护人员备注' => array (
						'_id_' => '2cb264c1-1ceb-4204-8bf6-c78013347dd9',
						'codes' => array ( 'appeal-maintainer_tips' ),
					),
				),
			),
		),
	),
	'店铺管理' => array (
		'_id_' => '1c0dd13c-e3f1-4e62-accb-4c3670fba78b',
		'children' => array (
			'所有店铺绑定列表' => array (
				'_id_' => '44e10295-ff0b-4640-ad60-9f488ed67076',
				'children' => array (
					'浏览所有店铺绑定列表' => array (
						'_id_' => '59ce1521-cbce-49f5-b6ee-feaecb68012d',
						'codes' => array ( 'shop-all_bind_list' ),
					),
					'修改店铺' => array (
						'_id_' => 'a171ab9a-8d77-47a4-b613-8ca09290fa0f',
						'codes' => array ( 'shop-op_alter' ),
					),
					'解绑店铺' => array (
						'_id_' => '21c82c53-aebf-41ef-b962-23595e8601c4',
						'codes' => array ( 'shop-op_unbound' ),
					),										
				),
			),
			'店铺修改申请列表' => array (
				'_id_' => 'e8134335-d0da-45a7-8ba2-c1744d6fc650',
				'children' => array (
					'浏览店铺修改申请列表' => array (
						'_id_' => 'c937b740-0a23-4af9-bf3f-932c061abf99',
						'codes' => array ( 'shop-untreated_list', 'shop-processed_list' ),
					),
					'通过/不通过申请' => array (
						'_id_' => 'f7d5f90c-02a0-4b54-8806-5aee10f4ee18',
						'codes' => array ( 'shop-op_pass' ),
					),
					'查看详情' => array (
						'_id_' => '40a4f2d0-d2eb-435b-8ec8-69e2af93f285',
						'codes' => array ( 'shop-op_reason' ),
					),				
				),
			),
			'店铺变更记录' => array (
				'_id_' => '63e53b85-6af1-40e0-a5bb-706635bf94a5',
				'children' => array (
					'浏览店铺变更记录' => array (
						'_id_' => 'aba446d2-524e-4cda-9bef-dac13dcb9e0a',
						'codes' => array ( 'shop-alter_list' ),
					),
				),
			),
		),
	),
	'推送管理' => array (
		'_id_' => '87e1c384-ab95-4765-88a5-da01ae9b2c28',
		'children' => array (
			'推送管理' => array (
				'_id_' => 'b0fc1825-9ca9-49ed-980f-d8a215dfb9d9',
				'children' => array (
					'进入推送管理' => array (
						'_id_' => '7783d2ef-60c8-4f71-a7b7-be6bce0a5e6b',
						'codes' => array ( 'recommend_new', 'recommend' ),
					),
					'顶部广告编辑' => array (
						'_id_' => 'cd17ffd9-fb1f-40e7-98d1-2c9d0de45f2b',
						'codes' => array ( 'recommend_new-home-indexad' ),
					),
				),
			),
			'专题管理' => array (
				'_id_' => 'cb00c345-977a-4de1-9659-7c4e77714f67',
				'children' => array (
					'创建专题' => array (
						'_id_' => '79b65647-bdd6-4c5c-86c8-2196c8763b33',
						'codes' => array ( 'recommend_new-festival-add' ),
					),
					'修改专题' => array (
						'_id_' => '1bea57bc-cd27-4228-ae7b-064c92b4bc8b',
						'codes' => array ( 'recommend_new-festival-edit' ),
					),
					'预览专题' => array (
						'_id_' => 'aa096c3f-b42d-4766-aad3-5f428cb3fdf1',
						'codes' => array ( 'recommend_new-festival-preview' ),
					),
					'上线专题' => array (
						'_id_' => '3a2f6624-1fb3-4e8a-8e9a-e1b26341d396',
						'codes' => array ( 'recommend_new-festival-show' ),
					),
					'下线专题' => array (
						'_id_' => '00463060-7efa-454a-8d63-34c53f8e5500',
						'codes' => array ( 'recommend_new-festival-hidden' ),
					),
					'专题列表' => array (
						'_id_' => 'f160537d-f0fa-4c91-b0a3-205af94167e6',
						'codes' => array ( 'recommend_new-festival-index' ),
					),
					'专题操作动作' => array (
						'_id_' => '89296f2e-54a7-4787-ac91-632735997223',
						'codes' => array ( 'recommend_new-festival-editsave', 'recommend_new-festival-get_try', 'recommend_new-festival-save_img', 'recommend_new-festival-section_del', 'recommend_new-festival-try_del' ),
					),
				),
			),
		),
	),
	'通过劵管理' => array (
		'_id_' => '0aa9dbff-dcb7-4266-b609-776f4430983a',
		'is_open' => false,
		'children' => array (
			'通过劵管理' => array (
				'_id_' => '1075f77a-201d-4798-9cc7-38d40ccdd9ea',
				'children' => array (
					'查看发放记录' => array (
						'_id_' => 'af7b2a3b-4092-4b62-80d6-98d58ba1dddf',
						'codes' => array ( 'pass-index' ),
					),
					'查看扣除记录' => array (
						'_id_' => '5c251bdd-9c4a-4ce4-a525-ebf89647fa3c',
						'codes' => array ( 'pass-user_pass_list' ),
					),
					'查看通过劵日志' => array (
						'_id_' => 'ceb03a7b-eff1-42bb-b2c7-ae385faeb5b3',
						'codes' => array ( 'pass-look_log' ),
					),
					'查看通过劵类型' => array (
						'_id_' => 'b3ecdde0-ffdb-4b11-9559-e3d56db649e5',
						'codes' => array ( 'pass-type' ),
					),
					'停用通过劵类型' => array (
						'_id_' => '2d12c10e-59d1-449c-a7a5-356fa1b62a42',
						'codes' => array ( 'pass-type_open~off' ),
					),
					'发放通过劵' => array (
						'_id_' => 'b072f72b-364e-4405-8e91-28ca2295a522',
						'codes' => array ( 'pass-add' ),
					),
					'启用通过劵类型' => array (
						'_id_' => '520d542a-6a31-487b-b65e-811de253e888',
						'codes' => array ( 'pass-type_open~on' ),
					),
					'扣除通过劵' => array (
						'_id_' => '479930f8-aadd-4f83-894c-f982140b2e0a',
						'codes' => array ( 'pass-cancel' ),
					),
				),
			),
		),
	),
	'财务系统' => array (
		'_id_' => '6fce490c-6e15-4566-9eb1-c9e48e1e8400',
		'children' => array (
			'财务系统' => array (
				'_id_' => '6b0299e4-452a-4938-9a07-225fbdf84cc9',
				'children' => array (
					'查看vip商家列表' => array (
						'_id_' => '682bb419-f763-430e-84c7-1baaa4d18f40',
						'codes' => array ( 'finance-viplist' ),
					),
					'查看vip延长记录' => array (
						'_id_' => '7ad66634-5cae-4edd-9d5d-2cdf0236953d',
						'codes' => array ( 'finance-extend' ),
					),
					'查看vip支付记录' => array (
						'_id_' => 'efeb08f3-9967-4baf-aa32-a7d1025a9282',
						'codes' => array ( 'finance-pay' ),
					),
					'查看vip注销记录' => array (
						'_id_' => 'd24e64f3-ded2-44ea-8aa5-43bdb4d1a852',
						'codes' => array ( 'finance-withdraw' ),
					),
					'查看活动业绩统计' => array (
						'_id_' => 'a59f7ac8-243d-40ec-8616-fcf2bf55322e',
						'codes' => array ( 'finance-achlist' ),
					),
					'上线业绩统计' => array (
						'_id_' => 'f528bc04-7016-4529-a014-4069ceda07c7',
						'codes' => array ( 'finance-online_achlist' ),
					),
					'增值服务购买记录列表' => array (
							'_id_' => '583c0507-6c82-438e-9867-e1c2827ae53b',
							'codes' => array ( 'service-pays', 'service-exportachlist'),
					),
					'延长vip' => array (
						'_id_' => '7f63ab87-dc44-416d-9b52-0e1a530c71b7',
						'codes' => array ( 'finance-extendvip', 'finance-extendvipsave' ),
					),
					'取消vip' => array (
						'_id_' => 'aa4549ec-f67f-43b5-86e8-63b8fa42f8ef',
						'codes' => array ( 'finance-canclevip', 'finance-canclevipsave' ),
					),
					'变更认领人员' => array (
						'_id_' => 'ac7c12bf-ee4f-410d-aff8-1e6324cf1406',
						'codes' => array ( 'finance-payclaim', 'finance-payclaimt' ),
					),
					'导出xls' => array (
						'_id_' => '62987ef7-c698-4335-88a4-278677c70a2f',
						'codes' => array ( 'finance-exportpay', 'finance-exportachlist', 'finance-viplist~export', 'finance-export_online_achlist' ),
					),
					'查看协议' => array (
						'_id_' => 'efc68d2b-0c7d-4ed4-bad1-d8233ebafd62',
						'codes' => array ( 'finance-vip_list', 'finance-get_protocol' ),
					),
					'批量延长VIP时长' => array (
						'_id_' => '26cf3736-c8fc-44fe-8af9-6b96a6a5cc04',
						'codes' => array ( 'finance-batch_extend_vip' ),
					),
				),
			),
		),
	),
	'数据分析' => array (
		'_id_' => '61018109-855a-4f8e-96ba-7b526b5331f4',
		'children' => array (
			'活动统计' => array (
				'_id_' => '01f2ae56-3f8e-4a1c-b663-dc1f1b4bc888',
				'children' => array (
					'查看活动统计' => array (
						'_id_' => 'a358b1a0-d6dc-4dc0-a94b-d93c40f0c157',
						'codes' => array ( 'analyse-trys' ),
					)
				),
			),
            '试用搜索数据统计' => array (
                '_id_' => '790effa5-887d-478b-a65f-ac6b4e250ba0',
                'children' => array (
                    '查看试用搜索数据统计' => array (
                        '_id_' => '59fb0bbe-0e75-45cc-b3f6-6ee146db8856',
                        'codes' => array ( 'wishlist_stat-index' ),
                    ),
                    '导出试用搜索数据' => array (
                        '_id_' => '28d77994-ef7b-4c42-8251-939315a1de31',
                        'codes' => array ( 'wishlist_stat-export_stat' ),
                    ),
                ),
            ),
		),
	),
	'系统配置' => array (
		'_id_' => '9f2c25cd-8ea0-49ac-8e10-d9c18b1a3927',
		'children' => array (
			'营销活动配置' => array (
					'_id_' => '9312104e-bd10-4285-ab09-4f68d7cd8f57',
					'children' => array (
							'营销活动配置' => array (
									'_id_' => 'e1396afc-72bd-41df-8526-fdba4cfc2b69',
									'codes' => array ( 'try_market-index' ),
							),
							'修改营销活动配置' => array (
									'_id_' => 'd98dacf3-50c0-40b9-964d-a8ae7758033b',
									'codes' => array ( 'try_market-edit' ),
							),
							'取消营销活动配置' => array (
									'_id_' => '1d22f3ae-666e-4662-8259-ef5d2c6ea1b5',
									'codes' => array ( 'try_market-delete' ),
							),
							'相关操作' => array (
									'_id_' => 'dc5af83b-3a35-4654-bad0-e9ef53a013d0',
									'codes' => array ( 'try_market-get_trys','try_market-log' ),
							)
					),
			),
			'全局配置' => array (
				'_id_' => 'bc165dec-82e2-4111-9d36-c9ec93d14a10',
				'children' => array (
					'查看全局配置' => array (
						'_id_' => '12a90b73-3a57-411f-94ab-b71dc0de8d13',
						'codes' => array ( 'system-config' ),
					),
					'修改全局配置' => array (
						'_id_' => 'd84bd47b-35ad-4cc6-ab2f-85e94feae46c',
						'codes' => array ( 'system-config~edit' ),
					),
				),
			),
			'关键字过滤' => array (
				'_id_' => '8d7804e1-22ee-4da2-88a7-8bf9b53ab1b1',
				'children' => array (
					'查看过滤关键字' => array (
						'_id_' => '916d8a1d-fd74-45b5-9f69-1e941e5c62e2',
						'codes' => array ( 'system-filter' ),
					),
					'修改过滤关键字' => array (
						'_id_' => '215f3d14-5d13-48a8-a294-f6c6c0174615',
						'codes' => array ( 'system-filtersave' ),
					),
				),
			),
			'权限设置' => array (
				'_id_' => 'c40e8d78-312a-4e66-a86b-97199670699a',
				'children' => array (
					'查看管理帐号列表' => array (
						'_id_' => '346d64f8-4818-4667-828d-bd34664fb29a',
						'codes' => array ( 'privilege-index' ),
					),
					'查看管理组列表' => array (
						'_id_' => 'ce2141e6-c5ae-46c3-a000-8e032ed1d1eb',
						'codes' => array ( 'privilege-groups' ),
					),
					'编辑管理员帐号' => array (
						'_id_' => '474f33e9-cfc7-493d-8c80-f33c85199d16',
						'codes' => array ( 'privilege-edit_user' ),
					),
					'编辑管理员昵称' => array (
						'_id_' => 'e566b92f-5c91-43b4-8e96-e919f875d2bb',
						'codes' => array ( 'user-edit_nickname~admin' ),
					),
					'更改管理员密码' => array (
						'_id_' => '095bca71-7b3b-4bc8-81be-19abb066a130',
						'codes' => array ( 'user-edit_password~admin_login' ),
					),
					'删除管理员帐号' => array (
						'_id_' => '914037fb-c046-401d-9ee7-8376884905c2',
						'codes' => array ( 'user-delete~admin' ),
					),
					'新增管理员' => array (
						'_id_' => 'b0f68af5-0da1-405c-b68a-3daf43bd1654',
						'codes' => array ( 'privilege-add_user' ),
					),
					'组-新增组' => array (
						'_id_' => '534d2453-0f3c-47fd-8111-80e9fc54811d',
						'codes' => array ( 'privilege-add_group' ),
					),
					'组-编辑组' => array (
						'_id_' => '30f9446e-e63f-46fe-996e-b33728d88308',
						'codes' => array ( 'privilege-edit_group' ),
					),
					'组-设置权限' => array (
						'_id_' => '982b3694-4087-4b85-83cf-d05438f3f7c5',
						'codes' => array ( 'privilege-edit_group_actions' ),
					),
					'组-删除组' => array (
						'_id_' => 'ef4a1391-4dbb-4c13-88df-1d809383f634',
						'codes' => array ( 'privilege-delete_group' ),
					),
					'更新密保卡' => array (
						'_id_' => '18c6b9aa-8e43-4d34-9f42-decf45616725',
						'codes' => array ( 'user-create_security_card' ),
					),
					'导出密保卡' => array (
						'_id_' => '0102ed60-bec3-4dcd-af56-3f400d4d700e',
						'codes' => array ( 'user-export_security_card' ),
					),
				),
			),
			'服务配置' => array (
				'_id_' => 'b0536044-6c5c-4151-9f20-b41a2c56d28c',
				'children' => array (
					'查看服务列表' => array (
						'_id_' => 'a1f151e2-b0d2-4a7b-ad06-368b5ec1808f',
						'codes' => array ( 'service-all' ),
					),
					'更改服务配置' => array (
						'_id_' => 'cdb127a5-0d63-4232-8e24-0885dab93137',
						'codes' => array ( 'service-edit' ),
					),
					'管理服务体验名额' => array (
						'_id_' => 'd4482f9e-02ae-4172-9955-98d2866de1bc',
						'codes' => array ( 'service-applies', 'service-experience', 'service-check_apply', 'service-give_service' ),
					),
					'管理服务评价' => array (
						'_id_' => '8c169acb-f815-4602-8f35-c287aed5412e',
						'codes' => array ( 'service-is_top', 'service-hide_show', 'service-reviews' ),
					),
				),
			),
			'未上线查看配置' => array (
				'_id_' => '0f5620f8-10d6-4081-beda-4809deabc48c',
				'children' => array (
					'查看通过列表' => array (
						'_id_' => 'e70bf6c1-1c0b-47d9-848d-d091a75205d9',
						'codes' => array ( 'wall_list-index~pass' ),
					),
					'查看禁止列表' => array (
						'_id_' => 'dbbc171f-0bb3-45ba-b764-a7874a985e80',
						'codes' => array ( 'wall_list-index~stop' ),
					),
					'查看尝试列表' => array (
						'_id_' => '0c0a3297-d6d8-4631-8056-8019fa9b2053',
						'codes' => array ( 'wall_list-index~try' ),
					),
					'更新动态密码' => array (
						'_id_' => 'a719a41c-fcdf-4dc1-83f9-b32c8bb1f79e',
						'codes' => array ( 'wall_list-save_pwd' ),
					),
				),
			),
			'系统日志' => array (
				'_id_' => 'bf06b2b8-dd24-45d6-8a4d-5d3c1c5f4db6',
				'children' => array (
					'查看系统日志' => array (
						'_id_' => '3b914040-b5ff-4742-abd0-1439986ba6d7',
						'codes' => array ( 'system-log' ),
					),
				),
			),
			'管理日志' => array (
				'_id_' => 'f2c098a2-28c9-40c9-82b2-2a3a57ad32d1',
				'children' => array (
					'查看管理日志' => array (
						'_id_' => 'a9384c9e-91be-4375-92a1-16f00d8d0539',
						'codes' => array ( 'system-adminlog~view' ),
					),
					'导出xls' => array (
						'_id_' => '696a6df3-eb5e-48f1-8030-0b2a19bb38ce',
						'codes' => array ( 'system-adminlog~export' ),
					),
				),
			),
			'静态页文件' => array (
				'_id_' => '56f93f6f-7f30-4bba-8e5e-9c39c8979f05',
				'children' => array (
					'生成首页静态页' => array (
						'_id_' => 'fda63750-3083-4c59-9efa-3eb5216e45ac',
						'codes' => array ( 'system-wwwfile' ),
					),
				),
			),
			'代理商列表' => array (
				'_id_' => '1699981b-c26d-4e09-b5b6-b9ebdca8bf3d',
				'children' => array (
					'浏览代理商列表' => array (
						'_id_' => '8eb6bbe1-968f-4447-a8ef-7c7b9fc5671d',
						'codes' => array ( 'userlist-agents' ),
					),
					'添加代理商' => array (
						'_id_' => 'e376b95e-4389-4398-b4e6-0157084c630a',
						'codes' => array ( 'user-add_agent' ),
					),
					'编辑代理商' => array (
						'_id_' => '8693840b-d458-4abc-8e65-f5a0e12f2919',
						'codes' => array ( 'user-edit_agent' ),
					),
					'删除代理商' => array (
						'_id_' => '31fb0bf0-e8c1-485a-86c0-1711666957c0',
						'codes' => array ( 'user-delete~agent' ),
					),
					'变更昵称' => array (
						'_id_' => 'c5409b81-a57f-4448-b67c-c30b2dfda294',
						'codes' => array ( 'user-edit_nickname~agent' ),
					),
					'重置登录密码' => array (
						'_id_' => 'f261fb7a-88e5-40ed-8256-562bc37c2ec5',
						'codes' => array ( 'user-edit_password~agent_login' ),
					),
				),
			),
		),
	),
	'兑换券管理' => array (
		'_id_' => 'ec377336-e4a2-45f2-b5fa-39517ed8a674',
		'children' => array (
			'兑换卷系统' => array (
				'_id_' => '7233894b-fde8-435e-8645-b75f477a294b',
				'children' => array (
					'发行金币' => array (
						'_id_' => 'f38bc957-b5b8-4c14-be29-05c16137064f',
						'codes' => array ( 'coin-issue_coin' ),
					),
					'销毁金币' => array (
						'_id_' => '7afee984-2f77-4747-8b73-d331ae087b16',
						'codes' => array ( 'coin-deduction_coin' ),
					),
					'查看金币账户入口' => array (
						'_id_' => 'c3e91205-233a-4491-8d20-532f693d1d9c',
						'codes' => array ( 'coin-coin_system' ),
					),
					'金币用户转账操作' => array (
						'_id_' => '764da98b-2ccf-40a6-94de-6dbc929d313b',
						'codes' => array ( 'coin-transfer_accounts' ),
					),
					'金币参数配置' => array (
						'_id_' => 'e5511dd1-6c04-4de0-b8b5-13baa2cc2ca0',
						'codes' => array ( 'coin-config' ),
					),
					'兑换券发放' => array (
						'_id_' => '42d4730a-e59a-4efb-98cc-e3b13c69ef4b',
						'codes' => array ( 'coin-batch_grant_coin' ),
					),
				),
			),
		),
	),
	'APP管理' => array (
		'_id_' => 'ed7024c9-2988-4c56-9498-8fbf985f4957',
		'children' => array (
			'APP反馈管理' => array (
				'_id_' => 'c8440530-e081-4ea9-b45e-7612d1fba68d',
				'children' => array (
					'反馈' => array (
						'_id_' => 'fcb5be3a-faac-4a70-be63-09a59b4b3631',
						'codes' => array ( 'app-feedback' ),
					),
				),
			),
			'APP推送管理' => array (
				'_id_' => '438e3a5a-e8f8-482a-8f55-d37b653ca70e',
				'children' => array (
					'APP首页' => array (
						'_id_' => '763546cb-055d-4546-991c-053d7e296b0b',
						'codes' => array ( 'app-index' ),
					),
					'启动广告' => array (
							'_id_' => '01b35393-afe7-4d0d-b791-cb40f290e2aa',
							'codes' => array ( 'app-bootad' , 'app-bootad_save','app-del_image_text','recommend_new-image_txt-update_sort'),
					),
				),
			),
		),
	),
	'0元抽奖' => array (
		'_id_' => '9c3b2b92-0977-44c1-a770-45ada230350c',
		'children' => array (
			'抽奖次数' => array (
				'_id_' => '03347fd6-ada5-44f0-a205-d77b42457bfb',
				'children' => array (
					'抽奖次数发放' => array (
						'_id_' => '3498116a-6ee2-4c87-95d7-77f52bd033f7',
						'codes' => array ( 'lottery-gift_coin' ),
					),
				),
			),
			'活动管理' => array (
				'_id_' => 'ed9b7fe6-7a70-4a3f-a452-a34144f3940b',
				'children' => array (
					'活动管理' => array (
						'_id_' => '42b001ab-60db-4b80-b887-2969571876c1',
						'codes' => array ( 'lottery-lt_manage_list' ),
					),
					'发布活动' => array (
						'_id_' => '7a58e656-4937-444f-af72-8f37a957e17b',
						'codes' => array ( 'lottery-lottery_view' ),
					),
					'活动审核' => array (
						'_id_' => '5326ea8f-e309-4603-a917-ea57a415778e',
						'codes' => array ( 'lottery-wait_lt_list' ),
					),
					'中奖会员' => array (
						'_id_' => '6d549067-c64b-4ff1-938c-8141496f7d44',
						'codes' => array ( 'lottery-lucky_list' ),
					),
					'数据统计' => array (
						'_id_' => '5bc9e75c-9bcc-4b7c-b7ac-6a5765550490',
						'codes' => array ( 'lottery-daily' ),
					),
				),
			),
		),
	),
	'业绩认领' => array (
			'_id_' => '08ed7183-2312-41eb-a366-f319676eeac3',
			'children' => array (
				'业绩认领' => array(
					'_id_' => 'a99f98c5-0eea-43c6-b294-6446dfd1dc36',
					'children' => array(
						'查看业绩认领表' => array(
							'_id_' => '5faf553b-4c6c-4afc-abb7-32f9ead83add',
							'codes' => array('claim-index','claim-vindex'),
						),
						'查看业绩认领记录表' => array(
								'_id_' => '74cb33b0-b6c3-4b48-9d75-0637a816c6b1',
								'codes' => array('claim-lists','claim-vlists','claim-detail'),
						),
						'认领业绩' => array(
								'_id_' => 'eb7b6af2-3d6a-4ffa-8c81-86d218d87b75',
								'codes' => array('claim-confirm','claim-upload','claim-delete'),
						),
						'撤销认领' => array(
								'_id_' => 'f14e16b3-562b-4763-8413-7ac5727c0fe1',
								'codes' => array('claim-cancelled'),
						),
						'导出xls' => array(
								'_id_' => 'd814b680-23f8-40af-8d48-210e3069cd95',
								'codes' => array('claim-exportachlist','claim-vexportachlist'),
						),
						
					),
				),
			),
	),
);
