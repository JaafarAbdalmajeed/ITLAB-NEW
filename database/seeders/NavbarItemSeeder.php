<?php

namespace Database\Seeders;

use App\Models\NavbarItem;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class NavbarItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $items = [
            [
                'label' => 'Home',
                'url' => '/',
                'route' => 'home',
                'icon' => null,
                'order' => 0,
                'is_active' => true,
                'target' => '_self',
                'css_class' => null,
            ],
            [
                'label' => 'Dashboard',
                'url' => '/dashboard',
                'route' => 'pages.dashboard',
                'icon' => null,
                'order' => 1,
                'is_active' => true,
                'target' => '_self',
                'css_class' => null,
            ],
            [
                'label' => 'HTML',
                'url' => '/html',
                'route' => 'pages.html',
                'icon' => null,
                'order' => 2,
                'is_active' => true,
                'target' => '_self',
                'css_class' => null,
            ],
            [
                'label' => 'CSS',
                'url' => '/learn-css',
                'route' => 'pages.css',
                'icon' => null,
                'order' => 3,
                'is_active' => true,
                'target' => '_self',
                'css_class' => null,
            ],
            [
                'label' => 'JavaScript',
                'url' => '/learn-js',
                'route' => 'pages.js',
                'icon' => null,
                'order' => 4,
                'is_active' => true,
                'target' => '_self',
                'css_class' => null,
            ],
            [
                'label' => 'Java',
                'url' => '/learn-java',
                'route' => 'pages.java',
                'icon' => null,
                'order' => 5,
                'is_active' => true,
                'target' => '_self',
                'css_class' => null,
            ],
            [
                'label' => 'Network Security',
                'url' => '/cyber-network',
                'route' => 'pages.cyber-network',
                'icon' => null,
                'order' => 6,
                'is_active' => true,
                'target' => '_self',
                'css_class' => null,
            ],
            [
                'label' => 'Web Security',
                'url' => '/cyber-web',
                'route' => 'pages.cyber-web',
                'icon' => null,
                'order' => 7,
                'is_active' => true,
                'target' => '_self',
                'css_class' => null,
            ],
            [
                'label' => 'Get Certified',
                'url' => '/get-certified',
                'route' => 'pages.get-certified',
                'icon' => 'fa-solid fa-cart-shopping',
                'order' => 8,
                'is_active' => true,
                'target' => '_self',
                'css_class' => 'nav-certified',
            ],
        ];

        foreach ($items as $item) {
            NavbarItem::firstOrCreate(
                ['route' => $item['route']],
                $item
            );
        }

        $this->command->info('Navbar items seeded successfully!');
    }
}
