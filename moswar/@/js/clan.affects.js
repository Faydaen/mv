/* настройки слайдера  */
clanAffectsSliderSettings = function(i){ 
	return {
		range: "min",
		value: clanAffectsValues[i] || 0,
		min: 0,
		step: 5,
		max: 100,
		slide: function(event, ui) {
			$("#"+clanAffectsNames[i]+"-input").val(ui.value);
			clanAffectsCost();
		}
	}
}

/* событие нажатия инпутов */
clanAffectsInputKeyup = function (i){
	$("#"+clanAffectsNames[i]+"-input")[0].onkeyup = function(){
		if(Number(this.value)>100) {
			this.value = 100;
		} else if(Number(this.value)<0) {
			this.value = 0;
		} 
		$("#"+clanAffectsNames[i]+"-slider").slider("value", this.value||0);
		clanAffectsCost();
	}
}
clanAffectsInputBlur = function (i){
	$("#"+clanAffectsNames[i]+"-input")[0].onblur = function(){
		if(Number(this.value)>100) {
			this.value = 100;
		} else if(Number(this.value)<0) {
			this.value = 0;
		} else {
			this.value = Math.round(this.value/5)*5;
		}
		$("#"+clanAffectsNames[i]+"-slider").slider("value", this.value||0);
		clanAffectsCost();
	}
}

clanAffectsCost = function(){
	var clanAffectsCostSum = 0;
	var clanAffectsTime = $("#clan-affects-time").val() || 0;
	/* начала формулы */
	var multiRatingKoef = 0.5;
	for(var i=0, j=clanAffectsNames.length; i<j; i++){
		var ratingValue = Number($("#"+clanAffectsNames[i]+"-input").val()) || 0;
		var ratingKoef = ratingValue ?( 1 + ( (ratingValue/5 - 1) *0.2 + 1 ) )/ 2 : 0; 
		var timeKoef =  (1 + (clanAffectsTime - 1) * 0.2 + 1) / 2; 
		var singleRatingCost = Math.floor(ratingKoef * 75 * ratingValue * timeKoef * clanAffectsTime);
		multiRatingKoef += ratingValue>0 ? 0.5 : 0;
		clanAffectsCostSum = clanAffectsCostSum + singleRatingCost;
	}
	
	clanAffectsCostSum = Math.floor(clanAffectsCostSum * multiRatingKoef);
	/* конец формулы */
    $("#clan-affects-cost").html(formatNumber(clanAffectsCostSum, 0, "", ","));
	$("#clan-affects-cost-member").html( formatNumber( Math.ceil(clanAffectsCostSum/(clanMembersNumber||1)) , 0, "", ",") );
    if (clanAffectsCostSum >= clanMoney) {
        $("#banzai-button").addClass("disabled");
        $("#banzai-button").attr("disabled", true);
        $("#clan-affects-hint-money").addClass("error");
        // вывести сообщение об ошибке
    } else {
        $("#banzai-button").removeClass("disabled");
        $("#banzai-button").attr("disabled", false);
		$("#clan-affects-hint-money").removeClass("error");
        // спрятать сообщение об ошибке
    }
}

/* init */
clanAffectsInit = function(){
	for(var i=0, j=clanAffectsNames.length; i<j; i++){
		$("#"+clanAffectsNames[i]+"-slider").slider(clanAffectsSliderSettings(i));
		$("#"+clanAffectsNames[i]+"-input").val(clanAffectsValues[i]);
		clanAffectsInputKeyup(i);
		clanAffectsInputBlur(i);
	}
	$("#clan-affects-time").bind("change",clanAffectsCost);
}