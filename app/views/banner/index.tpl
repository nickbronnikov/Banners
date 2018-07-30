{strip}
    <div class="container body-banner">
        <div class="row">
            <div class="col-sm-12 col-md-6 offset-md-3">
                <div class="card text-white bg-dark" style="width: 100%">
                    <img class="card-img-top" src="{$banner.image}" alt="Card image cap">
                    <div class="card-body  {if $banner.state == 2}bg-success{elseif $banner.state == 3}bg-warning{/if}">
                        <h5 class="card-title text-center">{$banner.name} {if $banner.state == 2}<i class="fa fa-star" title="{$localisation.index.banner_item.state.important}"></i>{elseif $banner.state == 3}<i class="fa fa-ban" title="{$localisation.index.banner_item.state.disabled}"></i>{/if}</h5>
                        <p class="card-text text-center">{$user['name']}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
{/strip}