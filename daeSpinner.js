/**
 *
 * Spinner plugin
 */

//set the parameters for the dialog window
$(function() {
    var $newDaeSpinnerHTML = $("<div class='daeSpinner'></div>");
    var $newDaeSpinnerStyle = $("<style type='text/css'>.daeSpinner{display:none;position:fixed;z-index:1000;top:0;left:0;height:100%;width:100%;background:rgba(255,255,255,.8) url(images/495.gif) 50% 50% no-repeat}body.loading{overflow:hidden}body.loading .daeSpinner{display:block}</style>");

    $("head").append( $newDaeSpinnerStyle);
    $("body").append( $newDaeSpinnerHTML);

    $(document).on({
        ajaxStart:function(){
            $("body").addClass("loading")
        },
        ajaxStop:function(){
            $("body").removeClass("loading")
        }
    });
});
