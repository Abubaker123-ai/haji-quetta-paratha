@extends('admin.layout', ['title' => 'Feedback'])

@section('content')
    <div class="page-head">
        <div>
            <h2>Customer Feedback</h2>
            <div class="sub">Feedback and messages submitted by your customers.</div>
        </div>
    </div>

    @forelse ($messages as $m)
        <div class="card" style="margin-bottom:12px;">
            <div style="display:flex;justify-content:space-between;align-items:flex-start;">
                <div>
                    <div style="font-weight:700;font-size:16px;color:#000;">{{ $m->name }}</div>
                    <a href="tel:{{ $m->phone }}" style="font-size:14px;color:#1B5E20;text-decoration:none;font-weight:600;display:inline-block;margin-top:4px;">📞 {{ $m->phone }}</a>
                    @if ($m->address)
                        <div style="font-size:13px;color:#000;margin-top:4px;">📍 {{ $m->address }}</div>
                    @endif
                </div>
                <div style="font-size:12px;color:#6b7280;">{{ $m->created_at->diffForHumans() }}</div>
            </div>
            @if ($m->message)
                <div style="margin-top:12px;padding:12px;background:#f9fafb;border-radius:8px;font-size:14px;line-height:1.5;">{{ $m->message }}</div>
            @endif
        </div>
    @empty
        <div class="card" style="text-align:center;padding:50px;color:#6b7280;">
            <div style="font-size:50px;margin-bottom:12px;">💬</div>
            <div>No messages yet.</div>
        </div>
    @endforelse
@endsection
