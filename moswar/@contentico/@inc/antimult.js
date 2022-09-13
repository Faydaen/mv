$(document).ready(function()
{



    var buttonsHoney = $(".honeyChBx");
    var buttonsLost = $(".lostChBx");
    var buttonsKorm = $(".kormChBx");
    var buttonsInfidel = $(".InfidelChBx");

    $("#allHon").click(function()
    {
	var countChbxHoney = buttonsHoney.length;
	var k = 0;
	if (countChbxHoney>0)//если под кнопкой всё есть хоть один чекбокс
	{
	    for(i=0;i<=countChbxHoney;i++)
	    {

		if(buttonsHoney.eq(i).attr('checked') == '')
		{
		    k++;
		    buttonsHoney.eq(i).attr('checked', 'checked');
		}
	    }

	    if (k==0)
	    {
	    	for(i=0;i<=countChbxHoney;i++)
		{
		buttonsHoney.eq(i).attr('checked', '');
		}
		$("#allHon").attr('checked', '');
	    }
	}
    });

    $("#allLos").click(function()
    {
	var countChbxLost = buttonsLost.length;
	var k = 0;
	if (countChbxLost>0)//если под кнопкой всё есть хоть один чекбокс
	{
	    for(i=0;i<=countChbxLost;i++)
	    {

		if(buttonsLost.eq(i).attr('checked') == '')
		{
		    k++;
		    buttonsLost.eq(i).attr('checked', 'checked');
		}
	    }

	    if (k==0)
	    {
	    	for(i=0;i<=countChbxLost;i++)
		{
		buttonsLost.eq(i).attr('checked', '');
		}
		$("#allLos").attr('checked', '');
	    }
	}
    });

    $("#allKor").click(function()
    {
	var countChbxKorm = buttonsKorm.length;
	var k = 0;
	if (countChbxKorm>0)//если под кнопкой всё есть хоть один чекбокс
	{
	    for(i=0;i<=countChbxKorm;i++)
	    {

		if(buttonsKorm.eq(i).attr('checked') == '')
		{
		    k++;
		    buttonsKorm.eq(i).attr('checked', 'checked');
		}
	    }
	    
	    if (k==0)
	    {
	    	for(i=0;i<=countChbxKorm;i++)
		{
		buttonsKorm.eq(i).attr('checked', '');
		}
		$("#allKor").attr('checked', '');
	    }
	}
    });

    $("#allInf").click(function()
    {
	var countChbxInfidel = buttonsInfidel.length;
	var k = 0;
	if (countChbxInfidel>0)//если под кнопкой всё есть хоть один чекбокс
	{
	    for(i=0;i<=countChbxInfidel;i++)
	    {

		if(buttonsInfidel.eq(i).attr('checked') == '')
		{
		    k++;
		    buttonsInfidel.eq(i).attr('checked', 'checked');
		}
	    }

	    if (k==0)
	    {
	    	for(i=0;i<=countChbxInfidel;i++)
		{
		buttonsInfidel.eq(i).attr('checked', '');
		}
		$("#allInf").attr('checked', '');
	    }
	}
    });


    $(".honeyChBx").click(function(){
	HoneyTest();
    });

    $(".kormChBx").click(function(){
	kormTest();
    });

    $(".lostChBx").click(function(){
	LostTest();
    });

    $(".InfidelChBx").click(function(){
	InfidelTest();
    });


    function HoneyTest()
    {
	var checkedLen = $(".honeyChBx:checked").length;
	var Len = $(".honeyChBx").length;
	if (Len == checkedLen && Len > 0){
	    $('#allHon').attr('checked', 'checked');
	}
	if (Len > checkedLen){
	    $('#allHon').attr('checked', '');
	}
    }

    function kormTest()
    {
	var checkedLen = $(".kormChBx:checked").length;
	var Len = $(".kormChBx").length;
	if (Len == checkedLen && Len > 0){
	    $('#allKor').attr('checked', 'checked');
	}
	if (Len > checkedLen){
	    $('#allKor').attr('checked', '');
	}
    }

    function LostTest()
    {
	var checkedLen = $(".lostChBx:checked").length;
	var Len = $(".lostChBx").length;
	if (Len == checkedLen && Len > 0){
	    $('#allLos').attr('checked', 'checked');
	}
	if (Len > checkedLen){
	    $('#allLos').attr('checked', '');
	}
    }

    function InfidelTest()
    {
	var checkedLen = $(".InfidelChBx:checked").length;
	var Len = $(".InfidelChBx").length;
	if (Len == checkedLen && Len > 0){
	    $('#allInf').attr('checked', 'checked');
	}
	if (Len > checkedLen){
	    $('#allInf').attr('checked', '');
	}
    }

});