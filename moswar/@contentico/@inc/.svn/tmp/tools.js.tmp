// обработчики для Ctrl+S, F1
$(window).load(function()
{
    var eventName = $.browser.msie ? "keydown" : "keypress";
    var sKey = $.browser.msie || $.browser.opera ? 83 : 115;
    $(document).bind(eventName, function(event)
    {
        event = event || window.event;
        key = event.keyCode || event.which;
        if (event.ctrlKey && key == sKey) // Ctrl+S
        {
            if (event.preventDefault)
            {
                event.preventDefault();
            }
            event.cancelBubble = true;
            event.returnValue = false;
            GoApply();
            window.focus();
            return false;
        }
        /*
        if (key == 112) // F1
        {
            if (event.preventDefault)
            {
                event.preventDefault();
            }
            event.cancelBubble = true;
            event.returnValue = false;
            event.keyCode = 0;
            // ...
            return false;
        }
        */
    });
});

//------------------------------------------------------------------------------
// Список и чеббоксы
//------------------------------------------------------------------------------

var selectall_checkbox, checkboxes; // первая и остальные галки
var ContenticoSelectedItems = []; // выделенные галочки
var ContenticoListActions = [
    {"id":"action-edit", "count":1},
    {"id":"action-view", "count":1},
    {"id":"action-copy", "count":1},
    {"id":"action-delete", "count":2},
    {"id":"action-up", "count":1},
    {"id":"action-down", "count":1}
];

//
$(document).ready(function()
{
	selectall_checkbox = $('table.listtable th.box input[type=checkbox]')
	checkboxes = $('table.listtable td.box input[type=checkbox]');
	checkboxes.click(function()
	{
		SelectOne(this);
	});
	selectall_checkbox.click(function()
	{
		SelectAll(this);
	});
	// выделить, если галка стоит
	checkboxes.each(function()
	{
		if(this.checked) SelectOne(this);
	});
    TestSelected();
});

// выделить все галки
function SelectAll(checkbox)
{
	if(checkbox.checked)
	{
		checkboxes.each(function()
		{
			if (!this.checked)
			{
				this.checked = true;
				SelectOne(this);
			}
		});
	}
	else
	{
		checkboxes.each(function()
		{
			this.checked = false;
			SelectOne(this);
		});
	}
}

// выделить одну галку
function SelectOne(checkbox)
{
	var line = $(checkbox).parents('tr:first');
	if(checkbox.checked)
	{
		line.addClass('selected');
		ContenticoSelectedItems.push(checkbox);
		TestSelected();
	}
	else
	{
		line.removeClass('selected');
		// удалить галку из массива ContenticoSelectedItems
		var new_ContenticoSelectedItems = [];
		for(var i=0, j=ContenticoSelectedItems.length; i<j; i++)
		{
			if(ContenticoSelectedItems[i] != checkbox)
			{
				new_ContenticoSelectedItems.push(ContenticoSelectedItems[i]);
			}
		}
		ContenticoSelectedItems = new_ContenticoSelectedItems;
		new_ContenticoSelectedItems = null;
		TestSelected();
	}
}

function TestSelected()
{
	// если выделены все - ставить галочку сверху
	if(ContenticoSelectedItems.length == checkboxes.length && checkboxes.length > 0)
	{
		selectall_checkbox.attr('checked' , true);
	}
	else
	{
		selectall_checkbox.attr('checked' , false);
	}
	// если выделено несколько - спрятать кнопки Edit и View и Copy
	if(ContenticoSelectedItems.length > 1)
	{
	    for (i = 0; i < ContenticoListActions.length; i++)
	    {
            if (ContenticoListActions[i].count == 1)
            {
                $('#' + ContenticoListActions[i].id).addClass('disabled');
            }
            else
            {
                $('#' + ContenticoListActions[i].id).removeClass('disabled');
            }
	    }
	}
	else // выделена 1 строка
	{
		for (i = 0; i < ContenticoListActions.length; i++)
	    {
            if (ContenticoListActions[i].count >= 1)
            {
                $('#' + ContenticoListActions[i].id).removeClass('disabled');
            }
	    }
	}
	// если ничего не выделено
	if(ContenticoSelectedItems.length == 0)
	{
		for (i = 0; i < ContenticoListActions.length; i++)
	    {
            if (ContenticoListActions[i].count >= 1)
            {
                $('#' + ContenticoListActions[i].id).addClass('disabled');
            }
	    }
	}
}

// редактирование/просмотр
function GoViewEdit(metaobject, action, page, view)
{
    if (ContenticoSelectedItems.length == 1)
    {
        document.location.href = '/@contentico/Metaobjects/' + metaobject + '/action=' + action + '/id=' + ContenticoSelectedItems[0].id + '/-page=' + page + '/-view=' + view + '/';
    }
}
// копирование
function GoViewCopy(metaobject, action, page, view)
{
    if (ContenticoSelectedItems.length == 1)
    {
        document.location.href = '/@contentico/Metaobjects/' + metaobject + '/action=' + action + '/id=' + ContenticoSelectedItems[0].id + '/-page=' + page + '/-view=' + view + '/';
    }
}

// удаление
function GoDelete(metaobject, action, page, view)
{
    if (window.confirm("Подтвердите удаление."))
    {
        ShowLoading();
        for (i = 0; i < ContenticoSelectedItems.length; i++)
        {
            $.ajax({url: "/@contentico/Metaobjects/" + metaobject + "/action=" + action + "/id=" + ContenticoSelectedItems[i].id + "/ajax/", async: false});
        }
        HideLoading();
        document.location.href = '/@contentico/Metaobjects/' + metaobject + '/page=' + page + '/view=' + view + '/';
    }
}

// экспорт
function listActionExport(metaobject, action, type, page, view)
{
    ShowLoading();
    var id = "";
    if (type == 2) {
        for (i = 0; i < ContenticoSelectedItems.length; i++) {
            id += ContenticoSelectedItems[i].id + ",";
        }
    }
    if (metaobject=='page'){
        HideLoading();
        
        window.location.replace("/@contentico/Pages/" + "action=" + action + "/action-param=" + type + "|" + id + "/");
        //document.location.href("/@contentico/Pages/" + "action=" + action + "/action-param=" + type + "|" + id + "/");
        
    }
    else
    {
        HideLoading();
        document.location.href = "/@contentico/Metaobjects/" + metaobject + "/action=" + action + "/action-param=" + type + "|" + id + "/page=" + page + "/view=" + view + "/rnd=" + Math.random() + "/";
    }
}

// обработка Ctrl+S на формах
function GoApply()
{
    if ($('#object-form')[0])
    {
        $('#object-form')[0].action = $('#object-form')[0].action + 'apply/';
        $('#object-form').submit();
    }
}

function GoCopy()
{
    
    if ($('#object-form')[0])
    {
        $('#object-form')[0].action = $('#object-form')[0].action + 'copy/';
        $('#object-form').submit();
    }
}

//------------------------------------------------------------------------------
// Константы
//------------------------------------------------------------------------------

var ACTION_LIST = 1;
var ACTION_VIEW = 2;
var ACTION_CREATE = 3;
var ACTION_EDIT = 4;
var ACTION_DELETE = 5;
var ACTION_EXPORT = 6;
var ACTION_IMPORT = 7;
var ACTION_CUSTOM = 9;

//------------------------------------------------------------------------------
// Модуль Pages
//------------------------------------------------------------------------------

function GoEditPage()
{
    if (ContenticoSelectedItems.length == 1)
    {
        document.location.href = "/@contentico/Pages/action=" + ACTION_EDIT + "/id=" + ContenticoSelectedItems[0].id + "/";
    }
}

function GoDeletePage()
{
    if (window.confirm("Подтвердите удаление."))
    {
        ShowLoading();
        for (i = 0; i < ContenticoSelectedItems.length; i++)
        {
            $.ajax({url: "/@contentico/Pages/action=" + ACTION_DELETE + "/id=" + ContenticoSelectedItems[i].id + "/", async: false});
        }
        document.location.href = "/@contentico/Pages/";
    }
}

//------------------------------------------------------------------------------
// Модуль Users
//------------------------------------------------------------------------------

var TYPE_USERS = 1;
var TYPE_GROUPS = 2;
var TYPE_SECURITY = 3;

// редирект на редактирование пользователя
function ContenticoUsersGoEditUser()
{
    if (ContenticoSelectedItems.length == 1)
    {
        document.location.href = "/@contentico/Users/type=" + TYPE_USERS + "/action=" + ACTION_EDIT + "/id=" + ContenticoSelectedItems[0].id + "/";
    }
}

// удаление пользователей
function ContenticoUsersGoDeleteUser()
{
    if (window.confirm("Подтвердите удаление."))
    {
        for (i = 0; i < ContenticoSelectedItems.length; i++)
        {
            $.ajax({url: "/@contentico/Users/type=" + TYPE_USERS + "/action=" + ACTION_DELETE + "/id=" + ContenticoSelectedItems[i].id + "/", async: false});
        }
        document.location.href = "/@contentico/Users/type=" + TYPE_GROUPS + "/action=" + ACTION_LIST + "/";
    }
}

// редирект на редактирование со списка
function ContenticoUsersGoEditSecurity(CurPage)
{
    if (ContenticoSelectedItems.length == 1)
    {
        document.location.href = "/@contentico/Users/type=" + TYPE_SECURITY + "/action=" + ACTION_EDIT + "/-page=" + CurPage + "/id=" + ContenticoSelectedItems[0].id + "/";
    }
}

// удаление в списке
function ContenticoUsersGoDeleteSecurity(CurPage)
{
    if (window.confirm("Подтвердите удаление."))
    {
        ShowLoading();
        for (i = 0; i < ContenticoSelectedItems.length; i++)
        {
            $.ajax({url: "/@contentico/Users/type=" + TYPE_SECURITY + "/action=" + ACTION_DELETE + "/id=" + ContenticoSelectedItems[i].id + "/", async: false});
        }
        HideLoading();
        document.location.href = "/@contentico/Users/type=" + TYPE_SECURITY + "/action=" + ACTION_LIST + "/page=" + CurPage + "/";
    }
}

// перезагрузка select'ов в форме
function ContenticoUsersReloadFields()
{
    if (action == ACTION_CREATE)
    {
        if ($("#metaobject_select")[0].options.length == 0)
        {
            for (var i = 0; i < Metaobjects.length; i++)
            {
                var Option = document.createElement("OPTION");
                Option.value = i;
                Option.innerHTML = Metaobjects[i].name;
                $("#metaobject_select")[0].options.add(Option);
            }
        }
        var i = $("#metaobject_select")[0].selectedIndex;
        $("#metaobject_id")[0].value = Metaobjects[i].id;
        $("#metaobject_type")[0].value = Metaobjects[i].type;
        if (Metaobjects[i].rights == "access")
        {
            $("#right-read-label")[0].innerHTML = 'Доступ разрешен';
            $("#right-write").hide();
            $("#right-write-label").hide();
            $("#right-delete").hide();
            $("#right-delete-label").hide();
        }
        else
        {
            $("#right-read-label")[0].innerHTML = 'Просмотр';
            $("#right-write").show();
            $("#right-write-label").show();
            $("#right-delete").show();
            $("#right-delete-label").show();
        }
        if (Metaobjects[i].type == 1)
        {
            $("#metaviews-tr").hide();
            $("#objects-tr").hide();
            $("#mvormo-tr").hide();
        }
        else
        {
            $("#mvormo-tr").show();
            if ($("#target2_1")[0].checked) // операции
            {
                $("#metaviews-tr").hide();
                if ($.browser.msie)
                {
                    $("#objects-tr").show();
                }
                else
                {
                    $("#objects-tr")[0].style.display = "table-row";
                }
                var objects = $.ajax({url: "/@contentico/Users/action=101/id=" + Metaobjects[i].id + "/", async: false}).responseText;
                $("#objects")[0].innerHTML = '<select name="object_id[]" size="5" multiple="multiple" class="wide"><option value="0" selected="selected">все</option>' + objects + "</select>";
            }
            else // доступ к метапредставлению
            {
                $("#right-read-label")[0].innerHTML = 'Доступ разрешен';
                $("#right-write").hide();
                $("#right-write-label").hide();
                $("#right-delete").hide();
                $("#right-delete-label").hide();
                $("#objects-tr").hide();
                if ($.browser.msie)
                {
                    $("#metaviews-tr").show();
                }
                else
                {
                    $("#metaviews-tr")[0].style.display = "table-row";
                }
                var metaviews = $.ajax({url: "/@contentico/Users/action=102/id=" + Metaobjects[i].id + "/", async: false}).responseText;
                $("#metaviews")[0].innerHTML = '<select name="metaview_id[]" size="5" multiple="multiple" class="wide"><option value="0" selected="selected">все</option>' + metaviews + "</select>";
            }
        }
    }
    else
    {
        $("#metaobject_select").hide();
        $("#form-create-fields").hide();
        if (isSysModule)
        {
            $("#right-write").hide();
            $("#right-write-label").hide();
            $("#right-delete").hide();
            $("#right-delete-label").hide();
            $("#right-read-label")[0].innerHTML = 'Доступ разрешен';
            $("#metaviews-tr").hide();
            $("#objects-tr").hide();
            $("#mvormo-tr").hide();
        }
        else
        {
            if (isMo)
            {
                $("#right-read-label")[0].innerHTML = 'Просмотр';
                $("#right-write").show();
                $("#right-write-label").show();
                $("#right-delete").show();
                $("#right-delete-label").show();
                $("#metaviews-tr").hide();
            }
            else
            {
                $("#right-read-label")[0].innerHTML = 'Доступ разрешен';
                $("#right-write").hide();
                $("#right-write-label").hide();
                $("#right-delete").hide();
                $("#right-delete-label").hide();
                $("#objects-tr").hide();
            }
        }
    }
}

//------------------------------------------------------------------------------
// Модуль Files
//------------------------------------------------------------------------------

// редирект на редактирование файла
function ContenticoFilesGoEditFile()
{
    if (ContenticoSelectedItems.length == 1)
    {
        document.location.href = "/@contentico/Files/action=" + ACTION_EDIT + "/id=" + ContenticoSelectedItems[0].id + "/";
    }
}

// удаление файлов
function ContenticoFilesGoDeleteFile()
{
    if (window.confirm("Подтвердите удаление."))
    {
        for (i = 0; i < ContenticoSelectedItems.length; i++)
        {
            $.ajax({url: "/@contentico/Files/action=" + ACTION_DELETE + "/id=" + ContenticoSelectedItems[i].id + "/", async: false});
        }
        document.location.href = "/@contentico/Files/action=" + ACTION_LIST + "/";
    }
}

//------------------------------------------------------------------------------
// UI
//------------------------------------------------------------------------------

var UISelectSearchItems = [];

// поиск варианта для очень больших селектов
function ContenticoMetaobjectsUISelectSearch(MetaObject, MetaAttribute, id)
{
    if (!$("#UISelectSearchDiv").length)
    {
        $('<div id="UISelectSearchDiv" title="Результаты поиска"></div>').appendTo(document.body);
    }
    eval("UISelectSearchItems=" + $.ajax({url: "/@contentico/Metaobjects/" + MetaObject + "/action=201/metaattribute=" + MetaAttribute + "/id=" + $("#" + id + "-id")[0].value + "/name=" + $("#" + id + "-name")[0].value + "/", async: false}).responseText);
    if (UISelectSearchItems[0].status == 1)
    {
        var Variants = '';
        if (UISelectSearchItems.length == 2)
        {
            Variants += '<input type="radio" name="UISelectSearchVariant" checked="checked" id="UISelectSearchVariant-1" value="1" onclick="ContenticoMetaobjectsUISelectSearchSet(\'' + id + '\', this.value);" />' +
                    '<label for="UISelectSearchVariant-1">' + UISelectSearchItems[1].name + '</label><br />';
        }
        else
        {
            for (var i = 1; i < UISelectSearchItems.length; i++)
            {
                Variants += '<input type="radio" name="UISelectSearchVariant" ' + (i == 1 ? 'checked="checked"' : '') + ' id="UISelectSearchVariant-' + i + '" value="' + i + '" onclick="ContenticoMetaobjectsUISelectSearchSet(\'' + id + '\', this.value);" />' +
                    '<label for="UISelectSearchVariant-' + i + '">' + UISelectSearchItems[i].name + '</label><br />';
            }
        }
        $("#UISelectSearchDiv")[0].innerHTML = Variants;
        ContenticoMetaobjectsUISelectSearchSet(id, 1);
        var Height = UISelectSearchItems.length * 15 + 100;
        $("#UISelectSearchDiv").dialog({buttons:{"Выбрать":jQueryDialogClose}, height:Height, modal:true});
    }
    else
    {
        var Error = "";
        if (UISelectSearchItems[0].error == 1)
        {
            Error = "Ничего не найдено.";
        }
        else if (UISelectSearchItems[0].error == 2)
        {
            Error = "Для поиска по значению необходимо ввести минимум 3 символа.";
        }
        else if (UISelectSearchItems[0].error == 3)
        {
            Error = "Поиск вернул слишком много вариантов. Уточните запрос.";
        }
        $("#UISelectSearchDiv")[0].innerHTML = Error;
        $("#UISelectSearchDiv").dialog({buttons:{"Закрыть":jQueryDialogClose}, modal:true, height:120});
    }
}

function ContenticoMetaobjectsUISelectSearchSet(id, SelectedVariant)
{
    $("#" + id)[0].value = UISelectSearchItems[SelectedVariant].id;
    $("#" + id + "-id")[0].value = UISelectSearchItems[SelectedVariant].id;
    $("#" + id + "-name")[0].value = UISelectSearchItems[SelectedVariant].name;
    $("#" + id + "-label")[0].innerHTML = UISelectSearchItems[SelectedVariant].name;
}

//------------------------------------------------------------------------------
//
//------------------------------------------------------------------------------

// показать окно справки
function ShowContextHelp(context)
{
    if (!$("#HelpDiv").length)
    {
        $('<div id="HelpDiv" title="Справка"></div>').appendTo(document.body);
    }
    context = context.split("-");
    var Help = $.ajax({url: "/@contentico/@doc/context-" + context[0] + ".html", async: false}).responseText;
    $("#HelpDiv")[0].innerHTML = '<div class="help-context">' + Help + '</div>' +
        '<div class="help-docs"><div class="line"></div>' +
        '<img src="/@contentico/@img/ico/word.gif" align="absmiddle" /> <a href="/@contentico/@doc/user-manual.doc">Руководство пользователя</a> &nbsp; &nbsp; &nbsp; &nbsp;' +
        '<img src="/@contentico/@img/ico/word.gif" align="absmiddle" /> <a href="/@contentico/@doc/administrator-manual.doc">Руководство администратора</a> &nbsp; &nbsp; &nbsp; &nbsp;' +
        '<img src="/@contentico/@img/ico/word.gif" align="absmiddle" /> <a href="/@contentico/@doc/developer-manual.doc">Руководство разработчика</a>' +
        '</div>';
    $("#HelpDiv").dialog({modal:true, height:500, width:700});
}

// показать "-X- Загрузка..."
function ShowLoading()
{
    $("#general-tip").show();
}

// скрыть "-X- Загрузка..."
function HideLoading()
{
    $("#general-tip").hide();
}

//------------------------------------------------------------------------------
//
//------------------------------------------------------------------------------

// показать окно справки
function showImportXmlWindow(page)
{

    if (page==true)
    {
    var hiden = '<input type="hidden" name="page">';
    }
    else
    {
    var hiden = '';
    }

if (!$("#importXmlWindow").length)
    {
        $('<div id="importXmlWindow" title="Импорт данных из XML"></div>').appendTo(document.body);
    }
    $("#importXmlWindow")[0].innerHTML = '<form action="/@contentico/ImportXml/" method="post" enctype="multipart/form-data">' +
        '<p>XML файл: <input type="file" name="xml" /></p>' +
        '<p><input type="checkbox" name="overwrite" id="overwrite" /><label for="overwrite">Заменять при совпадении ID</label></p>' +
        '<p><input type="submit" value="Импортировать" /></p>'+hiden+
        '</form>';
    $("#importXmlWindow").dialog({modal:true, height:200, width:400});
}

function uiTextboxDateTimeToTimestamp(id)
{
    var dt = $("#" + id).val();
    if (dt.indexOf("-") != -1) {
        dt = dt.split(" ");
        var d = dt[0].split("-");
        var t = [0, 0, 0];
        if (dt.length == 2 && dt[1] != "") {
            t = dt[1].split(":");
        }
        var d = new Date(parseInt(d[0]), (parseInt(d[1]) - 1), parseInt(d[2]), parseInt(t[0]), parseInt(t[1]), parseInt(t[2]), 0);
        $("#" + id).val(d.getTime()/1000.0);
    } else {
        var ts = new Date();
        ts.setTime(dt * 1000);
        m = ts.getMonth() + 1;
        if (m < 10) {m = "0" + m;}
        d = ts.getDate();
        if (d < 10) {d = "0" + d;}
        h = ts.getHours();
        if (h < 10) {h = "0" + h;}
        mn = ts.getMinutes();
        if (mn < 10) {mn = "0" + mn;}
        s = ts.getSeconds();
        if (s < 10) {s = "0" + s;}
        $("#" + id).val(ts.getFullYear() + "-" + m + "-" + d + " " + h + ":" + mn + ":" + s);
    }
}