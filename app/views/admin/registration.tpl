{strip}
    <div class="container">
        <div class="row">
            <div class="col-md-3"></div>
            <div class="col-md-6 registration-form">
                <div class="card">
                    <div class="card-header">
                        <h5 class="text-center">{$localisation.registration.form_title}</h5>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label for="name">{$localisation.registration.form.name.label}</label>
                            <input type="text" class="form-control" id="name" aria-describedby="loginHelp" placeholder="{$localisation.registration.form.name.placeholder}">
                            <small id="nameHelp" class="form-text text-muted"></small>
                        </div>
                        <div class="form-group">
                            <label for="email">{$localisation.registration.form.email.label}</label>
                            <input type="email" class="form-control" id="email" aria-describedby="emailHelp" placeholder="{$localisation.registration.form.email.placeholder}">
                            <small id="emailHelp" class="form-text text-muted"></small>
                        </div>
                        <div class="form-group">
                            <label for="password">{$localisation.registration.form.password.label}</label>
                            <input type="password" class="form-control" id="password" aria-describedby="passwordHelp" placeholder="{$localisation.registration.form.password.placeholder}">
                            <small id="passwordHelp" class="form-text text-muted">{$localisation.registration.form.password.small}</small>
                        </div>
                        <div class="form-group">
                            <label for="password-repeat">{$localisation.registration.form.password.label}</label>
                            <input type="password" class="form-control" id="password_repeat" aria-describedby="password-repeatHelp" placeholder="{$localisation.registration.form.password_repeat.placeholder}">
                            <small id="password-repeatHelp" class="form-text text-muted"></small>
                        </div>
                        <button class="btn btn-block btn-success" id="register">
                            <span>{$localisation.registration.form.button}</span>
                            <span style="display: none"><i class="fa fa-circle-o-notch fa-spin" style="font-size:16px"></i></span>
                        </button>
                        <div class="alert alert-success" role="alert" id="created" style="display:none; margin-top: 15px;">
                            {$localisation.registration.form.created}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    </div>
                    <div class="card-footer text-center">
                        <a href="/admin/" class="card-link">{$localisation.registration.authorisation}</a>
                    </div>
                </div>
            </div>
            <div class="col-md-3"></div>
        </div>
    </div>
{/strip}