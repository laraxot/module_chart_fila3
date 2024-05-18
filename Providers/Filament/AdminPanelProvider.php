<?php

declare(strict_types=1);

namespace Modules\Chart\Providers\Filament;

use Filament\Panel;
use Modules\Quaeris\Filament\Pages\Dashboard;
use Modules\Xot\Providers\Filament\XotBasePanelProvider;
use Filament\Support\Assets\Js;
use Filament\Support\Facades\FilamentAsset;
use Illuminate\Support\Facades\Vite;


class AdminPanelProvider extends XotBasePanelProvider
{
    protected string $module = 'Chart';

    public function panel(Panel $panel): Panel
    {
        $panel = parent::panel($panel);
        //$panel->assets([
        //    Js::make('chart-js-plugins', Vite::asset('Resources/js/filament-chart-js-plugins.js', 'assets/chart'))->module(),
        //]);
        FilamentAsset::register([
            Js::make('chart-js-plugins', Vite::asset('Resources/js/filament-chart-js-plugins.js', 'assets/chart'))->module(),
        ]);

        return $panel;
    }
}
