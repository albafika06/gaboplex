@extends('layouts.app')
@section('title', 'Messages')
@section('content')
<style>
.msg-wrap{max-width:900px;margin:0 auto;padding:1.75rem 1.5rem}
.msg-header{margin-bottom:1.5rem}
.msg-header h1{font-size:20px;font-weight:700;color:#042C53;letter-spacing:-.5px}
.msg-header p{font-size:13px;color:#94a3b8;margin-top:2px}
.msg-list{display:flex;flex-direction:column;gap:8px}
.msg-conv{background:white;border:0.5px solid #e8edf2;border-radius:12px;padding:1rem 1.25rem;display:flex;align-items:center;gap:1rem;text-decoration:none;transition:all .2s}
.msg-conv:hover{box-shadow:0 3px 16px rgba(0,0,0,.07);border-color:#B5D4F4}
.msg-conv.non-lu{border-left:3px solid #185FA5;background:#fafcff}
.msg-avatar{width:44px;height:44px;border-radius:50%;background:#042C53;color:white;display:flex;align-items:center;justify-content:center;font-size:15px;font-weight:600;flex-shrink:0;overflow:hidden}
.msg-avatar img{width:100%;height:100%;object-fit:cover}
.msg-info{flex:1;min-width:0}
.msg-top{display:flex;align-items:center;justify-content:space-between;margin-bottom:3px}
.msg-name{font-size:14px;font-weight:600;color:#042C53}
.msg-time{font-size:11px;color:#94a3b8}
.msg-ann{font-size:12px;color:#185FA5;margin-bottom:3px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis}
.msg-preview{font-size:12px;color:#94a3b8;white-space:nowrap;overflow:hidden;text-overflow:ellipsis}
.msg-conv.non-lu .msg-preview{color:#475569;font-weight:500}
.msg-badge{background:#185FA5;color:white;padding:1px 7px;border-radius:20px;font-size:10px;font-weight:600;flex-shrink:0}
.msg-photo{width:44px;height:44px;border-radius:8px;overflow:hidden;background:#f1f5f9;flex-shrink:0;display:flex;align-items:center;justify-content:center}
.msg-photo img{width:100%;height:100%;object-fit:cover}
.msg-empty{text-align:center;padding:3rem 2rem;background:white;border:0.5px solid #e8edf2;border-radius:12px}
</style>

<div class="msg-wrap">
    <div class="msg-header">
        <h1>Messages</h1>
        <p>{{ $totalNonLus > 0 ? $totalNonLus.' message(s) non lu(s)' : 'Toutes vos conversations' }}</p>
    </div>

    @if($conversations->isEmpty())
        <div class="msg-empty">
            <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="#cbd5e1" stroke-width="1.5" style="margin-bottom:.9rem"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>
            <h3 style="font-size:14px;color:#64748b;font-weight:600;margin-bottom:6px">Aucune conversation</h3>
            <p style="font-size:12px;color:#94a3b8;margin-bottom:1rem">Vos échanges apparaîtront ici</p>
            <a href="{{ route('annonces.index') }}" style="display:inline-block;background:#042C53;color:white;padding:9px 20px;border-radius:8px;text-decoration:none;font-size:13px;font-weight:600">Parcourir les annonces</a>
        </div>
    @else
        <div class="msg-list">
            @foreach($conversations as $conv)
                @php
                    $inter   = $conv['interlocuteur'];
                    $annonce = $conv['annonce'];
                    $dernier = $conv['dernier_message'];
                    $nonLus  = $conv['non_lus'];
                    $photo   = $annonce?->photos?->first();
                    $estMoi  = $dernier->sender_id === Auth::id();
                @endphp
                @if($annonce && $inter)
                <a href="{{ route('messages.conversation', [$annonce->id, $inter->id]) }}"
                   class="msg-conv {{ $nonLus > 0 ? 'non-lu' : '' }}">
                    <div class="msg-photo">
                        @if($photo)
                            <img src="{{ asset('storage/'.$photo->url) }}" alt="">
                        @else
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#cbd5e1" stroke-width="1.5"><rect x="3" y="3" width="18" height="18" rx="3"/></svg>
                        @endif
                    </div>
                    <div class="msg-avatar">
                        @if($inter->avatar ?? null)
                            <img src="{{ asset('storage/'.$inter->avatar) }}" alt="">
                        @else
                            {{ strtoupper(substr($inter->name, 0, 1)) }}
                        @endif
                    </div>
                    <div class="msg-info">
                        <div class="msg-top">
                            <span class="msg-name">{{ $inter->name }}</span>
                            <span class="msg-time">{{ $dernier->created_at->diffForHumans() }}</span>
                        </div>
                        <div class="msg-ann">📍 {{ $annonce->titre }}</div>
                        <div class="msg-preview">
                            @if($estMoi)<span style="color:#185FA5">Vous : </span>@endif{{ Str::limit($dernier->contenu, 60) }}
                        </div>
                    </div>
                    @if($nonLus > 0)
                        <span class="msg-badge">{{ $nonLus }}</span>
                    @endif
                </a>
                @endif
            @endforeach
        </div>
    @endif
</div>
@endsection