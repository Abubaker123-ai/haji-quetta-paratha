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
        padding: 18px 22px;
        border-bottom: 1px solid rgba(255,255,255,0.08);
    }
    .msg-customer { display: flex; flex-direction: column; gap: 6px; }
    .msg-customer-name {
        font-size: 17px; font-weight: 700; color: #fff;
        display: flex; align-items: center; gap: 10px;
    }
    .msg-meta-row {
        display: flex; gap: 14px; flex-wrap: wrap;
        align-items: center;
        font-size: 13px;
    }
    .msg-meta-row a { color: #93c5fd; text-decoration: none; font-weight: 600; }
    .msg-meta-row a:hover { color: #fff; }
    .msg-time {
        display: inline-flex; align-items: center; gap: 6px;
        font-size: 12px; color: rgba(255,255,255,0.55);
        font-weight: 500;
        background: rgba(255,255,255,0.05);
        padding: 6px 12px;
        border-radius: 999px;
    }
    .msg-body {
        padding: 18px 22px;
    }
    .msg-section-title {
        font-size: 11px; font-weight: 700;
        color: rgba(255,255,255,0.55);
        text-transform: uppercase;
        letter-spacing: 0.08em;
        margin-bottom: 10px;
        display: flex; align-items: center; gap: 8px;
    }
    .msg-text {
        background: rgba(96,165,250,0.08);
        border: 1px solid rgba(96,165,250,0.2);
        border-left: 4px solid #60a5fa;
        padding: 14px 16px;
        border-radius: 10px;
        font-size: 14.5px;
        line-height: 1.6;
        color: #dbeafe;
    }
    .empty-state {
        text-align: center;
        padding: 70px 30px;
        color: rgba(255,255,255,0.55);
    }
    .empty-state .emoji { font-size: 56px; margin-bottom: 14px; }
    .empty-state .title { font-weight: 700; font-size: 17px; color: #fff; margin-bottom: 4px; }
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
                            <span style="color:rgba(255,255,255,0.7);">📍 {{ $m->address }}</span>
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
