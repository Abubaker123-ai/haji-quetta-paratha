@extends('layouts.app')

@section('title', 'Order Now — Haji Quetta Paratha')
@section('description', 'Order fresh parathas, chai and more from Haji Quetta Paratha. Free delivery in New Lahore City.')

@section('content')

  <!-- ORDER HERO -->
  <div class="order-hero">
    <div style="max-width:580px; margin:0 auto;">
      <span class="section-tag" style="animation:fadeInDown 0.6s ease both;">🚚 Free Delivery</span>
      <h1 class="hero-title" style="animation:fadeInUp 0.7s ease 0.1s both; margin-bottom:1rem;">
        Order Fresh,<br><span class="gradient-text">Eat Happy</span>
      </h1>
      <p style="color:var(--text-secondary); font-size:1rem; line-height:1.7; animation:fadeInUp 0.7s ease 0.25s both;">
        Fill in your details and select your items — your order will be
        sent directly to us via WhatsApp. Hot & fresh to your door!
      </p>
    </div>
  </div>

  <!-- ORDER SECTION -->
  <section class="order-section">
    <div class="order-container">

      <!-- Info -->
      <div class="order-info">
        <h2 class="order-info-title">How It Works</h2>
        <p class="order-info-text">Place your order in 3 simple steps — we'll confirm and deliver fresh, hot food right to your doorstep.</p>
        <div class="order-details">
          <div class="order-detail-item"><div class="o-icon">1️⃣</div><div class="o-text"><strong>Fill the Form</strong>Enter your name, phone & address</div></div>
          <div class="order-detail-item"><div class="o-icon">2️⃣</div><div class="o-text"><strong>Select Items</strong>Choose your parathas, drinks & extras</div></div>
          <div class="order-detail-item"><div class="o-icon">3️⃣</div><div class="o-text"><strong>Order Sent!</strong>Your order goes directly to our WhatsApp</div></div>
          <div class="order-detail-item"><div class="o-icon">🚚</div><div class="o-text"><strong>Free Delivery</strong>Hot & fresh delivered to your door</div></div>
        </div>
        <div style="margin-top:2rem; padding:1.5rem; background:var(--glass-bg); border:1px solid var(--glass-border); border-radius:14px;">
          <div style="font-size:0.75rem; color:var(--gold); text-transform:uppercase; letter-spacing:1px; margin-bottom:1rem; font-weight:600;">Direct Contact</div>
          <a href="tel:+923127882163" style="display:flex; align-items:center; gap:0.6rem; color:var(--text-primary); text-decoration:none; margin-bottom:0.8rem; font-size:0.9rem; font-weight:600;">📞 0312-7882163</a>
          <a href="tel:+923237800007" style="display:flex; align-items:center; gap:0.6rem; color:var(--text-primary); text-decoration:none; margin-bottom:0.8rem; font-size:0.9rem; font-weight:600;">📞 0323-7800007</a>
          <div style="font-size:0.82rem; color:var(--text-secondary);">📍 Shop #1, A17, Main Boulevard, New Lahore City</div>
        </div>
        <div style="margin-top:1.2rem; padding:1rem; background:rgba(212,175,55,0.06); border:1px solid rgba(212,175,55,0.15); border-radius:12px; display:flex; align-items:center; gap:0.8rem;">
          <div style="width:10px; height:10px; background:var(--gold); border-radius:50%; flex-shrink:0;"></div>
          <div style="font-size:0.82rem; color:var(--text-secondary);"><span style="color:var(--gold); font-weight:600; display:block; margin-bottom:0.1rem;">Currently Open</span>Accepting orders now — fast delivery!</div>
        </div>
      </div>

      <!-- Form -->
      <div class="order-form-wrapper">
        <div class="form-card">
          <form id="orderForm">
            <div class="form-title">🛒 Place Your Order</div>
            <div class="form-row">
              <div class="form-group"><input type="text" class="form-control" id="name" placeholder=" " required /><label for="name" class="form-label">Your Name</label></div>
              <div class="form-group"><input type="tel" class="form-control" id="phone" placeholder=" " required /><label for="phone" class="form-label">Phone Number</label></div>
            </div>
            <div class="form-group"><input type="text" class="form-control" id="address" placeholder=" " required /><label for="address" class="form-label">Delivery Address</label></div>

            <div style="margin-bottom:1rem;">
              <div class="items-label">Select Items &amp; Quantity</div>
              <div class="qty-grid">
                <div class="qty-item" data-price="90"  data-name="🫓 Plain Paratha"><span class="qty-name">🫓 Plain Paratha <em>Rs.90</em></span><div class="qty-controls"><button type="button" class="qty-btn qty-minus">−</button><span class="qty-count">0</span><button type="button" class="qty-btn qty-plus">+</button></div></div>
                <div class="qty-item" data-price="130" data-name="🥞 Lacha Paratha"><span class="qty-name">🥞 Lacha Paratha <em>Rs.130</em></span><div class="qty-controls"><button type="button" class="qty-btn qty-minus">−</button><span class="qty-count">0</span><button type="button" class="qty-btn qty-plus">+</button></div></div>
                <div class="qty-item" data-price="180" data-name="✨ Special Lacha Paratha"><span class="qty-name">✨ Special Lacha <em>Rs.180</em></span><div class="qty-controls"><button type="button" class="qty-btn qty-minus">−</button><span class="qty-count">0</span><button type="button" class="qty-btn qty-plus">+</button></div></div>
                <div class="qty-item" data-price="130" data-name="🧀 Cheese Paratha"><span class="qty-name">🧀 Cheese Paratha <em>Rs.130</em></span><div class="qty-controls"><button type="button" class="qty-btn qty-minus">−</button><span class="qty-count">0</span><button type="button" class="qty-btn qty-plus">+</button></div></div>
                <div class="qty-item" data-price="90"  data-name="🥔 Aloo Paratha"><span class="qty-name">🥔 Aloo Paratha <em>Rs.90</em></span><div class="qty-controls"><button type="button" class="qty-btn qty-minus">−</button><span class="qty-count">0</span><button type="button" class="qty-btn qty-plus">+</button></div></div>
                <div class="qty-item" data-price="100" data-name="🍳 Anda Paratha"><span class="qty-name">🍳 Anda Paratha <em>Rs.100</em></span><div class="qty-controls"><button type="button" class="qty-btn qty-minus">−</button><span class="qty-count">0</span><button type="button" class="qty-btn qty-plus">+</button></div></div>
                <div class="qty-item" data-price="100" data-name="🍳 Omelette Paratha"><span class="qty-name">🍳 Omelette Paratha <em>Rs.100</em></span><div class="qty-controls"><button type="button" class="qty-btn qty-minus">−</button><span class="qty-count">0</span><button type="button" class="qty-btn qty-plus">+</button></div></div>
                <div class="qty-item" data-price="50"  data-name="🍵 Chai"><span class="qty-name">🍵 Chai <em>Rs.50</em></span><div class="qty-controls"><button type="button" class="qty-btn qty-minus">−</button><span class="qty-count">0</span><button type="button" class="qty-btn qty-plus">+</button></div></div>
                <div class="qty-item" data-price="90"  data-name="☕ Karak Chai"><span class="qty-name">☕ Karak Chai <em>Rs.90</em></span><div class="qty-controls"><button type="button" class="qty-btn qty-minus">−</button><span class="qty-count">0</span><button type="button" class="qty-btn qty-plus">+</button></div></div>
                <div class="qty-item" data-price="90"  data-name="🥛 Doodh Pati"><span class="qty-name">🥛 Doodh Pati <em>Rs.90</em></span><div class="qty-controls"><button type="button" class="qty-btn qty-minus">−</button><span class="qty-count">0</span><button type="button" class="qty-btn qty-plus">+</button></div></div>
                <div class="qty-item" data-price="70"  data-name="🥤 Lassi (350ml)"><span class="qty-name">🥤 Lassi 350ml <em>Rs.70</em></span><div class="qty-controls"><button type="button" class="qty-btn qty-minus">−</button><span class="qty-count">0</span><button type="button" class="qty-btn qty-plus">+</button></div></div>
                <div class="qty-item" data-price="120" data-name="🥤 Lassi (500ml)"><span class="qty-name">🥤 Lassi 500ml <em>Rs.120</em></span><div class="qty-controls"><button type="button" class="qty-btn qty-minus">−</button><span class="qty-count">0</span><button type="button" class="qty-btn qty-plus">+</button></div></div>
                <div class="qty-item" data-price="220" data-name="🫙 Lassi (1.5L)"><span class="qty-name">🫙 Lassi 1.5L <em>Rs.220</em></span><div class="qty-controls"><button type="button" class="qty-btn qty-minus">−</button><span class="qty-count">0</span><button type="button" class="qty-btn qty-plus">+</button></div></div>
                <div class="qty-item" data-price="120" data-name="🥫 Cold Drink"><span class="qty-name">🥫 Cold Drink <em>Rs.120</em></span><div class="qty-controls"><button type="button" class="qty-btn qty-minus">−</button><span class="qty-count">0</span><button type="button" class="qty-btn qty-plus">+</button></div></div>
                <div class="qty-item" data-price="70"  data-name="🍳 Omelette"><span class="qty-name">🍳 Omelette <em>Rs.70</em></span><div class="qty-controls"><button type="button" class="qty-btn qty-minus">−</button><span class="qty-count">0</span><button type="button" class="qty-btn qty-plus">+</button></div></div>
                <div class="qty-item" data-price="180" data-name="🥚 Special Omelette"><span class="qty-name">🥚 Special Omelette <em>Rs.180</em></span><div class="qty-controls"><button type="button" class="qty-btn qty-minus">−</button><span class="qty-count">0</span><button type="button" class="qty-btn qty-plus">+</button></div></div>
              </div>
            </div>

            <div class="bill-box" id="billBox">
              <div class="bill-title">🧾 Order Summary</div>
              <div class="bill-items" id="billItems"><div class="bill-empty">No items selected yet...</div></div>
              <div class="bill-divider"></div>
              <div class="bill-total"><span>Total Bill:</span><span class="bill-amount" id="billTotal">Rs. 0</span></div>
            </div>

            <div class="location-box">
              <div class="location-label">📍 Share Your Location <span style="font-size:.7rem;color:#999;font-weight:400">(For accurate delivery)</span></div>
              <button type="button" id="locationBtn" class="location-btn"><span id="locationBtnText">📍 Get My Location</span></button>
              <div id="locationStatus" class="location-status"></div>
            </div>

            <div class="form-group" style="margin-top:.8rem">
              <textarea class="form-control" id="special" rows="2" placeholder=" "></textarea>
              <label for="special" class="form-label">Special Instructions (optional)</label>
            </div>

            <button type="submit" class="submit-btn">
              <span class="btn-text">🛒 Send Order via WhatsApp</span>
              <span class="btn-loading"><svg width="18" height="18" viewBox="0 0 24 24" fill="none" style="animation:spin 1s linear infinite;vertical-align:middle;"><circle cx="12" cy="12" r="10" stroke="#fff" stroke-width="3" opacity="0.3"/><path d="M12 2C6.48 2 2 6.48 2 12" stroke="#fff" stroke-width="3" stroke-linecap="round"/></svg>&nbsp;Sending...</span>
            </button>
          </form>

          <div class="success-message">
            <div class="success-icon">🫓</div>
            <h3 class="success-title">Order Sent!</h3>
            <p class="success-text">Your order has been sent to us via WhatsApp. We'll confirm shortly and deliver hot & fresh to your door!<br><br><strong style="color:var(--gold);">Need help? Call 0312-7882163</strong></p>
            <button onclick="window.location.reload()" class="btn btn-outline" style="margin-top:1.5rem; cursor:pointer; padding:0.7rem 1.8rem; font-size:0.9rem; font-weight:600;">Place Another Order</button>
          </div>
        </div>
      </div>

    </div>
  </section>

  <style>@keyframes spin { from { transform:rotate(0deg); } to { transform:rotate(360deg); } }</style>

@endsection