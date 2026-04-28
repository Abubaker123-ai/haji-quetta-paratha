<?php

namespace Database\Seeders;

use App\Models\MenuItem;
use Illuminate\Database\Seeder;

class MenuItemSeeder extends Seeder
{
    public function run(): void
    {
        $items = [
            // Parathas — all use stuffed-flatbread 🥙 (Unicode 9, universal support)
            ['p1',  'Plain Paratha',          'Classic desi ghee paratha — crispy outside, soft inside.',                                  90,  'Parathas', "\u{1F959}", null, 1],
            ['p2',  'Lacha Paratha',          'Multi-layered flaky paratha — each bite reveals another golden crispy layer.',             90,  'Parathas', "\u{1F959}", null, 2],
            ['p3',  'Lacha Paratha (Large)',  'Larger size of our signature multi-layered flaky paratha.',                                 130, 'Parathas', "\u{1F959}", null, 3],
            ['p4',  'Special Lacha Paratha',  'Our signature — extra crispy golden layers with a rich desi ghee finish.',                  180, 'Parathas', "\u{1F959}", null, 4],
            ['p5',  'Cheese Paratha',         'Melted cheese stuffed inside golden crispy layers — stretchy, gooey, delicious.',           130, 'Parathas', "\u{1F9C0}", null, 5],  // 🧀
            ['p6',  'Aloo Paratha',           'Spiced mashed potato filling inside a crispy paratha — a desi classic done right.',         90,  'Parathas', "\u{1F954}", null, 6],  // 🥔
            ['p7',  'Anda Paratha',           'Fresh egg cooked and folded inside a hot crispy paratha — wholesome and filling.',          100, 'Parathas', "\u{1F373}", null, 7],  // 🍳
            ['p8',  'Omelette Paratha',       'Fluffy spiced omelette wrapped inside a crispy hot paratha — a full breakfast.',            100, 'Parathas', "\u{1F373}", null, 8],  // 🍳

            // Drinks — ☕ for hot chai (not 🍵 green tea), 🥤 for cold/lassi
            ['d1',  'Chai',                   'Classic Pakistani chai — perfectly brewed with the right balance of milk and tea.',         50,  'Drinks',   "\u{2615}",  null, 9],   // ☕
            ['d2',  'Karak Chai',             'Strong, bold and extra creamy — brewed hard for those who take chai seriously.',            90,  'Drinks',   "\u{2615}",  null, 10],  // ☕
            ['d3',  'Doodh Pati',             'All-milk tea — rich, creamy and comforting. No water, just pure milk goodness.',            90,  'Drinks',   "\u{1F95B}", null, 11],  // 🥛
            ['d4',  'Lassi (350ml)',          'Fresh yogurt lassi, sweet or salted — thick, creamy and refreshing.',                       70,  'Drinks',   "\u{1F964}", null, 12],  // 🥤
            ['d5',  'Lassi (500ml)',          'Medium serving — extra thick yogurt lassi for a truly refreshing experience.',              120, 'Drinks',   "\u{1F964}", null, 13],  // 🥤
            ['d6',  'Lassi (1.5L Family)',    'Family size jug — perfect for sharing at the table. Rich, thick and satisfying.',           220, 'Drinks',   "\u{1F964}", null, 14],  // 🥤 (was 🫙 Unicode 14 — not supported on older Android)
            ['d7',  'Cold Drink',             'Chilled bottled beverage — the perfect accompaniment to a hot crispy paratha.',             120, 'Drinks',   "\u{1F964}", null, 15],  // 🥤 (was 🥫 can — wrong)

            // Extras
            ['e1',  'Omelette',               'Fluffy fresh egg omelette — light, golden and made to order right on the tawa.',            70,  'Extras',   "\u{1F373}", null, 16],  // 🍳
            ['e2',  'Special Omelette',       'Double egg with extra masala, green chilli and onion — bold, spicy and filling.',           180, 'Extras',   "\u{1F373}", null, 17],  // 🍳 (was 🥚 egg — pan better)
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
