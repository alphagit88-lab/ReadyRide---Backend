@extends('admin.layout')

@php $isEdit = isset($user); @endphp

@section('title', $isEdit ? 'Edit User' : 'New User')
@section('page-title', $isEdit ? 'Edit User' : 'Add New User')

@section('topbar-actions')
  <a href="{{ route('admin.users.index') }}" class="btn btn-secondary btn-sm">← Back to Users</a>
@endsection

@section('content')

<div style="max-width:700px;">
  <div class="card">
    <div class="card-header">
      <div class="card-title">{{ $isEdit ? 'Edit: ' . $user->name : 'Create a new user' }}</div>
    </div>
    <div style="padding:24px;">
      <form
        method="POST"
        action="{{ $isEdit ? route('admin.users.update', $user) : route('admin.users.store') }}"
        id="user-form"
      >
        @csrf
        @if($isEdit) @method('PUT') @endif

        <div class="form-grid">

          {{-- Name --}}
          <div class="form-group">
            <label for="name">Full Name</label>
            <input id="name" type="text" name="name" value="{{ old('name', $user->name ?? '') }}" placeholder="John Doe" required />
            @error('name')<span class="field-error">{{ $message }}</span>@enderror
          </div>

          {{-- Email --}}
          <div class="form-group">
            <label for="email">Email Address</label>
            <input id="email" type="email" name="email" value="{{ old('email', $user->email ?? '') }}" placeholder="john@example.com" required />
            @error('email')<span class="field-error">{{ $message }}</span>@enderror
          </div>

          {{-- Password --}}
          <div class="form-group">
            <label for="password">{{ $isEdit ? 'New Password' : 'Password' }}</label>
            <input id="password" type="password" name="password" placeholder="{{ $isEdit ? 'Leave blank to keep current' : 'Min 6 characters' }}" {{ $isEdit ? '' : 'required' }} />
            @error('password')<span class="field-error">{{ $message }}</span>@enderror
            @if($isEdit)<span class="form-hint">Leave blank to keep the current password.</span>@endif
          </div>

          {{-- Role --}}
          <div class="form-group">
            <label for="role">Role</label>
            <select id="role" name="role" onchange="onRoleChange(this.value)" required>
              <option value="">Select role…</option>
              <option value="company" {{ old('role', $user->role ?? '') === 'company' ? 'selected' : '' }}>🏢 Company</option>
              <option value="driver"  {{ old('role', $user->role ?? '') === 'driver'  ? 'selected' : '' }}>🚗 Driver</option>
            </select>
            @error('role')<span class="field-error">{{ $message }}</span>@enderror
          </div>

        </div>

        {{-- Driver-only fields (shown/hidden by JS) --}}
        <div id="driver-fields" style="display:none;margin-top:18px;border-top:1px solid var(--border2);padding-top:18px;">
          <div style="font-size:12px;font-weight:700;color:var(--text2);text-transform:uppercase;letter-spacing:.5px;margin-bottom:14px;">Driver Details</div>
          <div class="form-grid">

            {{-- Company --}}
            <div class="form-group">
              <label for="company_id">Assign to Company</label>
              <select id="company_id" name="company_id">
                <option value="">— No Company —</option>
                @foreach($companies as $company)
                  <option value="{{ $company->id }}"
                    {{ old('company_id', $user->company_id ?? '') == $company->id ? 'selected' : '' }}>
                    {{ $company->name }}
                  </option>
                @endforeach
              </select>
              @error('company_id')<span class="field-error">{{ $message }}</span>@enderror
            </div>

            {{-- Start Date --}}
            <div class="form-group">
              <label for="start_date">Start Date</label>
              <input id="start_date" type="date" name="start_date"
                value="{{ old('start_date', isset($user) ? $user->start_date : '') }}" />
              <span class="form-hint">The date the driver started working.</span>
              @error('start_date')<span class="field-error">{{ $message }}</span>@enderror
            </div>

            {{-- Payment Time --}}
            <div class="form-group">
              <label for="payment_time">Daily Payment Due Time</label>
              <input id="payment_time" type="time" name="payment_time"
                value="{{ old('payment_time', isset($user) && $user->payment_time ? \Carbon\Carbon::createFromFormat('H:i:s', $user->payment_time)->format('H:i') : '') }}" />
              <span class="form-hint">Driver must submit payment before this time daily.</span>
              @error('payment_time')<span class="field-error">{{ $message }}</span>@enderror
            </div>

          </div>
        </div>

        {{-- Actions --}}
        <div style="display:flex;gap:10px;margin-top:24px;border-top:1px solid var(--border2);padding-top:20px;">
          <button type="submit" class="btn btn-primary">
            {{ $isEdit ? '✓ Save Changes' : '+ Create User' }}
          </button>
          <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">Cancel</a>
        </div>
      </form>
    </div>
  </div>
</div>

@endsection

@push('scripts')
<script>
  function onRoleChange(role) {
    const df = document.getElementById('driver-fields');
    df.style.display = role === 'driver' ? 'block' : 'none';

    // Make company_id and start_date not required for companies
    const ci = document.getElementById('company_id');
    const sd = document.getElementById('start_date');
    const pt = document.getElementById('payment_time');
    [ci, sd, pt].forEach(el => el && (el.required = false));
  }

  // Init on page load
  document.addEventListener('DOMContentLoaded', function() {
    const roleVal = document.getElementById('role').value;
    if (roleVal) onRoleChange(roleVal);
  });
</script>
@endpush
