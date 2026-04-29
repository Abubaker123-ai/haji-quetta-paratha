@extends('admin.layout', ['title' => 'Messages'])

@section('content')
    <div class="page-head">
        <div>
            <h2>Customer Messages</h2>
            <div class="sub">Messages submitted via the contact form.</div>
        </div>
    </div>

    @forelse ($messages as $m)
        <div class="card" style="margin-bottom:12px;">
            <div style="display:flex;justify-content:space-between;align-items:flex-start;">
                <div>
                    <div style="font-weight:700;font-size:15px;">{{ $m->name }}</div>
                    <div style="font-size:13px;color:#6b7280;margin-top:2px;">📞 {{ $m->phone }}</div>
                    @if ($m->address)
                        <div style="font-size:13px;color:#6b7280;margin-top:2px;">📍 {{ $m->address }}</div>
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
