<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(PermissionSeeder::class);
        $this->call(AdminSeeder::class);
        $this->call(BannerPermissionSeeder::class);
        $this->call(CartPermissionSeeder::class);
        $this->call(CarrierPermissionSeeder::class);
        $this->call(CollectionPermissionSeeder::class);
        $this->call(CountryPermissionSeeder::class);
        $this->call(CurrencyPermissionSeeder::class);
        $this->call(DepositTransactionPermissionSeeder::class);
        $this->call(FaqPermissionSeeder::class);
        $this->call(HomePageDisplayItemPermissionSeeder::class);
        $this->call(HomePageDisplayOrderPermissionSeeder::class);
        $this->call(InitStateSeeder::class);
        $this->call(InitSystemSettingGroupSeeder::class);
        $this->call(MenuPermissionSeeder::class);
        $this->call(OrderPermissionSeeder::class);
        $this->call(PagePermissionSeeder::class);
        $this->call(PaymentOptionPermissionSeeder::class);
        $this->call(PaymentProviderPermissionSeeder::class);
        $this->call(PostCategoryPermissionSeeder::class);
        $this->call(PostPermissionSeeder::class);
        $this->call(ProductComboPermissionSeeder::class);
        $this->call(ProductReviewPermissionSeeder::class);
        $this->call(ShippingRatePermissionSeeder::class);
        $this->call(ShippingZonePermissionSeeder::class);
        $this->call(SubscriberPermissionSeeder::class);
        $this->call(SystemCurrencyPermissionSeeder::class);
    }
}
