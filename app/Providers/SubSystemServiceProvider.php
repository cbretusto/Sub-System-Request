<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use App\Solid\Interfaces\UserManagementInterface;
use App\Solid\Interfaces\SubSystemHistoryInterface;
use App\Solid\Interfaces\ExportInterface;

use App\Solid\Repositories\UserManagementRepository;
use App\Solid\Repositories\SubSystemHistoryRepository;
use App\Solid\Repositories\ExportRepository;

class SubSystemServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(UserManagementInterface::class, UserManagementRepository::class);
        $this->app->bind(SubSystemHistoryInterface::class, SubSystemHistoryRepository::class);
        $this->app->bind(ExportInterface::class, ExportRepository::class);
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
