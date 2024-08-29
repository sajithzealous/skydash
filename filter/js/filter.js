$(function() {
  
  setCheckboxSelectLabels();
  
  $('.toggle-next').click(function() {
    $(this).next('.checkboxes').slideToggle(400);
  });
  
  $('.ckkBox').change(function() {
    toggleCheckedAll(this);
    setCheckboxSelectLabels(); 
  });
  
});
  
function setCheckboxSelectLabels(elem) {
  var wrappers = $('.wrapper'); 
  $.each( wrappers, function( key, wrapper ) {
    var checkboxes = $(wrapper).find('.ckkBox');
    var label = $(wrapper).find('.checkboxes').attr('id');
    var prevText = '';

    $.each( checkboxes, function( i, checkbox ) {
      var button = $(wrapper).find('button');
      if( $(checkbox).prop('checked') == true) {
        var text = $(checkbox).next().html();
        var btnText = prevText + text;
        var numberOfChecked = $(wrapper).find('input.val:checkbox:checked').length;
        if(numberOfChecked >= 4) {
           btnText = numberOfChecked +' '+ label + ' selected';
        }
        $(button).text(btnText); 
        prevText = btnText + ', ';
      }
    });
  });
}
