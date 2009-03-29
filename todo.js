$(function() {
    // hide toolbar
    setTimeout(scrollTo, 0, 0, 1);

    // auto-focus the input field
    $("input#cmd").focus();

    // for todo-tag links
    $('a.todo-tag').click(function(event){
        var str = $(event.target).text();
        str = "ls " + str + " ";
        $("input#cmd").val(str).focus();
    });

    // for todo-number links
    $('a.todo-number').click(function(event){
        var str = $(event.target).text();
        $("input#cmd").val(str).focus(function(){
            $(this).setCursorPosition(0);
        }).focus();
    });

    // prevent double submit
    $('form#todo').submit(function() {
        $(':submit', this).attr('disabled','disabled').val('Loading...');
    });

});

// setCursorPosition function for todo-number, from:
// http://stackoverflow.com/questions/499126/jquery-set-cursor-position-in-text-area
new function($) {
  $.fn.setCursorPosition = function(pos) {
    if ($(this).get(0).setSelectionRange) {
      $(this).get(0).setSelectionRange(pos, pos);
    } else if ($(this).get(0).createTextRange) {
      var range = $(this).get(0).createTextRange();
      range.collapse(true);
      range.moveEnd('character', pos);
      range.moveStart('character', pos);
      range.select();
    }
  }
}(jQuery);

