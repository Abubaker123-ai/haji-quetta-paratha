/* ============================================
   CUSTOM CURSOR
   ============================================ */
const cursorDot  = document.querySelector('.cursor-dot');
const cursorRing = document.querySelector('.cursor-ring');
let mouseX = 0, mouseY = 0, ringX = 0, ringY = 0;

document.addEventListener('mousemove', (e) => {
  mouseX = e.clientX; mouseY = e.clientY;
  cursorDot.style.transform = `translate(${mouseX - 4}px, ${mouseY - 4}px)`;
  createTrail(mouseX, mouseY);
});
function animateRing() {
  ringX += (mouseX - ringX) * 0.12;
  ringY += (mouseY - ringY) * 0.12;
  cursorRing.style.transform = `translate(${ringX - 20}px, ${ringY - 20}px)`;
  requestAnimationFrame(animateRing);
}
animateRing();

function createTrail(x, y) {
  const trail = document.createElement('div');
  Object.assign(trail.style, {
    position: 'fixed', left: x + 'px', top: y + 'px',
    width: '5px', height: '5px', borderRadius: '50%',
    background: 'rgba(26,77,46,0.25)', pointerEvents: 'none',
    zIndex: '99997', transform: 'translate(-50%,-50%)', transition: 'none'
  });
  document.body.appendChild(trail);
  setTimeout(() => { trail.style.opacity = '0'; trail.style.transform = 'translate(-50%,-50%) scale(0)'; trail.style.transition = 'all 0.5s ease'; }, 10);
  setTimeout(() => { if (trail.parentNode) trail.parentNode.removeChild(trail); }, 520);
}

document.querySelectorAll('a, button, .spec-card, .menu-item').forEach(el => {
  el.addEventListener('mouseenter', () => { cursorRing.style.borderColor = 'rgba(26,77,46,0.9)'; });
  el.addEventListener('mouseleave', () => { cursorRing.style.borderColor = 'rgba(26,77,46,0.45)'; });
});

/* ============================================
   PARTICLES
   ============================================ */
const bg = document.getElementById('particles-bg');
if (bg) {
  const colors = ['rgba(26,77,46,0.3)', 'rgba(224,123,36,0.35)', 'rgba(82,183,136,0.28)'];
  for (let i = 0; i < 28; i++) {
    const p = document.createElement('div');
    p.classList.add('particle');
    const size = Math.random() * 3.5 + 1;
    p.style.cssText = `width:${size}px;height:${size}px;left:${Math.random()*100}%;background:${colors[Math.floor(Math.random()*colors.length)]};animation-duration:${Math.random()*20+15}s;animation-delay:${Math.random()*15}s;`;
    bg.appendChild(p);
  }
}

/* ============================================
   NAVBAR
   ============================================ */
const navbar    = document.querySelector('.navbar');
const hamburger = document.querySelector('.hamburger');
const navLinks  = document.querySelector('.nav-links');

window.addEventListener('scroll', () => {
  navbar.classList.toggle('scrolled', window.scrollY > 50);
});

if (hamburger) {
  hamburger.addEventListener('click', () => {
    navLinks.classList.toggle('open');
    const s = hamburger.querySelectorAll('span');
    if (navLinks.classList.contains('open')) {
      s[0].style.transform = 'rotate(45deg) translate(5px,5px)';
      s[1].style.opacity = '0';
      s[2].style.transform = 'rotate(-45deg) translate(5px,-5px)';
    } else {
      s[0].style.transform = s[1].style.opacity = s[2].style.transform = '';
      s[1].style.opacity = '1';
    }
  });
}

/* ============================================
   SCROLL REVEAL
   ============================================ */
const revealObs = new IntersectionObserver((entries) => {
  entries.forEach(e => { if (e.isIntersecting) e.target.classList.add('visible'); });
}, { threshold: 0.08, rootMargin: '0px 0px -40px 0px' });

document.querySelectorAll(
  '.spec-card, .story-content, .story-visual, .cta-card, .order-info, .order-form-wrapper, .menu-item'
).forEach(el => revealObs.observe(el));

/* ============================================
   MENU TABS
   ============================================ */
const tabs = document.querySelectorAll('.menu-tab');
const cats = document.querySelectorAll('.menu-category');

tabs.forEach(tab => {
  tab.addEventListener('click', () => {
    const target = tab.dataset.tab;
    tabs.forEach(t => t.classList.remove('active'));
    cats.forEach(c => c.classList.remove('active'));
    tab.classList.add('active');
    document.getElementById(target)?.classList.add('active');
    // re-trigger menu item animations
    document.querySelectorAll('#' + target + ' .menu-item').forEach((item, i) => {
      item.classList.remove('visible');
      setTimeout(() => item.classList.add('visible'), i * 60);
    });
  });
});

/* ============================================
   MAGNETIC BUTTONS
   ============================================ */
document.querySelectorAll('.btn, .submit-btn').forEach(btn => {
  btn.addEventListener('mousemove', (e) => {
    const r = btn.getBoundingClientRect();
    const dx = (e.clientX - (r.left + r.width / 2)) * 0.28;
    const dy = (e.clientY - (r.top  + r.height / 2)) * 0.28;
    btn.style.transform = `translate(${dx}px, ${dy}px) translateY(-2px)`;
  });
  btn.addEventListener('mouseleave', () => { btn.style.transform = ''; });
});

/* ============================================
   QUANTITY COUNTER + BILL
   ============================================ */
let userLocation = null;

function updateBill() {
  const billItems = document.getElementById('billItems');
  const billTotal = document.getElementById('billTotal');
  if (!billItems || !billTotal) return;

  let total = 0, rows = '', hasItem = false;

  document.querySelectorAll('.qty-item').forEach(item => {
    const qty   = parseInt(item.querySelector('.qty-count').textContent) || 0;
    const price = parseInt(item.dataset.price) || 0;
    const name  = item.dataset.name || '';
    if (qty > 0) {
      hasItem = true;
      const sub = price * qty;
      total += sub;
      rows += `<div class="bill-item-row"><span>${name} ×${qty}</span><span>Rs. ${sub}</span></div>`;
    }
  });

  billItems.innerHTML = hasItem ? rows : '<div class="bill-empty">No items selected yet...</div>';
  billTotal.textContent = `Rs. ${total}`;
  billTotal.classList.add('pop');
  setTimeout(() => billTotal.classList.remove('pop'), 300);
}

document.querySelectorAll('.qty-item').forEach(item => {
  const countEl = item.querySelector('.qty-count');
  item.querySelector('.qty-plus').addEventListener('click', () => {
    let n = parseInt(countEl.textContent) || 0;
    countEl.textContent = n + 1;
    item.classList.add('active');
    countEl.style.transform = 'scale(1.3)';
    setTimeout(() => countEl.style.transform = '', 150);
    updateBill();
  });
  item.querySelector('.qty-minus').addEventListener('click', () => {
    let n = parseInt(countEl.textContent) || 0;
    if (n <= 0) return;
    n--;
    countEl.textContent = n;
    if (n === 0) item.classList.remove('active');
    updateBill();
  });
});

/* ============================================
   LOCATION
   ============================================ */
const locationBtn    = document.getElementById('locationBtn');
const locationStatus = document.getElementById('locationStatus');
const locationBtnText = document.getElementById('locationBtnText');

if (locationBtn) {
  locationBtn.addEventListener('click', () => {
    locationBtnText.textContent = '⏳ Getting location...';
    locationBtn.disabled = true;

    if (!navigator.geolocation) {
      locationBtnText.textContent = '❌ Not Supported';
      locationBtn.classList.add('error');
      locationStatus.textContent = 'Your browser does not support location sharing.';
      locationStatus.className = 'location-status show err';
      locationBtn.disabled = false;
      return;
    }

    navigator.geolocation.getCurrentPosition(
      (pos) => {
        const lat = pos.coords.latitude.toFixed(6);
        const lng = pos.coords.longitude.toFixed(6);
        userLocation = { lat, lng, url: `https://maps.google.com/?q=${lat},${lng}` };
        locationBtnText.textContent = '✅ Location Captured!';
        locationBtn.classList.add('success');
        locationStatus.textContent = `📍 Location saved: ${lat}, ${lng}`;
        locationStatus.className = 'location-status show ok';
        locationBtn.disabled = false;
      },
      () => {
        locationBtnText.textContent = '❌ Location Denied';
        locationBtn.classList.add('error');
        locationStatus.textContent = 'Permission denied. Please allow location access and try again.';
        locationStatus.className = 'location-status show err';
        locationBtn.disabled = false;
      },
      { timeout: 10000, enableHighAccuracy: true }
    );
  });
}

/* ============================================
   ORDER FORM
   ============================================ */
const orderForm = document.getElementById('orderForm');
if (orderForm) {
  orderForm.addEventListener('submit', async (e) => {
    e.preventDefault();
    const name    = document.getElementById('name')?.value || '';
    const phone   = document.getElementById('phone')?.value || '';
    const address = document.getElementById('address')?.value || '';
    const special = document.getElementById('special')?.value || '';

    // Collect items with quantities
    const itemLines = [];
    let total = 0;
    document.querySelectorAll('.qty-item').forEach(item => {
      const qty = parseInt(item.querySelector('.qty-count').textContent) || 0;
      if (qty > 0) {
        const price = parseInt(item.dataset.price) || 0;
        const sub   = price * qty;
        total += sub;
        itemLines.push(`• ${item.dataset.name} ×${qty} — Rs. ${sub}`);
      }
    });

    const btn = orderForm.querySelector('.submit-btn');
    btn.classList.add('loading'); btn.disabled = true;
    await new Promise(r => setTimeout(r, 1500));

    // Build WhatsApp message with total
    let msg = `🍽️ *New Order — Haji Quetta Paratha*\n\n`;
    msg += `👤 *Name:* ${name}\n`;
    msg += `📞 *Phone:* ${phone}\n`;
    msg += `📍 *Address:* ${address}\n\n`;
    msg += `🛒 *Items Ordered:*\n${itemLines.join('\n') || '(None selected)'}\n\n`;
    msg += `💰 *Total Bill: Rs. ${total}*\n\n`;
    if (special) msg += `📝 *Special Instructions:* ${special}\n\n`;
    if (userLocation) {
      msg += `🗺️ *Customer Location:*\n${userLocation.url}`;
    } else {
      msg += `📍 *Delivery Address:* ${address}`;
    }

    window.open(`https://wa.me/923127882163?text=${encodeURIComponent(msg)}`, '_blank');

    btn.classList.remove('loading'); btn.disabled = false;
    orderForm.style.display = 'none';
    document.querySelector('.success-message')?.classList.add('show');
  });
}

/* ============================================
   PARALLAX HERO
   ============================================ */
window.addEventListener('scroll', () => {
  const v = document.querySelector('.hero-visual');
  if (v && window.scrollY < window.innerHeight) v.style.transform = `translateY(${window.scrollY * 0.07}px)`;
});

/* ============================================
   PAGE TRANSITION
   ============================================ */
document.querySelectorAll('a[href]').forEach(link => {
  const href = link.getAttribute('href');
  if (href && !href.startsWith('#') && !href.startsWith('http') && !href.startsWith('mailto') && !href.startsWith('tel')) {
    link.addEventListener('click', (e) => {
      e.preventDefault();
      document.body.style.opacity = '0';
      document.body.style.transition = 'opacity 0.3s ease';
      setTimeout(() => window.location.href = href, 300);
    });
  }
});

window.addEventListener('load', () => {
  document.body.style.opacity = '0';
  setTimeout(() => { document.body.style.opacity = '1'; document.body.style.transition = 'opacity 0.5s ease'; }, 50);
});

/* ============================================
   ACTIVE NAV
   ============================================ */
const path = window.location.pathname;
document.querySelectorAll('.nav-links a').forEach(a => {
  const h = a.getAttribute('href') || '';
  if (path.includes('menu') && h.includes('menu')) a.classList.add('active');
  else if (path.includes('order') && h.includes('order')) a.classList.add('active');
  else if ((path === '/' || path.includes('index') || path.endsWith('/')) && (h === 'index.html' || h === '/')) a.classList.add('active');
});
