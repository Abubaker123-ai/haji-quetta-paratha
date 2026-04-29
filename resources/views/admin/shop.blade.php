@extends('admin.layout', ['title' => 'Shop Control'])

@section('content')
<div class="page-head">
    <div>
        <h2>Shop Control</h2>
        <div class="sub">Manage shop status, hours, and customer messages</div>
    </div>
</div>

{{-- Current Status Banner --}}
@if($shop->effectivelyOpen())
    <div style="background:#d1fae5;border:1px solid #6ee7b7;border-radius:12px;padding:16px 20px;margin-bottom:24px;display:flex;align-items:center;gap:12px;">
        <div style="width:14px;height:14px;background:#10b981;border-radius:50%;animation:pulse 2s infinite;flex-shrink:0;"></div>
        <div>
            <div style="font-weight:700;font-size:16px;color:#065f46;">Shop is OPEN</div>
            <div style="font-size:13px;color:#047857;margin-top:2px;">Customers can place orders right now.</div>
        </div>
    </div>
@else
    <div style="background:#fee2e2;border:1px solid #fca5a5;border-radius:12px;padding:16px 20px;margin-bottom:24px;display:flex;align-items:center;gap:12px;">
        <div style="width:14px;height:14px;background:#ef4444;border-radius:50%;flex-shrink:0;"></div>
        <div>
            <div style="font-weight:700;font-size:16px;color:#991b1b;">Shop is CLOSED</div>
            <div style="font-size:13px;color:#b91c1c;margin-top:2px;">Customers cannot place orders. They see your closed message.</div>
        </div>
    </div>
@endif

<form action="{{ route('admin.shop.update') }}" method="POST">
    @csrf

    {{-- Open / Close Toggle --}}
    <div class="card" style="margin-bottom:20px;">
        <div style="display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:16px;">
            <div>
                <div style="font-size:17px;font-weight:700;color:#000;">🏪 Shop Status</div>
                <div style="font-size:13px;color:#374151;margin-top:4px;">Manually open or close your shop instantly.</div>
            </div>
            <label style="display:flex;align-items:center;gap:14px;cursor:pointer;">
                <span style="font-size:14px;font-weight:600;color:#991b1b;">Closed</span>
                <div style="position:relative;width:60px;height:32px;">
                    <input type="checkbox" name="is_open" value="1"
                        {{ $shop->is_open ? 'checked' : '' }}
                        onchange="this.form.submit()"
                        style="opacity:0;width:0;height:0;position:absolute;">
                    <div onclick="this.previousElementSibling.click()"
                        style="position:absolute;inset:0;border-radius:32px;
                            background:{{ $shop->is_open ? '#10b981' : '#d1d5db' }};
                            cursor:pointer;transition:background 0.2s;">
                        <div style="position:absolute;width:24px;height:24px;border-radius:50%;background:#fff;
                            top:4px;transition:left 0.2s;
                            left:{{ $shop->is_open ? '32px' : '4px' }};
                            box-shadow:0 1px 3px rgba(0,0,0,0.2);"></div>
                    </div>
                </div>
                <span style="font-size:14px;font-weight:600;color:#065f46;">Open</span>
            </label>
        </div>
    </div>

    {{-- Schedule --}}
    <div class="card" style="margin-bottom:20px;">
        <div style="font-size:17px;font-weight:700;color:#000;margin-bottom:4px;">⏰ Auto Schedule</div>
        <div style="font-size:13px;color:#374151;margin-bottom:18px;">
            Enable to automatically open/close shop based on time. Manual toggle above takes priority.
        </div>
        <div style="display:flex;align-items:center;gap:12px;margin-bottom:18px;">
            <input type="checkbox" name="use_schedule" value="1" id="use_schedule"
                {{ $shop->use_schedule ? 'checked' : '' }}
                style="width:18px;height:18px;cursor:pointer;accent-color:#1B5E20;">
            <label for="use_schedule" style="font-size:14px;font-weight:600;color:#000;cursor:pointer;">
                Enable automatic time-based control
            </label>
        </div>
        <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px;">
            <div>
                <label style="font-size:12px;font-weight:700;color:#000;display:block;margin-bottom:6px;">OPENING TIME</label>
                <input type="time" name="opening_time" value="{{ $shop->opening_time }}"
                    style="width:100%;padding:10px 12px;border:1px solid #d1d5db;border-radius:8px;font-size:15px;font-weight:600;color:#000;">
            </div>
            <div>
                <label style="font-size:12px;font-weight:700;color:#000;display:block;margin-bottom:6px;">CLOSING TIME</label>
                <input type="time" name="closing_time" value="{{ $shop->closing_time }}"
                    style="width:100%;padding:10px 12px;border:1px solid #d1d5db;border-radius:8px;font-size:15px;font-weight:600;color:#000;">
            </div>
        </div>
    </div>

    {{-- Custom Message --}}
    <div class="card" style="margin-bottom:24px;">
        <div style="font-size:17px;font-weight:700;color:#000;margin-bottom:4px;">💬 Closed Message</div>
        <div style="font-size:13px;color:#374151;margin-bottom:14px;">
            This message is shown to customers when shop is closed. Keep it friendly and informative.
        </div>
        <textarea name="custom_message" rows="3"
            placeholder="e.g. We are closed right now. We will reopen at 6 AM tomorrow. Sorry for the inconvenience!"
            style="width:100%;padding:12px;border:1px solid #d1d5db;border-radius:8px;font-family:inherit;font-size:14px;color:#000;resize:vertical;">{{ $shop->custom_message }}</textarea>
        <div style="font-size:12px;color:#6b7280;margin-top:6px;">Leave empty to show default message.</div>
    </div>

    <button type="submit" class="btn" style="width:100%;padding:14px;font-size:15px;">
        💾 Save Shop Settings
    </button>
</form>
@endsection
