/**
 * @author Lance Snider - lance@lancesnider.com
*/

jQuery( document ).ready(function() {
var goalAmount=jQuery("#goal-thermometer").attr("data-goalamount");  //how much are you trying to get
var currentAmount=jQuery("#goal-thermometer").attr("data-currentAmount");  //how much do you currently have

if(parseInt(currentAmount) > parseInt(goalAmount))
{
    currentAmount=goalAmount;
}

//editable vars    
var animationTime = 3000;//in milliseconds
var numberPrefix = "$";//what comes before the number (set to "" if no prefix)
var numberSuffix = "";//what goes after the number
var widthOfNumbers = 80;//the width in px of the numbers on the left

//change the below two to adjust the height of the thermometer
var tickMarkSegementCount = 4;  //each segement adds tickHeight value in px (say:80px) to the height
var tickHeight = 80;            //Height of each tick


//standard resolution images
var glassTopImg = "wp-content/plugins/wp-stripe/images/glassTop.png";
var glassBodyImg = "wp-content/plugins/wp-stripe/images/glassBody.png";
var redVerticalImg = "wp-content/plugins/wp-stripe/images/redVertical.png";
var tooltipFGImg = "wp-content/plugins/wp-stripe/images/tickShine.png";
var glassBottomImg = "wp-content/plugins/wp-stripe/images/glassBottom.png";
var tootipPointImg = "wp-content/plugins/wp-stripe/images/tooltipPoint.png";
var tooltipMiddleImg = "wp-content/plugins/wp-stripe/images/tooltipMiddle.png";
var tooltipButtImg = "wp-content/plugins/wp-stripe/images/tooltipButt.png";

//high res images
var glassTopImg2x = "wp-content/plugins/wp-stripe/images/glassTop2x.png";
var glassBodyImg2x = "wp-content/plugins/wp-stripe/images/glassBody2x.png";
var redVerticalImg2x = "wp-content/plugins/wp-stripe/images/redVertical2x.png";
var tooltipFGImg2x = "wp-content/plugins/wp-stripe/images/tickShine2x.png";
var glassBottomImg2x = "wp-content/plugins/wp-stripe/images/glassBottom2x.png";
var tootipPointImg2x = "wp-content/plugins/wp-stripe/images/tooltipPoint2x.png";
var tooltipMiddleImg2x = "wp-content/plugins/wp-stripe/images/tooltipMiddle2x.png";
var tooltipButtImg2x = "wp-content/plugins/wp-stripe/images/tooltipButt2x.png";

/////////////////////////////////////////
// ------ don't edit below here ------ //
/////////////////////////////////////////

var arrayOfImages;
var imgsLoaded = 0;

var mercuryHeightEmpty = 0;
var numberStartY = 6;
var thermTopHeight = 13;
var thermBottomHeight = 70;
var tooltipOffset = 15; 
var heightOfBody;
var mercuryId;
var tooltipId;
var resolution2x = false;

//start once the page is loaded
jQuery( document ).ready(function() {
	determineImageSet();
});

//this checks if it's the high or normal resolution images
function determineImageSet(){
	
	resolution2x = window.devicePixelRatio == 2;//check if resolution2x
	
	if(resolution2x){	
		//switch the regular for 2x res graphics
		glassTopImg = glassTopImg2x;
		glassBodyImg = glassBodyImg2x;
		redVerticalImg = redVerticalImg2x;
		glassBottomImg = glassBottomImg2x;
		tootipPointImg = tootipPointImg2x;
		tooltipButtImg = tooltipButtImg2x;	
	}
	
	createGraphics();
}

//visually create the thermometer
function createGraphics(){
	
	//add the html
	jQuery("#goal-thermometer").html(
		"<div id='therm-numbers'>" + 
		"</div>" + 
		"<div id='therm-graphics'>" + 
			"<img id='therm-top' src='"+glassTopImg+"'></img>" + 
			"<img id='therm-body-bg' src='"+glassBodyImg+"' ></img>" + 
			"<img id='therm-body-mercury' src='"+redVerticalImg+"'></img>" + 
			"<div id='therm-body-fore'></div>" + 
			"<img id='therm-bottom' src='"+glassBottomImg+"'></img>" + 
			"<div id='therm-tooltip'>" + 
				"<img class='tip-left' src='"+tootipPointImg+"'></img>" + 
				"<div class='tip-middle'><p>$0</p></div>" + 
				"<img class='tip-right' src='"+tooltipButtImg+"'></img>" + 
			"</div>" + 
		"</div>"
	);
	
	//preload and add the background images
	jQuery('<img/>').attr('src', tooltipFGImg).load(function(){
		jQuery(this).remove();
		jQuery("#therm-body-fore").css("background-image", "url('"+tooltipFGImg+"')");
		checkIfAllImagesLoaded();
	});
	
	jQuery('<img/>').attr('src', tooltipMiddleImg).load(function(){
		jQuery(this).remove();
		jQuery("#therm-tooltip .tip-middle").css("background-image", "url('" + tooltipMiddleImg + "')");
		checkIfAllImagesLoaded();
	});
	
	//adjust the css
	heightOfBody = tickMarkSegementCount * tickHeight;
	jQuery("#therm-graphics").css("left", widthOfNumbers)
	jQuery("#therm-body-bg").css("height", heightOfBody);
	jQuery("#goal-thermometer").css("height",  heightOfBody + thermTopHeight + thermBottomHeight);
	jQuery("#therm-body-fore").css("height", heightOfBody);
	jQuery("#therm-bottom").css("top", heightOfBody + thermTopHeight);
	mercuryId = jQuery("#therm-body-mercury");
	mercuryId.css("top", heightOfBody + thermTopHeight);
	tooltipId = jQuery("#therm-tooltip");
	tooltipId.css("top", heightOfBody + thermTopHeight - tooltipOffset);
	
	//add the numbers to the left
	var numbersDiv = jQuery("#therm-numbers");
	var countPerTick = goalAmount/tickMarkSegementCount;
	var commaSepCountPerTick = commaSeparateNumber(countPerTick);
	
	//add the number
	for ( var i = 0; i < tickMarkSegementCount; i++ ) {
		
		var yPos = tickHeight * i + numberStartY;
		var style = jQuery("<style>.pos" + i + " { top: " + yPos + "px; width:"+widthOfNumbers+"px }</style>");
		jQuery("html > head").append(style);
		var dollarText = commaSeparateNumber(goalAmount - countPerTick * i);
		jQuery( numbersDiv ).append( "<div class='therm-number pos" + i + "'>" +dollarText+ "</div>" );
		
	}
	
	//check that the images are loaded before anything
	arrayOfImages = new Array( "#therm-top", "#therm-body-bg", "#therm-body-mercury", "#therm-bottom", ".tip-left", ".tip-right");
	preload(arrayOfImages);
	
};

//check if each image is preloaded
function preload(arrayOfImages) {
	
	for(i=0;i<arrayOfImages.length;i++){
		jQuery(arrayOfImages[i]).load(function() {   checkIfAllImagesLoaded();  });
	}
    
}

//check that all the images are preloaded
function checkIfAllImagesLoaded(){
	imgsLoaded++;
	if(imgsLoaded == arrayOfImages.length+2){
		jQuery("#goal-thermometer").fadeTo(1000, 1, function(){
			animateThermometer();
		});
	}
}


//animate the thermometer
function animateThermometer(){
	
	var percentageComplete = currentAmount/goalAmount;
	var mercuryHeight = Math.round(heightOfBody * percentageComplete); 
	var newMercuryTop = heightOfBody + thermTopHeight - mercuryHeight;
	
	mercuryId.animate({height:mercuryHeight +1, top:newMercuryTop }, animationTime);
	tooltipId.animate({top:newMercuryTop - tooltipOffset}, {duration:animationTime});
	
	var tooltipTxt = jQuery("#therm-tooltip .tip-middle p");
	
	//change the tooltip number as it moves
	jQuery({tipAmount: 0}).animate({
		tipAmount: currentAmount
	}, {
		duration:animationTime,
		step:function(){
			tooltipTxt.html(commaSeparateNumber(this.tipAmount));
		}, 
		complete:function(){
			tooltipTxt.html(commaSeparateNumber(jQuery("#goal-thermometer").attr("data-currentAmount")));
		}
	});
	
	
}

//format the numbers with $ and commas
function commaSeparateNumber(val){
	val = Math.round(val);
    while (/(\d+)(\d{3})/.test(val.toString())){
      val = val.toString().replace(/(\d+)(\d{3})/, '$1'+','+'$2');
    }
    return numberPrefix + val + numberSuffix;
}
});