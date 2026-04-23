@extends('layouts.app')

@section('title', 'Haji Quetta Paratha — Authentic Taste Since Decades')
@section('description', 'Haji Quetta Paratha — Crispy Layers, Golden Perfection. Free Delivery in New Lahore City.')

@section('content')

  <!-- HERO -->
  <section class="hero">
    <div class="hero-container">
      <div class="hero-content">
        <div class="hero-badge"><span class="dot"></span> Free Delivery Available</div>
        <h1 class="hero-title">
          The Authentic<br>
          Taste of <span class="gradient-text">Quetta</span><br>
          in Lahore
        </h1>
        <p class="hero-subtitle">
          Crispy Layers, Golden Perfection. Every paratha handcrafted
          with generations of tradition — from our tawa to your table,
          fresh and flavorful, every single time.
        </p>
        <div class="hero-buttons">
          <a href="{{ route('menu') }}" class="btn btn-gold">View Our Menu</a>
          <a href="{{ route('order') }}" class="btn btn-outline">Order Now →</a>
        </div>
      </div>

      <div class="hero-visual">
        <div class="hero-card">
          <div class="food-emoji-grid">
            <div class="food-emoji-item"><span class="emoji">🫓</span><span class="name">Lacha Paratha</span></div>
            <div class="food-emoji-item"><span class="emoji">🧀</span><span class="name">Cheese Paratha</span></div>
            <div class="food-emoji-item"><span class="emoji">🥚</span><span class="name">Egg Paratha</span></div>
            <div class="food-emoji-item"><span class="emoji">🍵</span><span class="name">Karak Chai</span></div>
            <div class="food-emoji-item"><span class="emoji">🥛</span><span class="name">Doodh Pati</span></div>
            <div class="food-emoji-item"><span class="emoji">🥤</span><span class="name">Fresh Lassi</span></div>
          </div>
          <div class="hero-info-box">
            <span class="icon">📍</span>
            <div class="text">
              <strong>Shop #1, A17 — Main Boulevard</strong>
              New Lahore City · Open Daily
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="scroll-indicator">
      <div class="scroll-arrow-wrap">
        <svg class="scroll-chevron" viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
          <polyline points="6 9 12 15 18 9"/>
        </svg>
      </div>
      <span>Scroll Down</span>
    </div>
  </section>

  <!-- SPECIALTIES -->
  <section class="specialties" id="specialties">
    <div class="specialties-container">
      <div class="section-header">
        <span class="section-tag">Our Signature</span>
        <h2 class="section-title">Crafted With <span class="gradient-text">Love & Tradition</span></h2>
        <p class="section-subtitle">From our legendary Lacha Paratha to the soul-warming Karak Chai — every bite tells a story of authentic Quetta flavors.</p>
      </div>
      <div class="spec-grid">
        <div class="spec-card">
          <div class="spec-icon-box green">🫓</div>
          <h3 class="spec-name">Special Lacha Paratha</h3>
          <p class="spec-desc">Layers upon layers of perfectly flaky, golden paratha — hand-rolled fresh on the tawa right before your eyes. Our most loved item!</p>
          <div class="spec-price">From Rs. 90</div>
        </div>
        <div class="spec-card">
          <div class="spec-icon-box amber">🧀</div>
          <h3 class="spec-name">Cheese Paratha</h3>
          <p class="spec-desc">Crispy golden layers with gooey melted cheese inside — pulls perfectly with every bite. A modern twist on a timeless classic.</p>
          <div class="spec-price">Rs. 130</div>
        </div>
        <div class="spec-card">
          <div class="spec-icon-box red">🍳</div>
          <h3 class="spec-name">Anda Paratha</h3>
          <p class="spec-desc">Fresh masala egg folded inside a hot crispy paratha — the ultimate desi breakfast combo that starts your day right.</p>
          <div class="spec-price">Rs. 100</div>
        </div>
        <div class="spec-card">
          <div class="spec-icon-box teal">☕</div>
          <h3 class="spec-name">Karak Chai</h3>
          <p class="spec-desc">Brewing Memories with Every Sip. Bold, creamy, and strong — our signature chai is the perfect warm companion to every meal.</p>
          <div class="spec-price">Rs. 90</div>
        </div>
      </div>
    </div>
  </section>

  <!-- WHY CHOOSE US -->
  <section class="why-us">
    <div class="why-container">
      <div class="section-header">
        <span class="section-tag">Why Choose Us</span>
        <h2 class="section-title">More Than Just Food —<br>It's an <span style="color:var(--amber-light)">Experience</span></h2>
        <p class="section-subtitle" style="color:rgba(255,255,255,.7)">Every paratha tells a story of quality, tradition, and love. Here's why thousands trust Haji Quetta Paratha every day.</p>
      </div>
      <div class="why-grid">
        <div class="why-card"><span class="why-icon">🔥</span><div class="why-title">Made Fresh on Order</div><div class="why-desc">We never pre-make. Every paratha is hand-rolled and cooked the moment you order it — hot, crispy, and perfect.</div></div>
        <div class="why-card"><span class="why-icon">🚚</span><div class="why-title">Free Home Delivery</div><div class="why-desc">Order from the comfort of your home. We deliver fast and free across New Lahore City — right to your doorstep.</div></div>
        <div class="why-card"><span class="why-icon">⭐</span><div class="why-title">5-Star Google Reviews</div><div class="why-desc">Our customers love us! Hundreds of 5-star reviews on Google — we let our food speak for itself every single day.</div></div>
        <div class="why-card"><span class="why-icon">💰</span><div class="why-title">Best Value in Town</div><div class="why-desc">Premium taste at unbeatable prices. From Rs. 50 chai to Rs. 180 Special Paratha — quality food that doesn't break the bank.</div></div>
      </div>
    </div>
  </section>

  <!-- OUR STORY -->
  <section class="story" id="about">
    <div class="story-container">
      <div class="story-content">
        <span class="section-tag">Our Story</span>
        <h2 class="story-title">A Legacy Baked<br>Into Every <span class="gradient-text">Golden Layer</span></h2>
        <p class="story-text">Haji Quetta Paratha was born from a passion for authentic, traditional flavors. Situated at Shop #1, Main Boulevard, New Lahore City, we have been serving the community with love, quality, and the timeless recipe passed down through generations.</p>
        <p class="story-text">We believe a great paratha isn't just food — it's an experience. That's why every dough is hand-kneaded, every layer is carefully folded, and every paratha is made fresh, right when you order it.</p>
        <div class="story-highlights">
          <div class="story-hi"><span class="star">★</span> Freshly prepared on order — never pre-made</div>
          <div class="story-hi"><span class="star">★</span> Free home delivery across New Lahore City</div>
          <div class="story-hi"><span class="star">★</span> Premium quality ingredients, every single day</div>
          <div class="story-hi"><span class="star">★</span> Verified on Google Reviews ⭐⭐⭐⭐⭐</div>
        </div>
        <div style="margin-top:2rem; display:flex; gap:1rem; flex-wrap:wrap;">
          <a href="{{ route('menu') }}" class="btn btn-gold">View Full Menu</a>
          <a href="{{ route('order') }}" class="btn btn-outline">Order Now</a>
        </div>
      </div>
      <div class="story-visual">
        <div class="info-card">
          <div class="info-item"><div class="info-icon">📍</div><div><div class="info-label">Location</div><div class="info-value">Shop #1, A17, Main Boulevard, New Lahore City</div></div></div>
          <div class="info-item"><div class="info-icon">📞</div><div><div class="info-label">Call / WhatsApp</div><div class="info-value">0312-7882163 &nbsp;|&nbsp; 0323-7800007</div></div></div>
          <div class="info-item"><div class="info-icon">👤</div><div><div class="info-label">Contact Person</div><div class="info-value">Zulfiqar Ali</div></div></div>
          <div class="info-item"><div class="info-icon">🚚</div><div><div class="info-label">Delivery</div><div class="info-value">Free Delivery Available</div></div></div>
          <div class="info-item"><div class="info-icon">⭐</div><div><div class="info-label">Google Reviews</div><div class="info-value" style="color:var(--gold)">⭐⭐⭐⭐⭐ Highly Rated</div></div></div>
        </div>
      </div>
    </div>
  </section>

  <!-- CTA -->
  <section class="cta-section">
    <div class="cta-card">
      <span class="section-tag">Hungry? 🫓</span>
      <h2 class="cta-title">Order Fresh,<br><span class="gradient-text">Eat Happy</span></h2>
      <p class="cta-subtitle">Place your order in seconds. We'll prepare it fresh and deliver it hot to your doorstep — absolutely free!</p>
      <div style="display:flex; gap:1rem; justify-content:center; flex-wrap:wrap;">
        <a href="{{ route('order') }}" class="btn btn-gold" style="font-size:1rem; padding:1rem 2.5rem;">Order Now →</a>
        <a href="https://wa.me/923127882163" target="_blank" class="btn btn-crimson" style="font-size:1rem; padding:1rem 2.5rem;">WhatsApp Us</a>
      </div>
    </div>
  </section>

@endsection