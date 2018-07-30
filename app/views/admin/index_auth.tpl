{strip}
<div class="container">
    <div class="row">
        <div class="col-md-4"></div>
        <div class="col-md-4 authorisation-form">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title text-center">{$localisation.index_auth.form_title}</h5>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <label for="login">{$localisation.index_auth.form.login.label}</label>
                        <input type="email" class="form-control" id="login" aria-describedby="loginHelp" placeholder="{$localisation.index_auth.form.login.placeholder}">
                        <small id="loginHelp" class="form-text text-danger" style="display: none">{$localisation.index_auth.errors.login}</small>
                    </div>
                    <div class="form-group">
                        <label for="password">{$localisation.index_auth.form.password.label}</label>
                        <input type="password" class="form-control" id="password" aria-describedby="passwordHelp" placeholder="{$localisation.index_auth.form.password.placeholder}">
                        <small id="passwordHelp" class="form-text text-danger" style="display: none">{$localisation.index_auth.errors.password}</small>
                    </div>
                    <button class="btn btn-block btn-success" id="signin">
                        <span>{$localisation.index_auth.form.button}</span>
                        <span style="display: none"><i class="fa fa-circle-o-notch fa-spin" style="font-size:16px"></i></span>
                    </button>
                </div>
                <div class="card-footer text-center">
                    <a href="/admin/registration/" class="card-link">{$localisation.index_auth.registration}</a>
                </div>
            </div>
        </div>
        <div class="col-md-4"></div>
    </div>
</div>
{/strip}