<?php

namespace App\Console\Commands;

use App\Services\CollectionService;
use App\Services\InventoryService;
use App\Services\PageService;
use App\Services\PostCategoryService;
use App\Services\PostService;
use App\Services\VideoService;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Laravelium\Sitemap\Sitemap;

class SitemapGenerate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sitemap:generate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate sitemap';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        /** @var Sitemap */
        $sitemap = app('sitemap');

        $sitemap->add(route('fe.web.home'), Carbon::now(), '1.0', 'daily');

        InventoryService::make()
            ->searchForGuest(['paginate' => false])
            ->each(function($inventory) use (&$sitemap) {
                $sitemap->add(
                    route('fe.web.products.index', data_get($inventory, 'slug')),
                    data_get($inventory, 'created_at'), '0.8', 'daily'
                );
            });

        CollectionService::make()
            ->searchForGuest(['paginate' => false])
            ->each(function($collection) use (&$sitemap) {
                $sitemap->add(
                    route('fe.web.collections.index', data_get($collection, 'slug')),
                    data_get($collection, 'created_at'), '0.6', 'daily'
                );
            });

        PostCategoryService::make()
            ->searchForGuest(['paginate' => false])
            ->each(function($postCategory) use (&$sitemap) {
                $sitemap->add(
                    route('fe.web.news.show-post-categories', data_get($postCategory, 'slug')),
                    data_get($postCategory, 'created_at'), '0.6', 'daily'
                );
            });

        PostService::make()
            ->searchForGuest(['paginate' => false])
            ->each(function($post) use (&$sitemap) {
                $sitemap->add(
                    route('fe.web.posts.index', data_get($post, 'slug')),
                    data_get($post, 'created_at'), '0.8', 'daily'
                );
            });

        VideoService::make()
            ->searchForGuest(['paginate' => false])
            ->each(function($video) use (&$sitemap) {
                $sitemap->add(
                    route('fe.web.videos.index', data_get($video, 'slug')),
                    data_get($video, 'created_at'), '0.6', 'daily'
                );
            });

        PageService::make()
            ->searchForGuest(['paginate' => false])
            ->each(function($page) use (&$sitemap) {
                $sitemap->add(
                    route('fe.web.pages.index', data_get($page, 'slug')),
                    data_get($page, 'created_at'), '0.6', 'daily'
                );
            });

        $sitemap->store('xml', 'sitemap');

        if (File::exists(public_path() . '/sitemap.xml')) {
            chmod(public_path() . '/sitemap.xml', 0777);
        }

        $this->info('Sitemap Generated Successfully!');

        return 0;
    }
}
