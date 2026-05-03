@extends('layouts.app')

@section('title', 'Contact Us — Haji Quetta Paratha')
@section('description', 'Contact Haji Quetta Paratha — New Lahore City. Call or send a message.')

@section('content')

  <div class="order-hero">
    <div style="max-width:580px; margin:0 auto;">
      <span class="section-tag" style="animation:fadeInDown 0.6s ease both;">📞 Get In Touch</span>
      <h1 class="hero-title" style="animation:fadeInUp 0.7s ease 0.1s both; margin-bottom:1rem;">
        Contact <span class="gradient-text">Haji Quetta</span>
      </h1>
      <p style="color:var(--text-secondary); font-size:1rem; line-height:1.7; animation:fadeInUp 0.7s ease 0.25s both;">
        Koi sawaal hai? Feedback dena chahte hain? Ya sirf hello kehna hai — hum yahan hain!
      </p>
    </div>
  </div>

  <section class="order-section">
    <div class="order-container">

      <div class="order-info">
        <div class="form-card">
          <h2 class="order-info-title">Direct Contact</h2>
          <p class="order-info-text">Seedha call karein ya neeche form bhariein — hum jald jawab denge.</p>
          <div class="order-details">
            <div class="order-detail-item"><div class="o-icon">📞</div><div class="o-text"><strong>Call / WhatsApp</strong>0312-7882163</div></div>
            <div class="order-detail-item"><div class="o-icon">📞</div><div class="o-text"><strong>Call / WhatsApp</strong>0323-7800007</div></div>
            <div class="order-detail-item"><div class="o-icon">📍</div><div class="o-text"><strong>Location</strong>Shop #1, A17, Main Boulevard, New Lahore City</div></div>
            <div class="order-detail-item"><div class="o-icon">👤</div><div class="o-text"><strong>Contact Person</strong>Zulfiqar Ali</div></div>
          </div>
        </div>
      </div>

      <div class="order-form-wrapper">
        <div class="form-card">

          @if(session('success'))
            <div style="background:rgba(34,197,94,0.1); border:1px solid rgba(34,197,94,0.3); border-radius:12px; padding:1rem 1.2rem; margin-bottom:1.5rem; color:#22c55e; font-weight:600;">
              ✅ {{ session('success') }}
            </div>
          @endif

          <div class="form-title">✉️ Send a Message</div>
          <form action="{{ route('contact.store') }}" method="POST">
            @csrf
            <div class="form-row">
              <div class="form-group">
                <input type="text" name="name" class="form-control" placeholder=" " required value="{{ old('name') }}" />
                <label class="form-label">Aapka Naam</label>
                @error('name')<small style="color:#ef4444">{{ $message }}</small>@enderror
              </div>
              <div class="form-group">
                <input type="tel" name="phone" class="form-control" placeholder=" " required value="{{ old('phone') }}" />
                <label class="form-label">Phone Number</label>
                @error('phone')<small style="color:#ef4444">{{ $message }}</small>@enderror
              </div>
            </div>
            <div class="form-group">
              <input type="text" name="address" class="form-control" placeholder=" " value="{{ old('address') }}" />
              <label class="form-label">Address (optional)</label>
            </div>
            <div class="form-group" style="margin-top:.8rem">
              <textarea name="message" class="form-control" rows="4" placeholder=" ">{{ old('message') }}</textarea>
              <label class="form-label">Aapka Message</label>
            </div>
            <button type="submit" class="submit-btn">
              <span class="btn-text">✉️ Message Bhejein</span>
            </button>
          </form>
        </div>
      </div>

    </div>
  </section>

@endsection