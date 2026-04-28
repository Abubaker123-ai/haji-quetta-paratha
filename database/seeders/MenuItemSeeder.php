<?php

namespace Database\Seeders;

use App\Models\MenuItem;
use Illuminate\Database\Seeder;

class MenuItemSeeder extends Seeder
{
    // Image base URL — files are committed to public/images/menu/
    private const IMG = 'https://web-production-25b7b.up.railway.app/images/menu/';

    public function run(): void
    {
        $img = self::IMG;

        $items = [
            // Parathas
            ['p1', 'Plain Paratha',         'Classic desi ghee paratha — crispy outside, soft inside.',                                 90,  'Parathas', "\u{1F959}", "{$img}p1.jpg", 1],
            ['p4', 'Special Lacha Paratha', 'Our signature — extra crispy golden layers with a rich desi ghee finish.',                 180, 'Parathas', "\u{1F959}", "{$img}p4.jpg", 2],
            ['p5', 'Cheese Paratha',        'Melted cheese stuffed inside golden crispy layers — stretchy, gooey, delicious.',          130, 'Parathas', "\u{1F9C0}", "{$img}p5.jpg", 5],
            ['p6', 'Aloo Paratha',          'Spiced mashed potato filling inside a crispy paratha — a desi classic done right.',        90,  'Parathas', "\u{1F954}", "{$img}p6.jpg", 6],
            ['p7', 'Anda Paratha',          'Fresh egg cooked and folded inside a hot crispy paratha — wholesome and filling.',         100, 'Parathas', "\u{1F373}", "{$img}p7.jpg", 7],
            ['p8', 'Omelette Paratha',      'Fluffy spiced omelette wrapped inside a crispy hot paratha — a full breakfast.',           100, 'Parathas', "\u{1F373}", "{$img}p8.jpg", 8],

            // Drinks (NO Lassi — removed per owner instruction)
            ['d1', 'Chai',       'Classic Pakistani chai — perfectly brewed with the right balance of milk and tea.',                   50,  'Drinks', "\u{2615}",  "{$img}d1.jpg", 9],
            ['d2', 'Karak Chai', 'Strong, bold and extra creamy — brewed hard for those who take chai seriously.',                      90,  'Drinks', "\u{2615}",  "{$img}d2.jpg", 10],
            ['d3', 'Doodh Pati', 'All-milk tea — rich, creamy and comforting. No water, just pure milk goodness.',                     90,  'Drinks', "\u{1F95B}", "{$img}d3.jpg", 11],
            ['d7', 'Cold Drink', 'Chilled bottled beverage — the perfect accompaniment to a hot crispy paratha.',                      120, 'Drinks', "\u{1F964}", "{$img}d7.jpg", 12],

            // Extras
            ['e1', 'Omelette',         'Fluffy fresh egg omelette — light, golden and made to order right on the tawa.',               70,  'Extras', "\u{1F373}", "{$img}e1.jpg", 13],
            ['e2', 'Special Omelette', 'Double egg with extra masala, green chilli and onion — bold, spicy and filling.',              180, 'Extras', "\u{1F373}", "{$img}e2.jpg", 14],
        ];

        foreach ($items as [$id, $name, $desc, $price, $cat, $emoji, $imgUrl, $sort]) {
            MenuItem::updateOrCreate(
                ['item_id' => $id],
                [
                    'name'        => $name,
                    'description' => $desc,
                    'price'       => $price,
                    'category'    => $cat,
                    'emoji'       => $emoji,
                    'image_url'   => $imgUrl,
                    'available'   => true,
                    'sort_order'  => $sort,
                ]
            );
        }

        // Hard-delete removed items
        MenuItem::whereIn('item_id', ['d4', 'd5', 'd6', 'p2', 'p3'])->delete();
    }
}
