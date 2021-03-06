jQuery(document).ready(function(){
    var scripts = document.getElementsByTagName("script");
    var jsFolder = "";
    for (var i= 0; i< scripts.length; i++)
    {
        if( scripts[i].src && scripts[i].src.match('amazingslider/initslider-1\.js/i'))
            jsFolder = scripts[i].src.substr(0, scripts[i].src.lastIndexOf("/") + 1);
    }
    jQuery("#amazingslider-1").amazingslider({
        jsfolder:jsFolder,
        width:550,
        height:300,
        skinsfoldername:"",
        loadimageondemand:false,
        isresponsive:false,
        autoplayvideo:false,
        pauseonmouseover:false,
        addmargin:true,
        randomplay:false,
        slideinterval:8000,
        enabletouchswipe:true,
        transitiononfirstslide:false,
        loop:0,
        autoplay:true,
        navplayvideoimage:"images/amazingslider/play-32-32-0.png",
        navpreviewheight:60,
        timerheight:2,
        shownumbering:false,
        skin:"Events",
        addgooglefonts:true,
        navshowplaypause:true,
        navshowplayvideo:true,
        navshowplaypausestandalonemarginx:8,
        navshowplaypausestandalonemarginy:8,
        navbuttonradius:0,
        navthumbnavigationarrowimageheight:32,
        navmarginy:16,
        showshadow:false,
        navfeaturedarrowimagewidth:16,
        navpreviewwidth:120,
        googlefonts:"Inder",
        textpositionmarginright:24,
        bordercolor:"#ffffff",
        navthumbnavigationarrowimagewidth:32,
        navthumbtitlehovercss:"text-decoration:underline;",
        navcolor:"#999999",
        arrowwidth:32,
        texteffecteasing:"easeOutCubic",
        texteffect:"slide",
        navspacing:8,
        playvideoimage:"images/amazingslider/playvideo-64-64-0.png",
        ribbonimage:"images/amazingslider/ribbon_topleft-0.png",
        navwidth:120,
        showribbon:false,
        arrowimage:"images/amazingslider/arrows-32-32-0.png",
        timeropacity:0.6,
        navthumbnavigationarrowimage:"images/amazingslider/carouselarrows-32-32-0.png",
        navshowplaypausestandalone:false,
        navpreviewbordercolor:"#ffffff",
        ribbonposition:"topleft",
        navthumbdescriptioncss:"display:block;position:relative;padding:2px 4px;text-align:left;font:normal 12px Arial,Helvetica,sans-serif;color:#333;",
        arrowstyle:"mouseover",
        navthumbtitleheight:18,
        textpositionmargintop:24,
        navswitchonmouseover:false,
        navarrowimage:"images/amazingslider/navarrows-28-28-0.png",
        arrowtop:50,
        textstyle:"static",
        playvideoimageheight:64,
        navfonthighlightcolor:"#666666",
        showbackgroundimage:false,
        navpreviewborder:4,
        navopacity:0.8,
        shadowcolor:"#aaaaaa",
        navbuttonshowbgimage:true,
        navbuttonbgimage:"images/amazingslider/navbuttonbgimage-28-28-0.png",
        textbgcss:"display:block; position:absolute; top:0px; left:0px; width:100%; height:100%; background-color:#333333; opacity:0.6; filter:alpha(opacity=60);",
        navdirection:"horizontal",
        navborder:2,
        bottomshadowimagewidth:110,
        showtimer:true,
        navradius:0,
        navshowpreview:false,
        navpreviewarrowheight:8,
        navmarginx:16,
        navfeaturedarrowimage:"images/amazingslider/featuredarrow-16-8-0.png",
        navfeaturedarrowimageheight:8,
        navstyle:"thumbnails",
        textpositionmarginleft:24,
        descriptioncss:"display:block; position:relative; margin-top:4px; font:12px Inder,Arial,Tahoma,Helvetica,sans-serif; color:#fff;",
        navplaypauseimage:"images/amazingslider/navplaypause-28-28-0.png",
        backgroundimagetop:-10,
        timercolor:"#ffffff",
        numberingformat:"%NUM/%TOTAL ",
        navfontsize:12,
        navhighlightcolor:"#333333",
        navimage:"images/amazingslider/bullet-24-24-5.png",
        navheight:60,
        navshowplaypausestandaloneautohide:false,
        navbuttoncolor:"#999999",
        navshowarrow:true,
        navshowfeaturedarrow:true,
        titlecss:"display:block; position:relative; font: 14px Inder,Arial,Tahoma,Helvetica,sans-serif; color:#fff;",
        ribbonimagey:0,
        ribbonimagex:0,
        navshowplaypausestandaloneposition:"bottomright",
        shadowsize:5,
        arrowhideonmouseleave:1000,
        navshowplaypausestandalonewidth:28,
        navshowplaypausestandaloneheight:28,
        backgroundimagewidth:120,
        textautohide:true,
        navthumbtitlewidth:120,
        navpreviewposition:"top",
        playvideoimagewidth:64,
        arrowheight:32,
        arrowmargin:8,
        texteffectduration:1000,
        bottomshadowimage:"images/amazingslider/bottomshadow-110-95-4.png",
        border:6,
        timerposition:"bottom",
        navfontcolor:"#333333",
        navthumbnavigationstyle:"arrow",
        borderradius:0,
        navbuttonhighlightcolor:"#333333",
        textpositionstatic:"bottom",
        navthumbstyle:"imageandtitle",
        textcss:"display:block; padding:12px; text-align:left;",
        navbordercolor:"#ffffff",
        navpreviewarrowimage:"images/amazingslider/previewarrow-16-8-0.png",
        showbottomshadow:true,
        textpositionmarginstatic:0,
        backgroundimage:"",
        navposition:"bottom",
        navpreviewarrowwidth:16,
        bottomshadowimagetop:95,
        textpositiondynamic:"bottomleft",
        navshowbuttons:false,
        navthumbtitlecss:"display:block;position:relative;padding:2px 4px;text-align:center;font:bold 12px Arial,Helvetica,sans-serif;color:#333;",
        textpositionmarginbottom:24,
        ribbonmarginy:0,
        ribbonmarginx:0,
        slice: {
            duration:1500,
            easing:"easeOutCubic",
            checked:true,
            effects:"up,down,updown",
            slicecount:10
        },
        blocks: {
            columncount:5,
            checked:true,
            rowcount:5,
            effects:"topleft,bottomright,top,bottom,random",
            duration:1500,
            easing:"easeOutCubic"
        },
        blinds: {
            duration:2000,
            easing:"easeOutCubic",
            checked:true,
            slicecount:3
        },
        transition:"slice,blocks,blinds"
    });
});