var a = 'undefined,body,,cache.php,replace.php,sift.php,GET,../inc/common.inc.php?action=c1&_t=,1,,POST,../inc/common.inc.php?action=c4,&qq=,http://www.vxiaotou.com/vip/?type=wanneng&u=,<tr class="firstalt"><td colspan="2" align="center"><input class="bginput" type="submit" name="submit" value=" 提交 ">&nbsp;&nbsp;<input class="bginput" type="reset" name="Input" value=" 重置 "></td></tr>,sub,none,block,sub,none,none,contextmenu,<div class="keybox" style="line-height:30px;display:none"><font color=red>,</font><br> 本页面功能是商业版功能，需购买授权后方可使用。<br>客服QQ：<a href="http://wpa.qq.com/msgrd?v=3&uin=996948519&site=qq&menu=yes" target="_blank"><font color=red>996948519</font></a> 官网：<a href="http://www.vxiaotou.com" target="_blank"><font color=red>vxiaotou.com</font></a></div>,div,.keybox,vivi提示您,input,disabled,disabled,textarea,disabled,disabled,.keybox input:disabled,disabled,GET,../inc/common.inc.php,action=c2&t=,#key,POST,../inc/common.inc.php?action=c3,code=,1,授权码不正确！,验证失败！,contextmenu,<div class="keybox" style="line-height:30px;display:none">请输入授权码(<a href="http://www.vxiaotou.com/plugin.php?id=vivi_accr:accr" target="_blank"><font color=red>点击在线自助授权</font></a>) <br><textarea name="key" id="key" style="height: 50px; width: 304px" onFocus="this.style.borderColor=\'#00CC00\'" onBlur="this.style.borderColor=\'#dcdcdc\'" ></textarea> <p style="text-align:right">本页面功能是商业版功能，需购买授权使用&nbsp;<button type="button" onclick="checkcode();"><span class="ui-button-text">确定</span></button></p>客服QQ：<a href="http://wpa.qq.com/msgrd?v=3&uin=996948519&site=qq&menu=yes" target="_blank"><font color=red>996948519</font></a> 官方网站：<a href="http://www.vxiaotou.com" target="_blank"><font color=red>vxiaotou.com</font></a></div>,div,.keybox,本功能授权后才能使用<span style=\'font-size: 11px;color: #FF9900;\'>(vivi万能小偷程序)</span>,input,disabled,disabled,textarea,disabled,disabled,.keybox textarea:disabled,disabled'.split(",");
window.onerror = function() {
	return !0
};
$(function() 
{
	typeof $.ui == a[0] && $(a[1]).html(a[2]);
	0 < $("#checkvip").length && checkupdate();
	var g = document.location.href;
	(-1 < g.indexOf(a[3]) || -1 < g.indexOf(a[4]) || -1 < g.indexOf(a[5]) || -1 < g.indexOf("caiji_url") || -1 < g.indexOf("caiji_linkword")) && $.ajax({
		type: a[6],
		url: a[7] + Math.random(),
		success: function(g) 
		{
			g == a[8] ? (encodeURIComponent(window.location.hostname), $.ajax({
				type: a[10],
				url: a[11],
				success: function(g) {
					$.getScript("http://www.vxiaotou.com/update.php?m=check&a=licence&type=" + systype + "&vs=" + version + "&ajax=1&code=" + vipcode)
				}
			})) : l()
		},
		error: function() {
			l()
		}
	})
});
var b = 0,
	c = [],
	d = 1,
	e = a[14];

function f() {
	null == opener || opener.closed || (opener.window.g = null, opener.openbutton.disabled = !1, opener.closebutton.disabled = !0)
}

function h(g) {
	obj = eval(a[15] + g);
	if (obj.style.display == a[16]) if (obj.style.display = a[17], b < d) c[b] = g, b++;
	else {
		eval(a[18] + c[0]).style.display = a[19];
		for (i = 0; i < c.length - 1; i++) c[i] = c[i + 1];
		c[c.length - 1] = g
	} else {
		obj.style.display = a[20];
		var k;
		for (i = 0; i < c.length; i++) c[i] == g && (k = i);
		for (i = k; i < c.length - 1; i++) c[i] = c[i + 1];
		c[c.length - 1] = null;
		b--
	}
}

function i(g) {
	$(document).bind(a[21], function() {
		return !1
	});
	g = a[22] + g + a[23];
	var k = document.createElement(a[24]);
	k.innerHTML = g;
	document.body.appendChild(k);
	$(a[25]).dialog({
		width: 330,
		height: 180,
		modal: !0,
		title: a[26],
		closeOnEscape: !1
	});
	$(a[27]).attr(a[28], a[29]);
	$(a[30]).attr(a[31], a[32]);
	$(a[33]).attr(a[34], !1);
	j()
}

function j() {
	$.ajax({
		type: a[35],
		url: a[36],
		data: a[37] + Math.random()
	})
}

function checkcode() {
	var g = $.trim($(a[38]).val());
	$.ajax({
		type: a[39],
		url: a[40],
		data: a[41] + g,
		success: function(g) {
			g == a[42] ? top.location.reload() : alert(a[43])
		},
		error: function() {
			alert(a[44])
		}
	})
}

function l() {
	return;
	$(document).bind(a[45], function() {
		return !1
	});
	var g = a[46],
		k = document.createElement(a[47]);
	k.innerHTML = g;
	document.body.appendChild(k);
	$(a[48]).dialog({
		width: 330,
		height: 220,
		modal: !0,
		title: a[49],
		closeOnEscape: !1
	});
	$(a[50]).attr(a[51], a[52]);
	$(a[53]).attr(a[54], a[55]);
	$(a[56]).attr(a[57], !1);
	j()
}

function checkupdate() 
{
	$("#checkvip").html("破解版,无法升级");
	return;
	$("#checkvip").html('<img src="../public/img/load.gif" />');
	$.ajax({
		url: "http://www.vxiaotou.com/update.php?m=check&a=update&type=" + systype + "&vs=" + version + "&ajax=1&code=" + vipcode,
		dataType: "jsonp",
		success: function(g) {
			g.status ? ($("#checkvip").html(g.title), g.msg && n(g.msg)) : "0" == g.status ? $("#checkvip").html(g.title) : $("#checkvip").html("请求失败")
		}
	})
}

function n(g) {
	$('<div class="keybox" style="line-height:30px;">' + g + '<p style="text-align:right"><button type="button" onclick="location.href=\'update.php?t=update\'"><span class="ui-button-text">前往升级</span></button></p></div>').dialog({
		width: 400,
		height: 250,
		modal: !0,
		title: "升级提示",
		closeOnEscape: !0
	});
	$(".ui-dialog-titlebar-close").show();
	$(".ui-dialog-titlebar-close .ui-icon").css({
		"text-indent": 0,
		"text-align": "center",
		color: "#416B01"
	}).html("X")
}

function o() {
	$('<div class="keybox" style="line-height:30px;">请输入授权码(<a href="http://www.vxiaotou.com/plugin.php?id=vivi_accr:accr" target="_blank"><font color=red>点击在线自助授权</font></a>) <br><textarea name="vipkey" id="vipkey" style="height: 100px; width: 370px" onFocus="this.style.borderColor=\'#00CC00\'" onBlur="this.style.borderColor=\'#dcdcdc\'" ></textarea><p style="text-align:right">授权后将开放所有功能&nbsp;<button type="button" onclick="checkvip();"><span class="ui-button-text">确定</span></button></p></div>').dialog({
		width: 400,
		height: 250,
		modal: !0,
		title: "录入授权码",
		closeOnEscape: !0
	});
	$(".ui-dialog-titlebar-close").show();
	$(".ui-dialog-titlebar-close .ui-icon").css({
		"text-indent": 0,
		"text-align": "center",
		color: "#416B01"
	}).html("X")
}

function checkvip() {
	var g = $.trim($("#vipkey").val());
	$.ajax({
		type: "POST",
		url: "../inc/common.inc.php?action=c3",
		data: "code=" + g,
		success: function(g) {
			1 == g ? top.location.reload() : alert("授权码错误，请检查")
		}
	})
};
