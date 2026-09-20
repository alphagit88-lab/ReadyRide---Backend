@extends('admin.layout')

@section('title', 'Settings')
@section('page-title', 'Settings')

@section('content')
  <div style="max-width: 720px;">

    {{-- ── Driver Conditions ─────────────────────────────── --}}
    <div class="card" style="margin-bottom: 24px;">
      <div class="card-header">
        <span style="font-size:16px;">📋</span>
        <div style="flex:1;">
          <div class="card-title">Driver Conditions</div>
          <div style="font-size:12px;color:var(--text2);margin-top:2px;">Shown read-only to all drivers in the mobile app
            under "Conditions".</div>
        </div>
      </div>
      <div style="padding:24px;">
        <form method="POST" action="{{ route('admin.settings.update') }}">
          @csrf
          @method('PUT')
          <input type="hidden" name="key" value="conditions" />
          <div class="form-group full" style="margin-bottom:20px;">
            <label for="conditions_value">Conditions Text</label>
            <textarea id="conditions_value" name="value" rows="14"
              placeholder="Enter your driver conditions, rules, or terms here…" style="resize:vertical;line-height:1.6;"
              onfocus="this.style.borderColor='var(--primary)';this.style.boxShadow='0 0 0 3px rgba(201,226,101,.15)'"
              onblur="this.style.borderColor='';this.style.boxShadow=''">{{ old('value', $conditions) }}</textarea>
            <span class="form-hint">Supports plain text. Line breaks are preserved.</span>
          </div>
          <div style="display:flex;justify-content:flex-end;">
            <button type="submit" class="btn btn-primary">💾 Save</button>
          </div>
        </form>
      </div>
    </div>

    {{-- Future settings sections can be added below --}}

  </div>
@endsection