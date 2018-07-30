
let croppie;

let banner_id = 0;

function signIn(){
    $.ajax({
        type: "POST",
        url: "/admin/signin",
        data: {params: JSON.stringify({login: $('#login').val(), password: $('#password').val()})},
        beforeSend: function () {
            let button = $('#signin');
            button.find('span').eq(0).hide();
            button.find('span').eq(1).show();
            button.attr('disabled', true);
        },
        success: function (data) {
            let button = $('#signin');
            button.find('span').eq(1).hide();
            button.find('span').eq(0).show();
            button.removeAttr('disabled');
            //console.log(data);
            let json = JSON.parse(data);
            if(json['success'] === 1){
                location.reload();
            } else {
                if(json['errors']['login'] !== undefined){
                    $('#login').addClass('is-invalid').parent().find('small').show();
                }
                if(json['errors']['password'] !== undefined){
                    $('#password').addClass('is-invalid').parent().find('small').show();
                }
            }
        }
    });
}

function Registration(serrors  = false) {

    let _this = this;

    let data = {};

    let correct = true;

    let errors = {};

    if(serrors){
         errors = serrors;
    }

    function saveData() {
        data['name'] = $('#name').val().trim();
        data['email'] = $('#email').val().trim();
        data['password'] = $('#password').val().trim();
        data['password_repeat'] = $('#password_repeat').val().trim();
    }

    function validateEmail(email){
        const re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
        return re.test(String(email).toLowerCase());
    }

    Registration.prototype.isCorrect = function() {
        saveData();
        validateFields();
        return correct;
    };

    Registration.prototype.sendData = function() {
        $.ajax({
            type: "POST",
            url: "/admin/savenewuser",
            data: {params: JSON.stringify(data)},
            beforeSend: function () {
                let button = $('#register');
                button.find('span').eq(0).hide();
                button.find('span').eq(1).show();
                button.attr('disabled', true);
            },
            success: function (data) {
                let button = $('#register');
                button.find('span').eq(1).hide();
                button.find('span').eq(0).show();
                button.removeAttr('disabled');
                // console.log(data);
                let json = JSON.parse(data);
                if(json['success'] === 1){
                    $('#created').show();
                    location.href = '/admin';
                } else {
                    if(json['errors']['email']['already_exist'] !== undefined){
                        correct = false;
                        errors['email'] = LOCAL.registration_errors.email.already_exist;
                        _this.showErrors();
                    }
                }
            }
        });
    };

    Registration.prototype.showErrors = function () {
        if(!correct){
            $.each(errors, function (index, value) {
                let selector = '#' + index;
                let group = $(selector).parent();
                group.find('small').removeClass('text-muted').addClass('text-danger').text(value);
                group.find('input').addClass('is-invalid');
            });
        }
    };



    function validateFields(){
        if(data.name === ''){
            correct = false;
            errors['name'] = LOCAL.registration_errors.name;
        }
        if(data.password.length < 6){
            correct = false;
            errors['password'] = LOCAL.registration_errors.password.too_short;
        } else {
            if(data.password_repeat !== data.password){
                correct = false;
                errors['password_repeat'] = LOCAL.registration_errors.password.does_not_match;
            }
        }
        if(data.email === ''){
            correct = false;
            errors['email'] = LOCAL.registration_errors.email.empty;
        } else {
            if(!validateEmail(data.email)){
                correct = false;
                errors['email'] = LOCAL.registration_errors.email.not_correct;
            }
        }

    }
}

function Banner(){

    let _this = this;
    let correct = true;
    let errors = {};
    let data = {};

    function getData(){
        data['name'] = $('#name').val().trim();
        data['url'] = $('#url').val().trim();
        data['upload'] = $('#upload').val().trim();
        data['state'] = $('#state').val();
        data['sort'] = $('#sort').val().trim();
    }


    Banner.prototype.validateFields = function(){
        getData();
        if(data['name'] === ''){
            correct = false;
            errors['name'] = LOCAL.banner_errors.name.empty;
        }
        if(data['state'] === '0'){
            correct = false;
            errors['state'] = LOCAL.banner_errors.state.empty;
        }
        if(parseInt(data['sort']) < 1){
            correct = false;
            errors['sort'] = LOCAL.banner_errors.sort.too_small;
        }
        if(data['upload'] === '' && banner_id === 0){
            correct = false;
            errors['upload'] = LOCAL.banner_errors.upload.empty;
        }
        //console.log(errors);
        _this.showErrors();

    };

    function getCorrect(){
        return correct;
    }

    Banner.prototype.showErrors = function () {
        if(!correct){
            $.each(errors, function (index, value) {
                let selector = '#' + index;
                let group;
                if(index === 'upload'){
                    group = $(selector).parent().parent();
                } else {
                    group = $(selector).parent();
                }
                group.find('small').removeClass('text-muted').addClass('text-danger').text(value);
                if(index === 'state'){
                    group.find('select').addClass('is-invalid');
                } else {
                    group.find('input').addClass('is-invalid');
                }

            });
        }
    };

    Banner.prototype.setURLErrors = function(error){
        correct = 0;
        errors['url'] = LOCAL['banner_errors']['url'][error];
    };

    Banner.prototype.saveBanner = function(){
        _this.validateFields();
        if(correct){
            $.when(_this.checkURL()).done(function (res) {
                let json = JSON.parse(res);
                if(json.success){
                    croppie.croppie('result', {type: 'base64'}).then(function (image) {
                        data['image'] = image;
                        $.ajax({
                            type: "POST",
                            url: "/admin/savenewbanner",
                            data: {params: JSON.stringify(data), banner_id: banner_id},
                            beforeSend: function () {
                                let button = $('#saveBanner');
                                button.find('span').eq(0).hide();
                                button.find('span').eq(1).show();
                                button.attr('disabled', true);
                            },
                            success: function (data) {
                                let button = $('#saveBanner');
                                button.find('span').eq(1).hide();
                                button.find('span').eq(0).show();
                                button.removeAttr('disabled');
                                //console.log(data);
                                let json = JSON.parse(data);
                                if(json['success'] === 1){
                                    $('#created').show();
                                    // if(banner_id === 0){
                                    //     location.href = '/admin/edit/' + json['id'];
                                    // }
                                    location.href = '/admin';
                                } else {
                                    if(json['errors']['url'] !== undefined){
                                        correct = false;
                                        errors['email'] = LOCAL.banner_errors.url[json['errors']['url']];
                                        _this.showErrors();
                                    }
                                }
                            }
                        });
                    })
                }
            });
        }

    };

    Banner.prototype.checkURL = function () {
        return $.ajax({
            type: "POST",
            url: "/admin/checkurl",
            data: {url: $('#url').val().trim(), banner_id: banner_id},
            beforeSend: function () {

            },
            success: function (data) {
                //console.log(data);
                let json = JSON.parse(data);
                if(json.success !== 1){
                    //_this.setURLErrors(json.error);
                    $('#url').addClass('is-invalid');
                    $('#urlHelp').text(LOCAL.banner_errors.url[json.error]);
                }
            }
        });
    };

    Banner.prototype.updateSort = function(action, id){
        let selector = '.sort-' + action;
        $.ajax({
            type: "POST",
            url: "/admin/updatesort",
            data: {action: action, banner_id: id},
            beforeSend: function () {
                let button = $(selector);
                button.find('span').eq(0).hide();
                button.find('span').eq(1).show();
                button.attr('disabled', true);
            },
            success: function (data) {
                // console.log(data);
                let button = $(selector);
                button.find('span').eq(1).hide();
                button.find('span').eq(0).show();
                button.removeAttr('disabled');
                $('#banner-list').html(data);
            }
        });
    };

    Banner.prototype.deleteBanner = function (id) {
        $.ajax({
            type: "POST",
            url: "/admin/deletebanner",
            data: {banner_id: id},
            beforeSend: function () {
                let button = $('.delete');
                button.find('span').eq(0).hide();
                button.find('span').eq(1).show();
                button.attr('disabled', true);
            },
            success: function (data) {
                // console.log(data);
                let button = $('.delete');
                button.find('span').eq(1).hide();
                button.find('span').eq(0).show();
                button.removeAttr('disabled');
                $('#banner-list').html(data);
            }
        });
    };

}


function readFile(input) {
    if (input.files && input.files[0]) {
        let reader = new FileReader();

        reader.onload = function (e) {
            $('.upload-demo').addClass('ready');
            croppie.croppie('bind', {
                url: e.target.result
            }).then(function(){
                croppie.croppie('setZoom', 0.05);
                $('.crop-image-container').show();
            });

        };

        reader.readAsDataURL(input.files[0]);
    }
    else {
        //console.log("Sorry - you're browser doesn't support the FileReader API");
    }
}



$(document).ready(function () {

    $('.main-container').css('min-height', window.outerHeight - 115);

    $('body').on('click', '.delete', function () {
        let banner = new Banner();
        let id = parseInt($(this).closest('.banner-item').attr('id').replace('banner', ''));
        banner.deleteBanner(id);
    });
    $('body').on('click', '.sort-up', function () {
        let banner = new Banner();
        let id = parseInt($(this).closest('.banner-item').attr('id').replace('banner', ''));
        banner.updateSort('up', id);
    });
    $('body').on('click', '.sort-down', function () {
        let banner = new Banner();
        let id = parseInt($(this).closest('.banner-item').attr('id').replace('banner', ''));
        banner.updateSort('down', id);
    });

    $('#upload').on('change', function () { readFile(this); });
    $('#url').on('input', function () {
        $('#url').removeClass('is-invalid');
        $('#urlHelp').text('');
        let banner = new Banner();
        banner.checkURL();
    });
    $('#saveBanner').on('click', function () {
        let banner = new Banner();
        banner.saveBanner();
    });
    $('#exit').on('click', function () {
        $.ajax({
            type: "POST",
            url: "/admin/exitauth",
            data: {},
            beforeSend: function () {
            },
            success: function (data) {
                $.removeCookie('auth_token', { path: '/' });
                location.reload();
            }
        });
    });
    $('#signin').on('click', function () {
        signIn();
    });
    $('#register').on('click', function () {
        let registration = new Registration();
        if(registration.isCorrect()){
            registration.sendData();
        } else {
            registration.showErrors();
        }

    });
    $('.registration-form').find('input').on('input', function () {
        $(this).removeClass('is-invalid');
        $(this).parent().find('small').removeClass('text-danger').addClass('text-muted').text('');
    });
    $('.authorisation-form').find('input').on('input', function () {
        $(this).removeClass('is-invalid');
        $(this).parent().find('small').hide();
    });
    $('.body-add').find('input').on('input', function () {
        $(this).removeClass('is-invalid');
        if($(this).attr('id') === 'upload'){
            $(this).parent().parent().find('small').text('');
        } else{
            $(this).parent().find('small').text('');
        }
    });
    $('.body-add').find('select').on('input', function () {
        $(this).removeClass('is-invalid');
        $(this).parent().find('small').text('');
    });
});