{strip}

<div class="container body-add">
    <div class="row">
        <div class="col-md-6 col-sm-12 offset-md-3">
            <h2 class="text-center"><i class="fa fa-pencil-square-o"></i> {$localisation.add.h2}:</h2>
            <div class="card">
                <div class="card-body">
                    <div class="form-group">
                        <label for="name">{$localisation.add.form.name.label}</label>
                        <input type="text" class="form-control" id="name" placeholder="{$localisation.add.form.name.placeholder}">
                        <small id="nameHelp" class="form-text text-danger"></small>
                    </div>
                    <div class="form-group">
                        <label for="url">{$localisation.add.form.url.label}:</label>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text">{$domain}/</span>
                            </div>
                            <input type="text" class="form-control" id="url" placeholder="{$localisation.add.form.url.placeholder}">
                        </div>
                        <small id="urlHelp" class="form-text text-danger"></small>
                    </div>
                    <div class="form-group">
                        <label for="state">{$localisation.add.form.state.label}:</label>

                        <select class="custom-select" id="state">
                            <option value="0" selected>{$localisation.add.form.state.placeholder}</option>
                            <option value="1">{$localisation.add.form.state.options[0]}</option>
                            <option value="2">{$localisation.add.form.state.options[1]}</option>
                            <option value="3">{$localisation.add.form.state.options[2]}</option>
                        </select>
                        <small id="stateHelp" class="form-text text-danger"></small>
                    </div>
                    <div class="form-group">
                        <label for="sort">{$localisation.add.form.sort.label}:</label>
                        <input type="number" min="1" value="1" class="form-control" id="sort" placeholder="{$localisation.add.form.sort.placeholder}">
                        <small id="sortHelp" class="form-text text-danger"></small>
                    </div>
                    <div class="form-group">
                        <label for="upload">{$localisation.add.form.image.label}:</label>
                        <div class="custom-file">
                            <input type="file" id="upload" value="{$localisation.add.form.image.placeholder}" accept="image/*" class="custom-file-input">
                            <label class="custom-file-label" for="customFile">{$localisation.add.form.image.placeholder}</label>
                        </div>
                        <small id="uploadHelp" class="form-text text-danger"></small>
                    </div>
                    <div id="cropImage">

                    </div>
                    <button class="btn btn-success btn-block" id="saveBanner">
                        <span>{$localisation.add.form.button}</span>
                        <span style="display: none"><i class="fa fa-circle-o-notch fa-spin" style="font-size:16px"></i></span>
                    </button>
                </div>
            </div>
        </div>

    </div>
</div>
{/strip}