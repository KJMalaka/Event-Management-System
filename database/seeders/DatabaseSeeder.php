<?php

namespace Database\Seeders;

use App\Models\CategoryK;
use App\Models\EventK;
use App\Models\RegistrationK;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::create([
            'name'              => 'Admin User',
            'email'             => 'admin@eventms.local',
            'password'          => Hash::make('password'),
            'role'              => 'admin',
            'email_verified_at' => now(),
        ]);

        $organizer1 = User::create([
            'name'              => 'Alice Organizer',
            'email'             => 'alice@eventms.local',
            'password'          => Hash::make('password'),
            'role'              => 'organizer',
            'email_verified_at' => now(),
        ]);

        $organizer2 = User::create([
            'name'              => 'Bob Organizer',
            'email'             => 'bob@eventms.local',
            'password'          => Hash::make('password'),
            'role'              => 'organizer',
            'email_verified_at' => now(),
        ]);

        $attendees = User::factory(15)->create(['role' => 'attendee']);

        $categories = CategoryK::insert([
            ['name' => 'Technology', 'slug' => 'technology',  'description' => 'Tech conferences and workshops', 'color' => '#3B82F6', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Music',      'slug' => 'music',       'description' => 'Concerts and music festivals',   'color' => '#8B5CF6', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Sports',     'slug' => 'sports',      'description' => 'Sporting events and competitions','color' => '#10B981', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Education',  'slug' => 'education',   'description' => 'Educational seminars and courses','color' => '#F59E0B', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Business',   'slug' => 'business',    'description' => 'Business networking events',     'color' => '#EF4444', 'created_at' => now(), 'updated_at' => now()],
        ]);

        $categoryIds = CategoryK::pluck('id')->toArray();

        $events = collect();
        foreach ([$organizer1, $organizer2] as $organizer) {
            $created = EventK::factory(5)->create([
                'organizer_id' => $organizer->id,
                'category_id'  => fake()->randomElement($categoryIds),
                'status'       => 'published',
            ]);
            $events = $events->merge($created);
        }

        EventK::factory(3)->past()->create([
            'organizer_id' => $organizer1->id,
            'category_id'  => fake()->randomElement($categoryIds),
        ]);

        foreach ($events as $event) {
            $sampleAttendees = $attendees->random(rand(2, 8));
            foreach ($sampleAttendees as $attendee) {
                RegistrationK::create([
                    'event_id'    => $event->id,
                    'user_id'     => $attendee->id,
                    'status'      => fake()->randomElement(['pending', 'approved', 'approved']),
                    'notes'       => fake()->optional(0.3)->sentence(),
                    'approved_at' => now(),
                ]);
            }
        }
    }
}
