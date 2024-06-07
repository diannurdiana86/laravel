@if (!empty($value) && is_array($value))
    <li class="side-nav-item">
        <a class="text-dark side-nav-link collapsed" data-bs-toggle="collapse" href="#coll{{ $key }}" aria-expanded="false">
            <span class="menu-arrow"></span>
        </a>
        <input type="checkbox" id="{{ $key }}">
        <label for="{{ $key }}">{{ ucwords(preg_replace('/[^\w\s]/u', ' ', $key)) }}{{-- - {{ $key }} --}}</label>
        @if (!empty($value) && is_array($value))
            <ul>
                @foreach ($value as $subKey => $subValue)
                    @include('modules.auth.roles.menucreate', ['thiskey' => $key, 'key' => $subKey, 'value' => $subValue])
                @endforeach
            </ul>
        @endif
    </li>
@else
    <li class="collapse" id="coll{{ $thiskey }}">
        <input type="checkbox" id="{{ $value->name }}" name="permissions[]" value="{{ $value->id }}"
            {{ in_array($value->id, old('permissions') ?? []) ? 'checked' : '' }}>
        <label for="{{ $value->name }}">{{ ucwords($value->title) }}{{-- - {{ $key }} - {{ $thiskey }} --}}</label>
    </li>
@endif
