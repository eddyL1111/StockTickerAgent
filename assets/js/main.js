

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
    
    $('.ui.dropdown').click(function() {
       $('.ui.dropdown').dropdown();
    });

    
});


function showlogin () {
    $('.ui.modal').modal('show');
};

function hidelogin() {
    $('.ui.modal').modal('hide');
};


$(document).ready(function() {
    $('.ui.form').form({
        on: 'blur',
        fields: {
            userid: {
                identifier: 'userid',
                rules: [
                    {
                      type   : 'empty',
                      prompt : 'Please enter a userid'
                    }
                ]
            },
            username: {
                identifier: 'username',
                rules: [
                    {
                      type   : 'empty',
                      prompt : 'Please enter a username'
                    }
                ]
            },
            password: {
                identifier  : 'password',
                rules: [
                    {
                      type   : 'empty',
                      prompt : 'Please enter a password'
                    }
                ]
            },
            password1: {
                identifier  : 'password1',
                rules: [
                    {
                      type   : 'empty',
                      prompt : 'Please enter a password'
                    }
                ]
            },
            password2: {
                identifier  : 'password2',
                rules: [
                    {
                      type   : 'empty',
                      prompt : 'Please re-confirm your password'
                    },
                    {
                      type   : 'match[password1]',
                      prompt : 'Passwords are not the same'
                    }
                ]
            }
        }
    });
});

