(function($){

	/**
	 * [hotele description]
	 * @param  {[type]} p [description] 父元素
	 * @param  {[type]} c [description] 子元素;
	 * @return {[type]}   [description]
	 */
	$.extend({
	gosider:function(p,c){
    var parentBox = document.querySelector("."+p);
    /*做滑动*/
    var childBox = parentBox.querySelector("."+c);
    /*获取高度*/
    var parentHeight = $("."+p).outerHeight();
    var childHeight = $("."+c).outerHeight()+10;
    /*定位区间*/
    var maxPosition = 0;
    var minPosition = parentHeight-childHeight;
    /*缓冲的距离*/
    var distance = 10;
    /*滑动区间*/
    var maxSwipe = maxPosition + distance;
    var minSwipe = minPosition - distance;

    /*公用的方法*/
    var addTransition = function(){
        childBox.style.webkitTransition = "all .2s";
        childBox.style.transition = "all .2s";
    };
    var removeTransition = function(){
        childBox.style.webkitTransition = "none";
        childBox.style.transition = "none";
    };
    var setTranslateY = function(translateY){
        childBox.style.webkitTransform = "translateY("+translateY+"px)";
        childBox.style.transform = "translateY("+translateY+"px)";
    };
    var currY = 0;
    var startY = 0;
    var moveY = 0;
    var distanceY = 0;
   

    childBox.addEventListener('touchstart',function(e){
        startY = e.touches[0].clientY;
        // startX = e.touches[0].clientX;
        // console.log( startY+"xxx"+startX)
         if(minPosition>0){
            return false;
        }
    });
    childBox.addEventListener('touchmove',function(e){
        if(minPosition>0){
            return false;
        }
        moveY = e.touches[0].clientY;
        /*Y轴移动的坐标的距离*/
        distanceY = moveY - startY;
        removeTransition();
        if((currY + distanceY) < maxSwipe && (currY + distanceY) > minSwipe){
            setTranslateY(currY + distanceY);
        }
    });

    window.addEventListener('touchend',function(e){
        if(minPosition>0){
            return false;
        }
        if((currY + distanceY) > maxPosition){
            currY = maxPosition;
            addTransition();
            setTranslateY(currY);
        }
        else if((currY + distanceY) < minPosition){
            currY = minPosition;
            addTransition();
            setTranslateY(currY);
        }
        else{
            /*下一次做滑动的时候是以它做基准*/
            currY = currY + distanceY;
        }
        /*重置*/
        startY = 0;
        moveY = 0;
        distanceY = 0;

    });
}

})

})(jQuery)