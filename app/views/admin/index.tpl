{strip}
<div class="container body-banners">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <h2 class="text-center ">{$localisation.index.h2}</h2>
                </div>
            </div>
            <div class="row margin">
                <div class="col-md-4 col-sm-1"></div>
                <div class="col-md-4 col-sm-10">
                    <a href="/admin/add" class="btn btn-lg btn-outline-success btn-block">+ {$localisation.index.add_button}</a>
                </div>
                <div class="col-md-4 col-sm-1"></div>
            </div>

            <div class="card">
                <div class="card-body" id="banner-list">
                    {if count($banners) != 0}
                        {include file="$list_temp"}
                    {else}
                        <h3 class="text-dark text-center">{$localisation.index.empty}</h3>
                    {/if}
                </div>
            </div>
        </div>
    </div>
</div>
{/strip}