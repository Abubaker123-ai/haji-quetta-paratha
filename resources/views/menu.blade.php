@extends('layouts.app')

@section('title', 'Menu — Haji Quetta Paratha')
@section('description', 'Full menu of Haji Quetta Paratha — Parathas, Chai, Lassi & More.')

@section('content')

  <!-- MENU HERO -->
  <div class="menu-hero">
    <div style="max-width:600px; margin:0 auto;">
      <span class="section-tag" style="animation:fadeInDown 0.6s ease both;">Our Menu</span>
      <h1 class="hero-title" style="animation:fadeInUp 0.7s ease 0.1s both; margin-bottom:1rem;">
        Every Bite, A<br><span class="gradient-text">Golden Memory</span>
      </h1>
      <p style="color:var(--text-secondary); font-size:1rem; line-height:1.7; animation:fadeInUp 0.7s ease 0.25s both;">
        Handcrafted parathas, soul-warming chai, and refreshing lassi —
        made fresh on order, delivered hot to your door.
      </p>
    </div>
  </div>

  <!-- MENU SECTION -->
  <section class="menu-section">
    <div class="menu-container">

      <!-- Tabs -->
      <div class="menu-tabs">
        <button class="menu-tab active" data-tab="parathas">🫓 Parathas</button>
        <button class="menu-tab" data-tab="drinks">☕ Chai & Drinks</button>
        <button class="menu-tab" data-tab="extras">🍳 Extras</button>
      </div>

      <!-- PARATHAS -->
      <div class="menu-category active" id="parathas">
        <div class="category-header">
          <div class="category-title">🫓 Parathas</div>
          <div class="category-subtitle">Fresh, hot & made to order</div>
        </div>
        <div class="menu-grid">
          <div class="menu-card visible"><div class="mc-icon-wrap mc-green">🫓</div><div class="mc-body"><div class="mc-name">Plain Paratha</div><div class="mc-desc">Classic desi ghee paratha — crispy outside, soft inside.</div><div class="mc-footer"><span class="mc-price">Rs. 90</span><a href="{{ route('order') }}" class="mc-order-btn mc-btn-green">Order →</a></div></div></div>
          <div class="menu-card visible"><div class="mc-icon-wrap mc-green">🥞</div><div class="mc-body"><div class="mc-name">Lacha Paratha <span class="mc-tag">2 Sizes</span></div><div class="mc-desc">Multi-layered flaky paratha — each bite reveals another golden crispy layer.</div><div class="mc-footer"><span class="mc-price">Rs. 90 <small>/ 130</small></span><a href="{{ route('order') }}" class="mc-order-btn mc-btn-green">Order →</a></div></div></div>
          <div class="menu-card visible"><div class="mc-icon-wrap mc-green"><div class="mc-badge-popular">⭐ Popular</div>✨</div><div class="mc-body"><div class="mc-name">Special Lacha Paratha</div><div class="mc-desc">Our signature — extra crispy golden layers with a rich desi ghee finish.</div><div class="mc-footer"><span class="mc-price">Rs. 180</span><a href="{{ route('order') }}" class="mc-order-btn mc-btn-green">Order →</a></div></div></div>
          <div class="menu-card visible"><div class="mc-icon-wrap mc-green">🧀</div><div class="mc-body"><div class="mc-name">Cheese Paratha</div><div class="mc-desc">Melted cheese stuffed inside golden crispy layers — stretchy, gooey, delicious.</div><div class="mc-footer"><span class="mc-price">Rs. 130</span><a href="{{ route('order') }}" class="mc-order-btn mc-btn-green">Order →</a></div></div></div>
          <div class="menu-card visible"><div class="mc-icon-wrap mc-green">🥔</div><div class="mc-body"><div class="mc-name">Aloo Paratha</div><div class="mc-desc">Spiced mashed potato filling inside a crispy paratha — a desi classic done right.</div><div class="mc-footer"><span class="mc-price">Rs. 90</span><a href="{{ route('order') }}" class="mc-order-btn mc-btn-green">Order →</a></div></div></div>
          <div class="menu-card visible"><div class="mc-icon-wrap mc-green">🍳</div><div class="mc-body"><div class="mc-name">Anda Paratha</div><div class="mc-desc">Fresh egg cooked and folded inside a hot crispy paratha — wholesome & filling.</div><div class="mc-footer"><span class="mc-price">Rs. 100</span><a href="{{ route('order') }}" class="mc-order-btn mc-btn-green">Order →</a></div></div></div>
          <div class="menu-card visible"><div class="mc-icon-wrap mc-green">🍳</div><div class="mc-body"><div class="mc-name">Omelette Paratha</div><div class="mc-desc">Fluffy spiced omelette wrapped inside a crispy hot paratha — a full breakfast.</div><div class="mc-footer"><span class="mc-price">Rs. 100</span><a href="{{ route('order') }}" class="mc-order-btn mc-btn-green">Order →</a></div></div></div>
        </div>
      </div>

      <!-- DRINKS -->
      <div class="menu-category" id="drinks">
        <div class="category-header">
          <div class="category-title">☕ Chai & Drinks</div>
          <div class="category-subtitle">Hot brews & cold refreshments</div>
        </div>
        <div class="menu-grid">
          <div class="menu-card"><div class="mc-icon-wrap mc-amber">🍵</div><div class="mc-body"><div class="mc-name">Chai</div><div class="mc-desc">Classic Pakistani chai — perfectly brewed with just the right balance of milk and tea.</div><div class="mc-footer"><span class="mc-price mc-price-amber">Rs. 50</span><a href="{{ route('order') }}" class="mc-order-btn mc-btn-amber">Order →</a></div></div></div>
          <div class="menu-card"><div class="mc-icon-wrap mc-amber"><div class="mc-badge-hot">🔥 Strong</div>☕</div><div class="mc-body"><div class="mc-name">Karak Chai</div><div class="mc-desc">Strong, bold and extra creamy — brewed hard for those who take their chai seriously.</div><div class="mc-footer"><span class="mc-price mc-price-amber">Rs. 90</span><a href="{{ route('order') }}" class="mc-order-btn mc-btn-amber">Order →</a></div></div></div>
          <div class="menu-card"><div class="mc-icon-wrap mc-amber">🥛</div><div class="mc-body"><div class="mc-name">Doodh Pati</div><div class="mc-desc">All-milk tea — rich, creamy and comforting. No water, just pure milk goodness.</div><div class="mc-footer"><span class="mc-price mc-price-amber">Rs. 90</span><a href="{{ route('order') }}" class="mc-order-btn mc-btn-amber">Order →</a></div></div></div>
          <div class="menu-card"><div class="mc-icon-wrap mc-amber">🥤</div><div class="mc-body"><div class="mc-name">Lassi <span class="mc-tag">350ml</span></div><div class="mc-desc">Fresh yogurt lassi, sweet or salted — thick, creamy and refreshing.</div><div class="mc-footer"><span class="mc-price mc-price-amber">Rs. 70</span><a href="{{ route('order') }}" class="mc-order-btn mc-btn-amber">Order →</a></div></div></div>
          <div class="menu-card"><div class="mc-icon-wrap mc-amber">🥤</div><div class="mc-body"><div class="mc-name">Lassi <span class="mc-tag">500ml</span></div><div class="mc-desc">Medium serving — extra thick yogurt lassi for a truly refreshing experience.</div><div class="mc-footer"><span class="mc-price mc-price-amber">Rs. 120</span><a href="{{ route('order') }}" class="mc-order-btn mc-btn-amber">Order →</a></div></div></div>
          <div class="menu-card"><div class="mc-icon-wrap mc-amber"><div class="mc-badge-hot">👨‍👩‍👧 Family</div>🫙</div><div class="mc-body"><div class="mc-name">Lassi <span class="mc-tag">1.5L</span></div><div class="mc-desc">Family size jug — perfect for sharing at the table. Rich, thick and satisfying.</div><div class="mc-footer"><span class="mc-price mc-price-amber">Rs. 220</span><a href="{{ route('order') }}" class="mc-order-btn mc-btn-amber">Order →</a></div></div></div>
          <div class="menu-card"><div class="mc-icon-wrap mc-amber">🥫</div><div class="mc-body"><div class="mc-name">Cold Drink</div><div class="mc-desc">Chilled bottled beverage — the perfect accompaniment to a hot crispy paratha.</div><div class="mc-footer"><span class="mc-price mc-price-amber">Rs. 120</span><a href="{{ route('order') }}" class="mc-order-btn mc-btn-amber">Order →</a></div></div></div>
        </div>
      </div>

      <!-- EXTRAS -->
      <div class="menu-category" id="extras">
        <div class="category-header">
          <div class="category-title">🍳 Extras</div>
          <div class="category-subtitle">Perfect side items for your meal</div>
        </div>
        <div class="menu-grid">
          <div class="menu-card"><div class="mc-icon-wrap mc-orange">🍳</div><div class="mc-body"><div class="mc-name">Omelette</div><div class="mc-desc">Fluffy fresh egg omelette — light, golden and made to order right on the tawa.</div><div class="mc-footer"><span class="mc-price mc-price-orange">Rs. 70</span><a href="{{ route('order') }}" class="mc-order-btn mc-btn-orange">Order →</a></div></div></div>
          <div class="menu-card"><div class="mc-icon-wrap mc-orange"><div class="mc-badge-popular">⭐ Special</div>🥚</div><div class="mc-body"><div class="mc-name">Special Omelette</div><div class="mc-desc">Double egg with extra masala, green chilli and onion — bold, spicy and filling.</div><div class="mc-footer"><span class="mc-price mc-price-orange">Rs. 180</span><a href="{{ route('order') }}" class="mc-order-btn mc-btn-orange">Order →</a></div></div></div>
        </div>
      </div>

      <!-- Order CTA -->
      <div style="text-align:center; margin-top:3.5rem;">
        <p style="color:var(--text-mid); margin-bottom:1.5rem; font-size:0.92rem; font-weight:500;">Bhook lagi? Abhi order karein!</p>
        <div style="display:flex; gap:1rem; justify-content:center; flex-wrap:wrap;">
          <a href="{{ route('order') }}" class="btn btn-crimson">Order Now →</a>
          <a href="https://wa.me/923127882163" target="_blank" class="btn btn-gold">WhatsApp Order</a>
        </div>
      </div>

    </div>
  </section>

@endsection