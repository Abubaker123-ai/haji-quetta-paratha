<?php

namespace Database\Seeders;

use App\Models\MenuItem;
use Illuminate\Database\Seeder;

class MenuItemSeeder extends Seeder
{
    public function run(): void
    {
        // Real menu from website — 16 items total
        $items = [
            // Parathas (7)
            ['p1',  'Plain Paratha',          'Classic desi ghee paratha — crispy outside, soft inside.',                                  90,  'Parathas', '🫓', 'https://images.unsplash.com/photo-1626776876729-bab4369a5a5a?w=600&q=80', 1],
            ['p2',  'Lacha Paratha',          'Multi-layered flaky paratha — each bite reveals another golden crispy layer.',             90,  'Parathas', '🥞', 'https://images.unsplash.com/photo-1631452180519-c014fe946bc7?w=600&q=80', 2],
            ['p3',  'Lacha Paratha (Large)',  'Larger size of our signature multi-layered flaky paratha.',                                 130, 'Parathas', '🥞', 'https://images.unsplash.com/photo-1631452180519-c014fe946bc7?w=600&q=80', 3],
            ['p4',  'Special Lacha Paratha',  'Our signature — extra crispy golden layers with a rich desi ghee finish.',                  180, 'Parathas', '✨', 'https://images.unsplash.com/photo-1601050690597-df0568f70950?w=600&q=80', 4],
            ['p5',  'Cheese Paratha',         'Melted cheese stuffed inside golden crispy layers — stretchy, gooey, delicious.',           130, 'Parathas', '🧀', 'https://images.unsplash.com/photo-1585032226651-759b368d7246?w=600&q=80', 5],
            ['p6',  'Aloo Paratha',           'Spiced mashed potato filling inside a crispy paratha — a desi classic done right.',         90,  'Parathas', '🥔', 'https://images.unsplash.com/photo-1626776876729-bab4369a5a5a?w=600&q=80', 6],
            ['p7',  'Anda Paratha',           'Fresh egg cooked and folded inside a hot crispy paratha — wholesome and filling.',          100, 'Parathas', '🍳', 'https://images.unsplash.com/photo-1525351484163-7529414344d8?w=600&q=80', 7],
            ['p8',  'Omelette Paratha',       'Fluffy spiced omelette wrapped inside a crispy hot paratha — a full breakfast.',            100, 'Parathas', '🍳', 'https://images.unsplash.com/photo-1565557623262-b51c2513a641?w=600&q=80', 8],

            // Drinks (7)
            ['d1',  'Chai',                   'Classic Pakistani chai — perfectly brewed with the right balance of milk and tea.',         50,  'Drinks',   '🍵', 'https://images.unsplash.com/photo-1571934811356-5cc061b6821f?w=600&q=80', 9],
            ['d2',  'Karak Chai',             'Strong, bold and extra creamy — brewed hard for those who take chai seriously.',            90,  'Drinks',   '☕', 'https://images.unsplash.com/photo-1571934811356-5cc061b6821f?w=600&q=80', 10],
            ['d3',  'Doodh Pati',             'All-milk tea — rich, creamy and comforting. No water, just pure milk goodness.',            90,  'Drinks',   '🥛', 'https://images.unsplash.com/photo-1571934811356-5cc061b6821f?w=600&q=80', 11],
            ['d4',  'Lassi (350ml)',          'Fresh yogurt lassi, sweet or salted — thick, creamy and refreshing.',                       70,  'Drinks',   '🥤', 'https://images.unsplash.com/photo-1626078299034-94c92c1eccc4?w=600&q=80', 12],
            ['d5',  'Lassi (500ml)',          'Medium serving — extra thick yogurt lassi for a truly refreshing experience.',              120, 'Drinks',   '🥤', 'https://images.unsplash.com/photo-1626078299034-94c92c1eccc4?w=600&q=80', 13],
            ['d6',  'Lassi (1.5L Family)',    'Family size jug — perfect for sharing at the table. Rich, thick and satisfying.',           220, 'Drinks',   '🫙', 'https://images.unsplash.com/photo-1626078299034-94c92c1eccc4?w=600&q=80', 14],
            ['d7',  'Cold Drink',             'Chilled bottled beverage — the perfect accompaniment to a hot crispy paratha.',             120, 'Drinks',   '🥫', 'https://images.unsplash.com/photo-1581636625402-29b2a704ef13?w=600&q=80', 15],

            // Extras (2)
            ['e1',  'Omelette',               'Fluffy fresh egg omelette — light, golden and made to order right on the tawa.',            70,  'Extras',   '🍳', 'https://images.unsplash.com/photo-1525351484163-7529414344d8?w=600&q=80', 16],
            ['e2',  'Special Omelette',       'Double egg with extra masala, green chilli and onion — bold, spicy and filling.',           180, 'Extras',   '🥚', 'https://images.unsplash.com/photo-1565557623262-b51c2513a641?w=600&q=80', 17],
        ];

        foreach ($items as [$id, $name, $desc, $price, $cat, $emoji, $img, $sort]) {
            MenuItem::updateOrCreate(
                ['item_id' => $id],
                [
                    'name'        => $name,
                    'description' => $desc,
                    'price'       => $price,
                    'category'    => $cat,
                    'emoji'       => $emoji,
                    'image_url'   => $img,
                    'available'   => true,
                    'sort_order'  => $sort,
                ]
            );
        }
    }
}
