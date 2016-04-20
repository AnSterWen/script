/**
 * 加载右边页面请求
 */
function loadMainRight(req)
{
	$('#main_right').empty().append('<div id="loading"><img src="html/images/loading.gif" />&nbsp;&nbsp;正在加载数据，请耐心等待......</div>');
	$.ajax({
		type:"get",
		url:req,
		dataType:"text",
		data:'ajax=ajax',
		success:function(mainRight){
			if (mainRight == "time out!")
			{
				window.location.replace(req);
			}
			else
			{
				$('#main_right').empty().append(mainRight);
			}
		}
	});
	
	var lastHightLight = document.getElementById('last_highlight').value;//上一次左边高亮的链接所对应的请求地址
	var lastLeftA = document.getElementById(lastHightLight);//上一次左边高亮的a标签对象
	var currenttLeftA = document.getElementById(req);//本次请求对应的左边a标签对象
	if(lastLeftA){
		lastLeftA.style.color 	  = '#666';//将上一次左边高亮的a标签对象的颜色设置为暗淡
	}
	currenttLeftA.style.color = '#390';//将本次请求对应的a标签对象的颜色设置为高亮
	document.getElementById('last_highlight').value = req;
}

/**
 * 右边li的显示与隐藏
 */
function showList(key)
{
	var nodeObj  = document.getElementById('li_title_'+key);
	var childObj = document.getElementById('li_child_'+key);
	var imgObj   = document.getElementById('li_img_'+key);
	if(childObj.style.display == '')
	{
		childObj.style.display = 'none';
		nodeObj.style.background = 'url(html/images/bg_tree_menu2.gif)';
	}
	else
	{
		childObj.style.display = '';
		nodeObj.style.background = 'url(html/images/bg_tree_menu2.gif) no-repeat scroll left -28px';
	}
}

/**
 * 添加/修改商品onsubmit(mole&seer)
 * type   1: 添加   2：修改
 */
function itemSubmit(flag,type)
{

	var itemName      = $('#item_name').val();		//商品名称
	var itemGid       = $('#item_game_id').val();	//游戏中ID
	var itemPrice     = $('#item_price').val();		//商品全价
	var userDiscount  = $('#user_discount').val();	//普通折扣
	var start   = $('#start').val();	//总库存
	var end = $('#end').val();	//当前库存
	var ifEffective   = $('#if_effective').val();	//商品是否有效
    var product_attr = $('#product_attr').val();
    var add_times = $('#add_times').val();


    var text = "请确认您的商品信息：\n\n";
    text += "商品名称： "+itemName+"\n游戏中物品ID： "+itemGid+"\n游戏中物品数量： "+$('#item_count').val()+"\n" +
        "赠送物品数量： "+$('#item_gift').val()+"\n商品全价： "+itemPrice+"\n折扣： "+userDiscount+"\n" +
        "活动起始时间： "+start+"\n活动结束时间： "+end+"\n";
    text += "目录ID： "+$('#item_category').val()+"\n属性： "+$('#product_attr').val()+"\n倍数： " + $('#product_attr').val() +
        "\n扩展字段： "+$('#extend_data').html()+"\n第三方平台别名： "+$('#product_third_name').val()+"\n版本号： "+$('#client_version').val();
    if(!confirm(text)){
        return false;
    }

	if(itemName == ''|| itemPrice == ''|| userDiscount == ''|| totalStocks == ''||currentStocks == '' || itemGid == '')
	{
		alert("提交信息不全!");
		return false;
	}
	
	if($('input[@name=if_effective]').get(0).checked!=true&&$('input[@name=if_effective]').get(1).checked!=true&&$('input[@name=if_effective]').get(2).checked!=true)
	{
		alert("请选择商品是否有效!");
		return false;
	}
	
	if(itemName.split(',').length != 1 && !checkPname(itemName, flag))
	{
		alert("该名称存在!并且组合商品名称中不能含有英文逗号");
		return false;
	}

	var tmp = itemGid.split(',');
	for(var i=0;i<tmp.length;i++)
	{
		if(!strTypeCheck(tmp[i],'game_id'))
		{
			alert("游戏ID输入不正确:", tmp[i]);
			return false;
		}
	}

	//对其他字段的输入进行判断
	if(!strTypeCheck(itemPrice,'number'))
	{
		alert("商品全价应为整数!");
		return false;
	}
	
	if(!strTypeCheck(userDiscount,'number') || userDiscount > 100)
	{
		alert("会员折扣应在0-100之间!");
		return false;
	}

    if(!strTypeCheck(product_attr,'number'))
    {
        alert("属性应为数字!");
        return false;
    }

    if(!strTypeCheck(add_times,'number'))
    {
        alert("倍率应为数字!");
        return false;
    }
	
	if((start != '' && !strTypeCheck(start,'date')) || (end != '' && !strTypeCheck(end, 'date')))
	{
		alert("活动时间配置错误，请看说明");
		return false;
	}

	return true;
}


/**
 * 添加/修改商品onsubmit(mole&seer)
 * type   1: 添加   2：修改
 */
function agentSubmit(flag,type)
{
	var itemName      = $('#item_name').val();		//商品名称
	var itemPrice     = $('#item_price').val();		//商品全价
	
	if(itemName == ''|| itemPrice == '')
	{
		alert("提交信息不全!");
		return false;
	}
	
	if(itemName.split(',').length != 1 && !checkPname(itemName, flag))
	{
		alert("该名称存在!并且组合商品名称中不能含有英文逗号");
		return false;
	}

	//对其他字段的输入进行判断
	if(!strTypeCheck(itemPrice,'number'))
	{
		alert("商品全价应为整数!");
		return false;
	}
	
	

	return true;
}


/**
 * 异步请求 判断商品名称是否存在
 * @return true:存在 false:不存在
 */
function checkPname(name, flag)
{
	var res = 0;
	$.ajax({
		async: false,
		url :'index.php', 
		type:'get',
		data:'ajax=ajax&m=common&a=checkproductname&product_name='+name+'&flag='+flag+'05',
		success:function(rs)
				{
					if(rs.result != 0)
						res = 0;
					else
						res = 2;
				},
		dataType:'json'
	}) ;
	return res;
}

/**
 * 字符串类型验证
 */
function strTypeCheck(str, type)
{
	var regGameId   = /^(?:[\d]+|[\d]+\([\d]+\))$/; //纯数字或者 数字（数字）
	var regNum      = /^[\d]+$/;	// 数字
	var regDate     = /^[\d]{4}-[\d]{2}-[\d]{2} [\d]{2}:[\d]{2}$/;	// 数字
	var regLetter   = /^[a-zA-Z]+$/;	// 纯字母
	var regUserName = /^[_a-zA-Z][\w\_]*$/;	// 用户名
	var regChinese  = /^[\u4e00-\u9fa5]+$/;	// 中文
	var regPostCode = /^[1-9][\d]{5}$/;	// 邮政编码
	var regPhone    = /^([\d]{3,4}[\-|\*])[\d]{7,8}([\-|\*][\d]{3,5})?$/;	// 电话号码（带区号）
	var regMobile   = /^[1][\d]{10}$/;	// 手机号码
	var regEmail    = /^[a-zA-Z_]+[-+.\w]*@[a-zA-Z_]+[-+.\w]*\.\w+[-+.\w]*$/;	// email 地址
	var regASCII    = /^[\u0021-\u007f]$/; // 可以打印的 ASCII 字符
	var regPwd      = /^([a-zA-Z]+|[0-9]+)$/; // 密码, 不支持仅包含数字或字母的字符串
	var regInt 		= /^[1-9][\d]*$/; // 整数
	var regDecimal  = /(^[1](\.[0]{0,2}){0,1}$)|(^[0]\.(([\d]{0,1}[1-9])|([1-9][\d]{0,1}))$)/; //两位小数
	type = type.toLowerCase() ;

	switch(type)
	{
		case 'game_id':
			return regGameId.test(str);
		case 'user_name':
			return regUserName.test(str);
		case 'password':
			return !regPwd.test(str);
		case 'chinese':
			return regChinese.test(str);
		case 'phone':
			return regPhone.test(str);
		case 'mobile':
			return regMobile.test(str);
		case 'email':
			return regEmail.test(str);
		case 'number':
			return regNum.test(str);
		case 'ascii':
			return regASCII.test(str);
		case 'post_code':
			return regPostCode.test(str);
		case 'int':
			return regInt.test(str);
		case 'decimal':
			return regDecimal.test(str);
		case 'date':
			return regDate.test(str);
		default:
			break ;
	}
	return false ;
}
