{strip}
    <div class="container index-body">
        <div class="row">
            {if count($banners) == 0}
                <div class="col-md-6 offset-md-3 col-sm-12">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="text-center"><i class="fa fa-times"></i> {$localisation.main_temp.index.h5}</h5>
                        </div>
                    </div>
                </div>
            {else}
                {foreach $banners as $user}
                    <div class="col-md-6 col-sm-12">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="text-center"><i class="fa fa-user"></i> {$user.name}</h5>
                            </div>
                            <div class="card-body slider-box">
                                <div class="flex-slider" id="user{$user.id}">
                                    <ul class="slides">
                                        {foreach $user.banners as $banner}
                                            <a href="/{$banner.url}"><li>
                                                    <img src="{$banner.image}"/>
                                                    <p class="flex-caption text-center {if $banner.state == 2}bg-success{/if}"><a href="/{$banner.url}" class="btn btn-outline-light">{$banner.name} {if $banner.state == 2}<i class="fa fa-star" title="{$localisation.index.banner_item.state.important}"></i>{elseif $banner.state == 3}<i class="fa fa-ban" title="{$localisation.index.banner_item.state.disabled}"></i>{/if}</a></p>
                                                </li></a>
                                        {/foreach}
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                {/foreach}
            {/if}
        </div>
    </div>
{/strip}