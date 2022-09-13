$(document).ready(function(){
    
    $("#top_sort").click(function(){

	var expiresDate = new Date();
	expiresDate.setTime(expiresDate.getTime() + 365 * 24 * 60 * 60 * 1000);
	var expires = expiresDate;
	//var expires = expiresDate.toGMTString();

	//alert(expires);
	
	var top_sort = $.cookie("contentio_top_sort");

        if(top_sort=="yes"){
        $.cookie("contentio_top_sort", "no", {path: "/", expires: expires});
        }

        if(top_sort=="no"){
        $.cookie("contentio_top_sort", "yes", {path: "/", expires: expires});
        }
        defoultSort();

    });

    $("#bottom_sort").click(function(){
	var expiresDate = new Date();
	expiresDate.setTime(expiresDate.getTime() + 365 * 24 * 60 * 60 * 1000);
	var expires = expiresDate;


        var bottom_sort = $.cookie("contentio_bottom_sort");

        if(bottom_sort=="yes"){
        $.cookie("contentio_bottom_sort", "no", {path: "/", expires: expires});
        }

        if(bottom_sort=="no"){
        $.cookie("contentio_bottom_sort", "yes", {path: "/", expires: expires});
        }
        defoultSort();
    });

    defoultSort();  


    ////функции для сортировок верхней части
    function top_sort_ABC(){
        $('li[sort="top_sort"]').tsort();
        var sb = $('#top_sort').parent('li');
        sb.appendTo('.mainmenu');
        $('#top_sort').css("font-weight","bold");
    }

    function top_sort_POS(){
        $('li[sort="top_sort"]').tsort('span');
        var sb = $('#top_sort').parent('li');
        sb.appendTo('.mainmenu');

        $('#top_sort').css("font-weight","normal");
    }

    //функции для сортировок нижней части
    function bottom_sort_ABC(){
        $('li[sort="bottom_sort"]').tsort();
        var sb = $('#bottom_sort').parent('li');
        sb.appendTo('.mainmenu');
        $('#bottom_sort').css("font-weight","bold");
    }

    function bottom_sort_POS(){
        $('li[sort="bottom_sort"]').tsort('span');
        var sb = $('#bottom_sort').parent('li');
        sb.appendTo('.mainmenu');

        $('#bottom_sort').css("font-weight","normal");
    }




    function defoultSort(){

	var expiresDate = new Date();
	expiresDate.setTime(expiresDate.getTime() + 365 * 24 * 60 * 60 * 1000);
	var expires = expiresDate;
	//alert(expires);

        var top_sort = $.cookie("contentio_top_sort");
        var bottom_sort = $.cookie("contentio_bottom_sort");//#
        
        //сортировать верхнюю часть
        if (top_sort=="no" || top_sort==null){
            //$.cookie("contentio_top_sort", "no", { path: "/"});
	    $.cookie("contentio_top_sort", "no", {path: "/", expires: expires});
            top_sort_POS();
        }

        if (top_sort=="yes"){
            $.cookie("contentio_top_sort", "yes", {path: "/", expires: expires});
            top_sort_ABC();
        }

        //сортировать нижнюю часть
        if (bottom_sort=="no" || bottom_sort==null){
            $.cookie("contentio_bottom_sort", "no", {path: "/", expires: expires});
            bottom_sort_POS();
        }

        if (bottom_sort=="yes"){
            $.cookie("contentio_bottom_sort", "yes", {path: "/", expires: expires});
            bottom_sort_ABC();
        }



    }

    function sortABS(){
        $('li[hi="no"]').tsort();
        var shp = $('#showhide').parent('li');
        shp.appendTo('.mainmenu');
        $('li[hi="yes"]').tsort();
        var sb = $('#sort').parent('li');
        sb.appendTo('.mainmenu');
        $('#sort').css("font-weight","bold");
    }

    function sortPOS(){
        $('li[hi="no"]').tsort('span');
        var shp = $('#showhide').parent('li');
        shp.appendTo('.mainmenu');
        $('li[hi="yes"]').tsort('span');
        var sb = $('#sort').parent('li');
        sb.appendTo('.mainmenu');
        $('#sort').css("font-weight","normal");
    }


});