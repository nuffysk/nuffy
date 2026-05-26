<?php

namespace Database\Seeders;

use App\Models\LearnTopic;
use Illuminate\Database\Seeder;

class LearnTopicsSeeder extends Seeder
{
    public function run(): void
    {
        $topics = [
            ['slug' => 'cestovanie-so-psom', 'title' => 'Cestovanie so psom', 'summary' => 'Ako si pripraviť psíka na cestu autom, vlakom alebo lietadlom.', 'sort_order' => 10],
            ['slug' => 'kliesste', 'title' => 'Kliešte', 'summary' => 'Prečo sú nebezpečné a ako ich správne odstrániť.', 'sort_order' => 20],
            ['slug' => 'darovanie-krvi', 'title' => 'Darovanie krvi', 'summary' => 'Aj pes môže byť darca. Komu pomáha a kedy je vhodný.', 'sort_order' => 30],
            ['slug' => 'giardie', 'title' => 'Giardie', 'summary' => 'Tichý parazit a ako mu predchádzať.', 'sort_order' => 40],
            ['slug' => 'intoxikacia-vodou', 'title' => 'Intoxikácia vodou', 'summary' => 'Hrozba, ktorú podceňujeme — vodná otrava psíka.', 'sort_order' => 50],
            ['slug' => 'labky-v-lete', 'title' => 'Labky v lete', 'summary' => 'Ako predchádzať popáleninám z horúceho asfaltu.', 'sort_order' => 60],
            ['slug' => 'mnoziarne', 'title' => 'Množiarne', 'summary' => 'Prečo nekupovať šteňatá z neznámych zdrojov.', 'sort_order' => 70],
            ['slug' => 'osiny', 'title' => 'Osiny', 'summary' => 'Drobné semienka, veľký problém. Ako ich rozpoznať.', 'sort_order' => 80],
            ['slug' => 'psoviny', 'title' => 'Psoviny', 'summary' => 'Bežné mýty a fakty o psíkoch.', 'sort_order' => 90],
        ];

        foreach ($topics as $t) {
            LearnTopic::updateOrCreate(
                ['slug' => $t['slug']],
                array_merge($t, [
                    'thumbnail_url' => '/img/learn/' . $t['slug'] . '.jpg',
                    'photos' => [],
                ])
            );
        }
    }
}
