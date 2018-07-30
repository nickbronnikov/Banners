{strip}
    <div class="row">
        {foreach $banners as $index => $banner}
            <div class="col-md-6 col-sm-12 banner-item" id="banner{$banner.id}" sort="{$banner.sort}">
                <div class="card {if $banner.state == 2}text-white bg-success{elseif $banner.state == 3}text-white bg-warning{/if}" style="width: 100%">
                    <img class="card-img-top" src="{$banner.image}" alt="Card image cap">
                    <div class="card-body">
                        <h5 class="card-title text-center">{$banner.name} {if $banner.state == 2}<i class="fa fa-star" title="{$localisation.index.banner_item.state.important}"></i>{elseif $banner.state == 3}<i class="fa fa-ban" title="{$localisation.index.banner_item.state.disabled}"></i>{/if}</h5>
                        <a href="/admin/edit/{$banner.id}" class="btn {if $banner.state != 1}btn-outline-light{else}btn-outline-dark{/if}">{$localisation.index.banner_item.edit}</a>
                        <div class="btn-group pull-right" role="group" aria-label="Basic example">
                            <button type="button" class="btn sort-up {if $banner.state != 1}btn-outline-light{else}btn-outline-dark{/if}" {if $index == 0}disabled{/if}>
                                <span><i class="fa fa-arrow-up"></i></span>
                                <span style="display: none"><i class="fa fa-circle-o-notch fa-spin" style="font-size:16px"></i></span>
                            </button>
                            <button type="button" class="btn sort-down {if $banner.state != 1}btn-outline-light{else}btn-outline-dark{/if}" {if (count($banners) - 1) == $index}disabled{/if}>
                                <span><i class="fa fa-arrow-down"></i></span>
                                <span style="display: none"><i class="fa fa-circle-o-notch fa-spin" style="font-size:16px"></i></span>
                            </button>
                            <button type="button" class="btn delete btn-outline-danger">
                                <span><i class="fa fa-trash"></i></span>
                                <span style="display: none"><i class="fa fa-circle-o-notch fa-spin" style="font-size:16px"></i></span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        {/foreach}
    </div>
{/strip}