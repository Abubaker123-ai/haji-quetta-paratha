@extends('admin.layout', ['title' => 'Feedback'])

@push('head')
<style>
    .msg-card {
        margin-bottom: 16px;
        padding: 0;
        overflow: hidden;
    }
    .msg-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        gap: 16px;
        padding: 16px 20px;
        border-bottom: 1px solid #d1fae5;
    }
    .msg-customer { display: flex; flex-direction: column; gap: 6px; }
    .msg-customer-name {
        font-size: 17px; font-weight: 700; color: #064e3b;
        display: flex; align-items: center; gap: 10px;
    }
    .msg-meta-row {
        display: flex; gap: 14px; flex-wrap: wrap;
        align-items: center;
        font-size: 13px;
    }
    .msg-meta-row a { color: #047857; text-decoration: none; font-weight: 700; }
    .msg-meta-row a:hover { color: #064e3b; text-decoration: underline; }
    .msg-time {
        display: inline-flex; align-items: center; gap: 6px;
        font-size: 12px; color: #047857;
        font-weight: 600;
        background: #d1fae5;
        padding: 6px 12px;
        border-radius: 999px;
        border: 1px solid #6ee7b7;
    }
    .msg-body {
        padding: 16px 20px;
    }
    .msg-section-title {
        font-size: 11px; font-weight: 800;
        color: #047857;
        text-transform: uppercase;
        letter-spacing: 0.08em;
        margin-bottom: 8px;
        display: flex; align-items: center; gap: 8px;
    }
    .msg-text {
        background: #f0fdf4;
        border: 1px solid #d1fae5;
        border-left: 4px solid #10b981;
        padding: 14px 16px;
        border-radius: 10px;
        font-size: 14.5px;
        line-height: 1.6;
        color: #111827;
        font-weight: 500;
    }
    .empty-state {
        text-align: center;
        padding: 70px 30px;
        color: #4b5563;
    }
    .empty-state .emoji { font-size: 56px; margin-bottom: 14px; }
    .empty-state .title { font-weight: 700; font-size: 17px; color: #064e3b; margin-bottom: 4px; }
</style>
@endpush

@section('content')
    <div class="page-head">
        <div>
            <h2>Customer Feedback</h2>
            <div class="sub">Feedback and messages submitted by your customers.</div>
        </div>
    </div>

    @forelse ($messages as $m)
        <div class="card msg-card">
            <div class="msg-header">
                <div class="msg-customer">
                    <div class="msg-customer-name">
                        <span style="font-size:18px;">👤</span>
                        {{ $m->name }}
                    </div>
                    <div class="msg-meta-row">
                        <a href="tel:{{ $m->phone }}">📞 {{ $m->phone }}</a>
                        @if ($m->address)
                            <span style="color:#4b5563;">📍 {{ $m->address }}</span>
                        @endif
                    </div>
                </div>
                <div class="msg-time">🕒 {{ $m->created_at->diffForHumans() }}</div>
            </div>

            @if ($m->message)
                <div class="msg-body">
                    <div class="msg-section-title"><span>💬</span> Customer Message</div>
                    <div class="msg-text">{{ $m->message }}</div>
                </div>
            @endif
        </div>
    @empty
        <div class="card empty-state">
            <div class="emoji">💬</div>
            <div class="title">No messages yet</div>
            <div>Customer feedback will appear here.</div>
        </div>
    @endforelse
@endsection
