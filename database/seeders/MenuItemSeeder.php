<?php

namespace Database\Seeders;

use App\Models\MenuItem;
use Illuminate\Database\Seeder;

class MenuItemSeeder extends Seeder
{
    public function run(): void
    {
        $items = [
            // Parathas
            ['p1', 'Plain Paratha', 'Crispy, buttery plain paratha fresh off the tawa', 40, 'Parathas', '🫓', 'https://images.unsplash.com/photo-1626776876729-bab4369a5a5a?w=600', 1],
            ['p2', 'Butter Paratha', 'Layered paratha with generous fresh butter', 60, 'Parathas', '🧈', 'https://images.unsplash.com/photo-1601050690597-df0568f70950?w=600', 2],
            ['p3', 'Aloo Paratha', 'Stuffed with spiced mashed potatoes, served with yogurt', 80, 'Parathas', '🥔', 'https://images.unsplash.com/photo-1626776876729-bab4369a5a5a?w=600', 3],
            ['p4', 'Egg Paratha', 'Paratha with fresh egg cooked inside, crispy edges', 90, 'Parathas', '🍳', 'https://images.unsplash.com/photo-1565299543923-37dd37887442?w=600', 4],
            ['p5', 'Yogurt Paratha', 'Soft paratha served with chilled fresh yogurt', 80, 'Parathas', '🥛', 'https://images.unsplash.com/photo-1601050690597-df0568f70950?w=600', 5],
            ['p6', 'Cheese Paratha', 'Stuffed with melted cheese, golden and crispy', 120, 'Parathas', '🧀', 'https://images.unsplash.com/photo-1626776876729-bab4369a5a5a?w=600', 6],
            ['p7', 'Keema Paratha', 'Filled with spiced minced meat, full of flavor', 140, 'Parathas', '🥩', 'https://images.unsplash.com/photo-1574484284002-952d92456975?w=600', 7],
            ['p8', 'Mix Paratha', 'Aloo + Keema + Egg combination — our best seller!', 160, 'Parathas', '⭐', 'https://images.unsplash.com/photo-1626776876729-bab4369a5a5a?w=600', 8],

            // Drinks
            ['d1', 'Milk Tea', 'Classic Pakistani milk tea, perfectly brewed', 50, 'Drinks', '☕', 'https://images.unsplash.com/photo-1571934811356-5cc061b6821f?w=600', 9],
            ['d2', 'Karak Chai', 'Strong, aromatic tea with cardamom and ginger', 60, 'Drinks', '🍵', 'https://images.unsplash.com/photo-1571934811356-5cc061b6821f?w=600', 10],
            ['d3', 'Sweet Lassi', 'Thick, creamy sweet yogurt drink — Quetta style', 80, 'Drinks', '🥤', 'https://images.unsplash.com/photo-1626078299034-94c92c1eccc4?w=600', 11],
            ['d4', 'Salted Lassi', 'Refreshing salted lassi with a hint of cumin', 80, 'Drinks', '🥛', 'https://images.unsplash.com/photo-1626078299034-94c92c1eccc4?w=600', 12],
            ['d5', 'Fresh Milk', 'Pure, fresh milk served warm or cold', 70, 'Drinks', '🍼', 'https://images.unsplash.com/photo-1550583724-b2692b85b150?w=600', 13],

            // Extras
            ['e1', 'Pickle', 'Homemade spicy mixed pickle', 20, 'Extras', '🌶️', 'https://images.unsplash.com/photo-1599909366516-6c1f5e5f88c8?w=600', 14],
            ['e2', 'Raita', 'Fresh yogurt with cucumber and mint', 40, 'Extras', '🥒', 'https://images.unsplash.com/photo-1626078299034-94c92c1eccc4?w=600', 15],
            ['e3', 'Extra Butter', 'Fresh butter dollop on the side', 30, 'Extras', '🧈', 'https://images.unsplash.com/photo-1589985270826-4b7bb135bc9d?w=600', 16],
            ['e4', 'Green Chutney', 'Fresh mint and coriander chutney', 20, 'Extras', '🌿', 'https://images.unsplash.com/photo-1589985270826-4b7bb135bc9d?w=600', 17],
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
