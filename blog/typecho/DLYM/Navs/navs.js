window.onscroll = function(){
  //回到顶部
  var sllTop = document.documentElement.scrollTop||document.body.scrollTop;
  if(sllTop>240){
    $('#get-top').css('display','block')
  }else{
    $('#get-top').css('display','none')
  }
}
$('#get-top').click(function(){ 
  $('body,html').animate({
    scrollTop: 0
  }, 800);//点击回到顶部按钮，缓懂回到顶部,数字越小越快
})
// 显示/隐藏二级菜单
$(".left-menu-btn").hover(function(){
  $('#tow-nav').fadeIn(200);
},function(){
  $("#tow-nav").hover(function(){
    $('#tow-nav').fadeIn(0);
  },function(){
    $('#tow-nav').fadeOut(0)
  });
  $('#tow-nav').fadeOut(0)
})

//下面别动
function myApi(){

    this.mouseScroll = {

        inte : function(obj,value){
            this.OBJ = obj;
            this.addscroll(obj);



            var outH = obj.outerHeight(),
                oScrollcontent = obj.children(':first'),
                contentH = oScrollcontent.outerHeight(),
                oYscrollinnerH = outH/contentH*outH,
                oYscrollouter = obj.find('#Yscrollouter'),
                oYscrollinner = obj.find('#Yscrollinner');

            obj.css({'position': 'relative','overflow':'hidden'});
            oScrollcontent.css('position', 'absolute');

            if(contentH > outH){
                this.mousehover(obj, oYscrollouter, oYscrollinner);
                this.mousewheel(obj, value, oScrollcontent, oYscrollinner, outH, contentH, oYscrollinnerH );
                this.mousemoved(obj, oScrollcontent, oYscrollouter, oYscrollinner, outH, contentH, oYscrollinnerH );
            };
        },

        addscroll : function(obj,value){
            obj.append('<div id="Yscrollouter"><div id="Yscrollinner"></div></div>');
            $('#Yscrollinner').css('cursor','pointer');
        },

        mousehover : function(obj, outer, inner){

            obj.hover(function() {
                outer.fadeIn(400);
            }, function() {
                outer.fadeOut(400);
            });

            inner.hover(function() {
                $('body').css({
                    '-moz-user-select': 'none',
                    '-webkit-user-select': 'none',
                    '-ms-user-select': 'none',
                    '-khtml-user-select': 'none',
                    'user-select': 'none',});
            }, function() {
                $('body').css({
                    '-moz-user-select': 'auto',
                    '-webkit-user-select': 'auto',
                    '-ms-user-select': 'auto',
                    '-khtml-user-select': 'auto',
                    'user-select': 'auto',});
            });

        },

        mousewheel : function(obj, value, O, inner, H1, H2, H3){

            var oScrollcontentVal = value/(H1 - H3)*(H2 - H1);

                inner.height(H3);  //滚动条高度

            obj.on('mousewheel',function(event,delta ){  //绑定滚轮事件

                event.preventDefault();  //阻止浏览器默认为行

                var delta = event.originalEvent.wheelDelta;
                var oYscrollinnerTop = inner.position().top;

                var oScrollcontentTop = O.position().top;

                if(delta > 0){
                    if(oYscrollinnerTop - value < 0){
                        inner.css('top', 0);
                        O.css('top', 0);
                    }else{
                        inner.css('top', oYscrollinnerTop - value);
                        O.css('top', oScrollcontentTop + oScrollcontentVal);
                    }
                }else{
                    if(oYscrollinnerTop + value > H1 - H3){
                        inner.css('top', H1 - H3);
                        O.css('top', H1 - H2);
                    }else{
                        inner.css('top', oYscrollinnerTop + value);
                        O.css('top', oScrollcontentTop - oScrollcontentVal);
                    }
                };
            });

        },

        mousemoved : function(obj, O, outer, inner, H1, H2, H3){
            inner.on('mousedown',function(event){   //绑定鼠标事件

                var clientY = event.clientY,
                    oYscrollinnerTop = inner.position().top,
                    oScrollcontentTop = O.position().top,

                    moveY = 0;

                    $(document).on('mousemove',function(event){
                        moveY = event.clientY - clientY;
                        var oScrollcontentMove = moveY/(H1 - H3)*(H2 - H1);

                        if(oYscrollinnerTop + moveY < 0){
                            inner.css('top', 0);
                            O.css('top', 0);
                        }else if(oYscrollinnerTop + moveY > H1 - H3){
                            inner.css('top', H1 - H3);
                            O.css('top', H1 - H2);
                        }else{
                            inner.css('top', oYscrollinnerTop + moveY);
                            O.css('top', oScrollcontentTop - oScrollcontentMove);
                        }
                    });

                    $(document).on('mouseup',function(event){
                        $(document).off('mousemove');
                    })
            })
        }

    }
}