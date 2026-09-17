@extends('admin.layout')

@section('title', 'Users')
@section('page-title', 'User Management')

@section('topbar-actions')
  <a href="{{ route('admin.users.create') }}" class="btn btn-primary btn-sm">
    + New User
  </a>
@endsection

@section('content')

{{-- Stats row --}}
<div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(180px,1fr));gap:14px;margin-bottom:22px;">
  @foreach([['label'=>'All Users','value'=>\App\Models\User::where('role','!=','admin')->count(),'icon'=>'👥','color'=>'var(--primary)'],['label'=>'Companies','value'=>\App\Models\User::where('role','company')->count(),'icon'=>'🏢','color'=>'var(--accent)'],['label'=>'Drivers','value'=>\App\Models\User::where('role','driver')->count(),'icon'=>'🚗','color'=>'#58a6ff']] as $stat)
  <div style="background:var(--surface);border:1px solid var(--border2);border-radius:8px;padding:16px 18px;display:flex;align-items:center;gap:14px;">
    <div style="font-size:26px;">{{ $stat['icon'] }}</div>
    <div>
      <div style="font-size:22px;font-weight:900;color:{{ $stat['color'] }}">{{ $stat['value'] }}</div>
      <div style="font-size:12px;color:var(--text2);font-weight:600;">{{ $stat['label'] }}</div>
    </div>
  </div>
  @endforeach
</div>

{{-- Main card --}}
<div class="card">
  <div class="card-header" style="flex-wrap:wrap;gap:12px;">
    <div class="card-title">Users</div>
    {{-- Filters --}}
    <form method="GET" action="{{ route('admin.users.index') }}" class="filters">
      <input type="text" name="search" value="{{ request('search') }}" placeholder="Search name or email…" />
      <select name="role" onchange="this.form.submit()">
        <option value="">All roles</option>
        <option value="company" {{ request('role') === 'company' ? 'selected' : '' }}>Company</option>
        <option value="driver"  {{ request('role') === 'driver'  ? 'selected' : '' }}>Driver</option>
      </select>
      <button type="submit" class="btn btn-secondary btn-sm">Filter</button>
      @if(request('search') || request('role'))
        <a href="{{ route('admin.users.index') }}" class="btn btn-secondary btn-sm">✕ Clear</a>
      @endif
    </form>
  </div>

  <div class="table-wrap">
    <table>
      <thead>
        <tr>
          <th>#</th>
          <th>Name</th>
          <th>Email</th>
          <th>Role</th>
          <th>Company</th>
          <th>Start Date</th>
          <th>Pay Time</th>
          <th>Joined</th>
          <th></th>
        </tr>
      </thead>
      <tbody>
        @forelse($users as $user)
        <tr>
          <td style="color:var(--text2);font-size:12px;">{{ $user->id }}</td>
          <td>
            <div style="display:flex;align-items:center;gap:10px;">
              <div style="width:32px;height:32px;border-radius:6px;background:var(--primary-soft);display:flex;align-items:center;justify-content:center;font-weight:800;color:var(--primary-strong);font-size:13px;flex-shrink:0;">
                {{ strtoupper(substr($user->name,0,1)) }}
              </div>
              <span style="font-weight:600;">{{ $user->name }}</span>
            </div>
          </td>
          <td style="color:var(--text2);">{{ $user->email }}</td>
          <td>
            <span class="badge badge-{{ $user->role }}">{{ ucfirst($user->role) }}</span>
          </td>
          <td style="color:var(--text2);">{{ $user->company?->name ?? '—' }}</td>
          <td style="color:var(--text2);">{{ $user->start_date ?? '—' }}</td>
          <td style="color:var(--text2);">{{ $user->payment_time ? \Carbon\Carbon::createFromFormat('H:i:s',$user->payment_time)->format('g:i A') : '—' }}</td>
          <td style="color:var(--text2);font-size:12px;">{{ $user->created_at->format('M d, Y') }}</td>
          <td>
            <div style="display:flex;gap:6px;justify-content:flex-end;">
              <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-secondary btn-sm btn-icon" title="Edit">✏️</a>
              <form method="POST" action="{{ route('admin.users.destroy', $user) }}" onsubmit="return confirm('Delete {{ addslashes($user->name) }}?')">
                @csrf @method('DELETE')
                <button type="submit" class="btn btn-danger btn-sm btn-icon" title="Delete">🗑</button>
              </form>
            </div>
          </td>
        </tr>
        @empty
        <tr><td colspan="9">
          <div class="empty-state">
            <div class="empty-icon">👤</div>
            <div class="empty-title">No users found</div>
            <p>Try changing your filter or add a new user.</p>
          </div>
        </td></tr>
        @endforelse
      </tbody>
    </table>
  </div>

  {{-- Pagination --}}
  @if($users->hasPages())
  <div style="padding:16px 20px;border-top:1px solid var(--border2);display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:10px;">
    <span style="font-size:12.5px;color:var(--text2);">
      Showing {{ $users->firstItem() }}–{{ $users->lastItem() }} of {{ $users->total() }} users
    </span>
    <div class="pagination">
      {{-- Previous --}}
      @if($users->onFirstPage())
        <span class="disabled">‹</span>
      @else
        <a href="{{ $users->previousPageUrl() }}">‹</a>
      @endif

      {{-- Pages --}}
      @foreach($users->getUrlRange(max(1,$users->currentPage()-2), min($users->lastPage(),$users->currentPage()+2)) as $page => $url)
        @if($page == $users->currentPage())
          <span class="active">{{ $page }}</span>
        @else
          <a href="{{ $url }}">{{ $page }}</a>
        @endif
      @endforeach

      {{-- Next --}}
      @if($users->hasMorePages())
        <a href="{{ $users->nextPageUrl() }}">›</a>
      @else
        <span class="disabled">›</span>
      @endif
    </div>
  </div>
  @endif
</div>

@endsection
