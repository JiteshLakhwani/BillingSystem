<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repositories\Interfaces\FirmInterface;
use App\Repositories\FirmRepository;
use App\Repositories\Interfaces\BillDetailInterface;
use App\Repositories\BillDetailRepository;
use App\Repositories\Interfaces\BillInterface;
use App\Repositories\BillRepository;
use App\Repositories\Interfaces\AdminFirmInterface;
use App\Repositories\AdminFirmRepository;
use App\Repositories\Interfaces\UserInterface;
use App\Repositories\UserRepository;
use App\Repositories\Interfaces\ProductInterface;
use App\Repositories\ProductRepository;

class CommonServiceProvider extends ServiceProvider{

    public function register(){

        $this->registerFirmRepository();
        $this->registerBillDetailRepository();
        $this->registerBillRepository();
        $this->registerAdminFirmRepository();
        $this->registerUserRepository();
        $this->registerProductRepository();
    }

    public function registerFirmRepository(){
        $this->app->bind(FirmInterface::class, FirmRepository::class);
    }

    public function registerBillDetailRepository(){
        $this->app->bind(BillDetailInterface::class, BillDetailRepository::class);
    }

    public function registerBillRepository(){
        $this->app->bind(BillInterface::class, BillRepository::class);
    }

    public function registerAdminFirmRepository(){
        $this->app->bind(AdminFirmInterface::class, AdminFirmRepository::class);
    }

    public function registerUserRepository(){
        $this->app->bind(UserInterface::class, UserRepository::class);
    }

    public function registerProductRepository(){
        $this->app->bind(ProductInterface::class, ProductRepository::class);
    }
}