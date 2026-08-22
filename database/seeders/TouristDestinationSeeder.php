<?php

namespace Database\Seeders;

use App\Models\DestinationMedia;
use App\Models\DestinationReview;
use App\Models\TouristDestination;
use App\Models\User;
use Illuminate\Database\Seeder;

class TouristDestinationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Find or create admin user
        $admin = User::firstOrCreate(
            ['email' => 'admin@balitours.test'],
            [
                'username' => 'admin',
                'password' => bcrypt('password'),
                'role' => 'admin',
                'status' => 'active',
            ]
        );

        // Find or create a test tourist
        $tourist = User::firstOrCreate(
            ['email' => 'tourist@balitours.test'],
            [
                'username' => 'mariasantos',
                'password' => bcrypt('password'),
                'role' => 'tourist',
                'status' => 'active',
            ]
        );

        $destinations = [
            [
                'name' => 'Kabatanga Falls & Eco-Park',
                'slug' => 'kabatanga-falls',
                'category' => 'falls_nature',
                'short_description' => 'A tranquil multi-tiered natural waterfall tucked within tropical hills, featuring cool crystal waters and picnic pavilions.',
                'description' => 'Kabatanga Falls is one of the premier eco-tourism treasures in Balingasag. Nestled in Barangay Samay, the falls feature refreshing mountain spring cascades, deep emerald natural pools suitable for swimming, and lush surrounding bamboo groves. Shaded walking paths and picnic huts are available for tourists and families.',
                'address' => 'Barangay Samay, Balingasag, Misamis Oriental',
                'city_municipality' => 'Balingasag',
                'province' => 'Misamis Oriental',
                'latitude' => 8.75580000,
                'longitude' => 124.81500000,
                'cover_image' => 'https://images.unsplash.com/photo-1500530855697-b586d89ba3ee?auto=format&fit=crop&w=1200&q=80',
                'opening_time' => '08:00:00',
                'closing_time' => '17:00:00',
                'entrance_fee' => 50.00,
                'contact_number' => '(088) 333-2140',
                'contact_email' => 'tourism@balingasag.gov.ph',
                'website_url' => 'https://balingasag.gov.ph',
                'is_published' => true,
                'gallery' => [
                    ['src' => 'https://images.unsplash.com/photo-1500530855697-b586d89ba3ee?auto=format&fit=crop&w=1000&q=80', 'title' => 'Main Cascade & Swimming Basin', 'type' => 'image'],
                    ['src' => 'https://images.unsplash.com/photo-1432821596592-e2c18b78144f?auto=format&fit=crop&w=1000&q=80', 'title' => 'Forest Canopy Trail Pathway', 'type' => 'image'],
                    ['src' => 'https://images.unsplash.com/photo-1507525428034-b723cf961d3e?auto=format&fit=crop&w=1000&q=80', 'title' => 'Lower Stream & Relaxation Nook', 'type' => 'image'],
                ],
                'reviews' => [
                    ['rating' => 5, 'title' => 'Incredible natural escape!', 'comment' => 'The road from the town center takes about 12 minutes. Very clean spring water and fresh mountain air.', 'visit_date' => '2026-08-15'],
                    ['rating' => 5, 'title' => 'Lush and relaxing', 'comment' => 'Great bamboo cottages for rent and safe swimming spots for kids.', 'visit_date' => '2026-08-10'],
                ],
            ],
            [
                'name' => 'San Roque Parish Church',
                'slug' => 'san-roque-parish-church',
                'category' => 'church_heritage',
                'short_description' => 'A century-old historic parish church showcasing Spanish-colonial stone architecture and local religious heritage.',
                'description' => 'Standing as the spiritual heart of Balingasag, San Roque Parish Church was founded in the late 19th century. Its distinctive facade, preserved bell tower, and calm interior make it a must-visit for heritage enthusiasts and pilgrims alike.',
                'address' => 'Poblacion, Balingasag, Misamis Oriental',
                'city_municipality' => 'Balingasag',
                'province' => 'Misamis Oriental',
                'latitude' => 8.74600000,
                'longitude' => 124.77500000,
                'cover_image' => 'https://images.unsplash.com/photo-1541647373274-0ec5ec55dc20?auto=format&fit=crop&w=1200&q=80',
                'opening_time' => '06:00:00',
                'closing_time' => '19:00:00',
                'entrance_fee' => 0.00,
                'contact_number' => '(088) 333-2001',
                'contact_email' => 'sanroque@balingasag.ph',
                'website_url' => null,
                'is_published' => true,
                'gallery' => [
                    ['src' => 'https://images.unsplash.com/photo-1541647373274-0ec5ec55dc20?auto=format&fit=crop&w=1000&q=80', 'title' => 'Historic Bell Tower & Facade', 'type' => 'image'],
                ],
                'reviews' => [
                    ['rating' => 5, 'title' => 'Solemn and beautiful', 'comment' => 'Well-maintained historical landmark with an amazing breeze from the nearby coast.', 'visit_date' => '2026-08-14'],
                ],
            ],
            [
                'name' => 'Balingasag Seaside Boulevard',
                'slug' => 'balingasag-seaside-boulevard',
                'category' => 'boulevard',
                'short_description' => 'A vibrant coastal esplanade offering panoramic Macajalar Bay sunset views, street food stalls, and ocean breeze.',
                'description' => 'The Balingasag Seaside Boulevard is the local community favorite for afternoon strolls, jogging, and watching spectacular golden sunsets over Macajalar Bay. Along the promenade, visitors can savor local delicacies, fresh coconut water, and grilled seafood.',
                'address' => 'Coastal Road, Poblacion, Balingasag, Misamis Oriental',
                'city_municipality' => 'Balingasag',
                'province' => 'Misamis Oriental',
                'latitude' => 8.73600000,
                'longitude' => 124.76800000,
                'cover_image' => 'https://images.unsplash.com/photo-1500534314209-a46b44f5e11d?auto=format&fit=crop&w=1200&q=80',
                'opening_time' => '05:00:00',
                'closing_time' => '22:00:00',
                'entrance_fee' => 0.00,
                'contact_number' => null,
                'contact_email' => null,
                'website_url' => null,
                'is_published' => true,
                'gallery' => [
                    ['src' => 'https://images.unsplash.com/photo-1500534314209-a46b44f5e11d?auto=format&fit=crop&w=1000&q=80', 'title' => 'Sunset Promenade View', 'type' => 'image'],
                ],
                'reviews' => [
                    ['rating' => 5, 'title' => 'Best sunset spot in town', 'comment' => 'Very relaxing evening spot with plenty of street food vendors and fresh sea air.', 'visit_date' => '2026-08-16'],
                ],
            ],
            [
                'name' => 'Balingasag Town Memory Square & Plaza',
                'slug' => 'balingasag-memory-square',
                'category' => 'memory_square',
                'short_description' => 'The central town memorial plaza with historical monuments, landscaped gardens, and open civic spaces.',
                'description' => 'The Balingasag Memory Square commemorates the town history and local heroes. It serves as a peaceful community square with gazebos, century-old acacia trees, illuminated water fountains, and paved walkways.',
                'address' => 'Plaza Center, Balingasag, Misamis Oriental',
                'city_municipality' => 'Balingasag',
                'province' => 'Misamis Oriental',
                'latitude' => 8.74550000,
                'longitude' => 124.77450000,
                'cover_image' => 'https://images.unsplash.com/photo-1519681393784-d120267933ba?auto=format&fit=crop&w=1200&q=80',
                'opening_time' => '06:00:00',
                'closing_time' => '21:00:00',
                'entrance_fee' => 0.00,
                'contact_number' => '(088) 333-2100',
                'contact_email' => 'admin@balingasag.gov.ph',
                'website_url' => null,
                'is_published' => true,
                'gallery' => [],
                'reviews' => [],
            ],
            [
                'name' => 'Cafe Balingasag & Pastry Lounge',
                'slug' => 'cafe-balingasag',
                'category' => 'cafe',
                'short_description' => 'Cozy artisan café serving locally-roasted Mindanao coffee beans, native delicacies, and refreshing cold drinks.',
                'description' => 'Located near the municipal center, Cafe Balingasag offers a modern rustic setting with air-conditioned seating, high-speed Wi-Fi, and a curated menu of specialty coffees, cakes, and sandwiches.',
                'address' => 'National Highway, Brgy. 4, Balingasag, Misamis Oriental',
                'city_municipality' => 'Balingasag',
                'province' => 'Misamis Oriental',
                'latitude' => 8.74300000,
                'longitude' => 124.77600000,
                'cover_image' => 'https://images.unsplash.com/photo-1501339847302-ac426a4a7cbb?auto=format&fit=crop&w=1200&q=80',
                'opening_time' => '09:00:00',
                'closing_time' => '21:00:00',
                'entrance_fee' => 0.00,
                'contact_number' => '(088) 880-9921',
                'contact_email' => 'cafebalingasag@gmail.com',
                'website_url' => null,
                'is_published' => true,
                'gallery' => [],
                'reviews' => [],
            ],
            [
                'name' => 'Balingasag Municipal Civic Gymnasium',
                'slug' => 'balingasag-civic-gym',
                'category' => 'gym',
                'short_description' => 'Public multipurpose sports complex and community fitness facility hosting sporting events and fitness activities.',
                'description' => 'The Municipal Gymnasium provides facilities for basketball, badminton, fitness workouts, and town gatherings. It is centrally located with ample parking.',
                'address' => 'Sports Complex, Balingasag, Misamis Oriental',
                'city_municipality' => 'Balingasag',
                'province' => 'Misamis Oriental',
                'latitude' => 8.74800000,
                'longitude' => 124.77300000,
                'cover_image' => 'https://images.unsplash.com/photo-1534438327276-14e5300c3a48?auto=format&fit=crop&w=1200&q=80',
                'opening_time' => '06:00:00',
                'closing_time' => '20:00:00',
                'entrance_fee' => 20.00,
                'contact_number' => '(088) 333-2188',
                'contact_email' => null,
                'website_url' => null,
                'is_published' => true,
                'gallery' => [],
                'reviews' => [],
            ],
        ];

        foreach ($destinations as $destData) {
            $gallery = $destData['gallery'] ?? [];
            $reviews = $destData['reviews'] ?? [];
            unset($destData['gallery'], $destData['reviews']);

            $destData['created_by'] = $admin->id;

            $dest = TouristDestination::updateOrCreate(
                ['slug' => $destData['slug']],
                $destData
            );

            // Seed gallery items
            foreach ($gallery as $index => $item) {
                DestinationMedia::updateOrCreate(
                    [
                        'destination_id' => $dest->id,
                        'file_path' => $item['src'],
                    ],
                    [
                        'uploaded_by' => $admin->id,
                        'type' => $item['type'] ?? 'image',
                        'source' => 'upload',
                        'title' => $item['title'],
                        'sort_order' => $index,
                    ]
                );
            }

            // Seed reviews
            foreach ($reviews as $rev) {
                DestinationReview::updateOrCreate(
                    [
                        'destination_id' => $dest->id,
                        'user_id' => $tourist->id,
                    ],
                    [
                        'rating' => $rev['rating'],
                        'title' => $rev['title'],
                        'comment' => $rev['comment'],
                        'visit_date' => $rev['visit_date'],
                    ]
                );
            }
        }
    }
}
