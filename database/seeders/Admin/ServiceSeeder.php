<?php

namespace Database\Seeders\Admin;

use App\Enums\Status;
use Illuminate\Database\Seeder;

class ServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\Service::create([
            'name' => 'Wellness Exams',
            'description' => 'Routine check-ups to assess your pet\'s overall health, including vaccinations, parasite prevention, and screening for common health issues.',
            'min_price' => 100,
            'max_price' => 200,
            'status' => Status::Active
        ]);

        \App\Models\Service::create([
            'name' => 'Vaccinations',
            'description' => 'Administering vaccines to protect pets from common infectious diseases, such as rabies, distemper, parvovirus, and kennel cough.',
            'min_price' => 100,
            'max_price' => 200,
            'status' => Status::Active
        ]);

        \App\Models\Service::create([
            'name' => 'Diagnostic Testing',
            'description' => 'Various tests like blood work, urinalysis, and imaging (X-rays, ultrasounds) to diagnose illnesses or monitor ongoing health conditions.',
            'min_price' => 100,
            'max_price' => 200,
            'status' => Status::Active
        ]);

        \App\Models\Service::create([
            'name' => 'Surgery',
            'description' => 'Performing routine surgeries such as spaying, neutering, dental procedures, tumor removal, and orthopedic surgeries.',
            'min_price' => 100,
            'max_price' => 200,
            'status' => Status::Active
        ]);

        \App\Models\Service::create([
            'name' => 'Emergency Care',
            'description' => 'Providing emergency medical care for pets during critical situations such as accidents, poisoning, or sudden illness.',
            'min_price' => 100,
            'max_price' => 200,
            'status' => Status::Active
        ]);

        \App\Models\Service::create([
            'name' => 'Dental Care',
            'description' => 'Dental exams, cleanings, and treatments for maintaining your pet\'s oral health and preventing dental diseases.',
            'min_price' => 100,
            'max_price' => 200,
            'status' => Status::Active
        ]);

        \App\Models\Service::create([
            'name' => 'Nutritional Counseling',
            'description' => 'Advising on proper pet nutrition, including recommending specific diets or supplements based on your pet\'s age, breed, and health needs.',
            'min_price' => 100,
            'max_price' => 200,
            'status' => Status::Active
        ]);

        \App\Models\Service::create([
            'name' => 'Behavioral Counseling',
            'description' => 'Offering guidance and support to address behavior problems in pets, including issues like aggression, anxiety, or inappropriate elimination.',
            'min_price' => 100,
            'max_price' => 200,
            'status' => Status::Active
        ]);

        \App\Models\Service::create([
            'name' => 'Grooming',
            'description' => 'Services such as bathing, hair trimming, nail trimming, and anal gland expression to maintain your pet\'s hygiene and appearance.',
            'min_price' => 100,
            'max_price' => 200,
            'status' => Status::Active
        ]);

        \App\Models\Service::create([
            'name' => 'Boarding and Daycare',
            'description' => 'Providing facilities for pet boarding or daycare services, including supervised playtime, feeding, and accommodation for overnight stays.',
            'min_price' => 100,
            'max_price' => 200,
            'status' => Status::Active
        ]);

        \App\Models\Service::create([
            'name' => 'Microchipping',
            'description' => 'Implanting microchips for permanent identification of pets, which can help reunite lost pets with their owners.',
            'min_price' => 100,
            'max_price' => 200,
            'status' => Status::Active
        ]);

        \App\Models\Service::create([
            'name' => 'End-of-Life Care',
            'description' => 'Compassionate care and support for pets nearing the end of their lives, including pain management, hospice care, and euthanasia services.',
            'min_price' => 100,
            'max_price' => 200,
            'status' => Status::Active
        ]);
    }
}
