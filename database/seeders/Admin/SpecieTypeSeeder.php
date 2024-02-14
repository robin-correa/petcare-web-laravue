<?php

namespace Database\Seeders\Admin;

use App\Enums\Status;
use Illuminate\Database\Seeder;

class SpecieTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\SpecieType::create([
            'name' => 'Dogs',
            'description' => 'Dogs are one of the most common pets globally and are frequently seen in pet clinics for routine check-ups, vaccinations, grooming, and treatment of various health conditions.',
            'status' => Status::Active
        ]);

        \App\Models\SpecieType::create([
            'name' => 'Cats',
            'description' => 'Cats are another popular pet species and often require veterinary care for vaccinations, spaying/neutering, dental care, and treatment of illnesses.',
            'status' => Status::Active
        ]);

        \App\Models\SpecieType::create([
            'name' => 'Birds',
            'description' => 'This category includes various species of pet birds such as parrots, budgerigars, cockatiels, canaries, and finches. They may require veterinary care for wellness exams, beak and nail trimming, nutritional counseling, and treatment of infections or injuries.',
            'status' => Status::Active
        ]);

        \App\Models\SpecieType::create([
            'name' => 'Small Mammals',
            'description' => 'This group encompasses small mammalian pets such as rabbits, guinea pigs, hamsters, gerbils, mice, and rats. They may need veterinary attention for dental issues, gastrointestinal problems, skin conditions, and routine check-ups.',
            'status' => Status::Active
        ]);

        \App\Models\SpecieType::create([
            'name' => 'Fish',
            'description' => 'While fish are less likely to visit a traditional pet clinic, aquarium enthusiasts may seek veterinary advice for diseases, water quality issues, parasite control, and advice on fish health and nutrition.',
            'status' => Status::Active
        ]);

        \App\Models\SpecieType::create([
            'name' => 'Exotic Pets',
            'description' => 'This category includes less common pets such as ferrets, hedgehogs, sugar gliders, chinchillas, and various species of invertebrates (e.g., tarantulas, scorpions). They may have specific health and husbandry requirements that necessitate veterinary care.',
            'status' => Status::Active
        ]);

        \App\Models\SpecieType::create([
            'name' => 'Farm Animals',
            'description' => 'In some cases, pet clinics may also provide services for farm animals kept as pets, such as miniature pigs, goats, chickens, and ducks. These animals may require care for injuries, reproductive issues, nutritional disorders, and parasitic infections.',
            'status' => Status::Active
        ]);

        \App\Models\SpecieType::create([
            'name' => 'Rabbits',
            'description' => 'Rabbits are popular small mammals kept as pets for their social nature and low maintenance. They may need veterinary attention for dental issues (malocclusion), gastrointestinal stasis, respiratory infections, spaying/neutering, and treatment of external parasites (mites, fleas).',
            'status' => Status::Active
        ]);

        \App\Models\SpecieType::create([
            'name' => 'Guinea Pigs',
            'description' => 'Guinea pigs are gentle and sociable rodents commonly kept as pets, especially by children. They may require veterinary care for dental problems (overgrowth, malocclusion), respiratory infections, urinary tract issues, skin conditions, and nutritional deficiencies.',
            'status' => Status::Active
        ]);

        \App\Models\SpecieType::create([
            'name' => 'Hamsters',
            'description' => 'Hamsters are small rodents popular as pets due to their size and ease of care. They may need veterinary attention for dental issues, gastrointestinal problems (wet tail), respiratory infections, skin tumors, and management of obesity.',
            'status' => Status::Active
        ]);

        \App\Models\SpecieType::create([
            'name' => 'Amphibians',
            'description' => 'Amphibians like frogs, toads, salamanders, and newts are sometimes kept as pets in terrariums. Owners may require veterinary guidance for providing appropriate environmental conditions, preventing infections, and addressing metabolic bone disease.',
            'status' => Status::Active
        ]);

        \App\Models\SpecieType::create([
            'name' => 'Gerbils',
            'description' => 'Gerbils are active and curious rodents kept as pets for their entertaining behavior. They may require veterinary care for dental problems, seizure disorders, gastrointestinal issues (intestinal parasites, diarrhea), and skin conditions.',
            'status' => Status::Active
        ]);
    }
}
