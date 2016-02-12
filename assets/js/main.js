

$(function () {
    $('a.item').click(function() {
        $('.item').removeClass('active'); 
        $(this).addClass('active');
    });
    
    $('a.header.item').click(function() {
        $('.item').removeClass('active');
        $(this).removeClass('active');
    });
    
    $('#login').click(function() {
        $('.ui.modal').modal('show');
        $('.item').removeClass('active');
    });
    
});


function showlogin () {
    $('.ui.modal').modal('show');
};

function hidelogin() {
    $('.ui.modal').modal('hide');
};


$(document)
    .ready(function() {
      $('.ui.form')
        .form({
          fields:  {
            username : 'empty',
            password : 'empty'
          }
        })
      ;
    })
  ;

