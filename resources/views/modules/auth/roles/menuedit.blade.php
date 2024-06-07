@if (!empty($value) && is_array($value) && !is_int($key))
    <li>
        <input type="checkbox" id="{{ $key }}">
        <label for="{{ $key }}">{{ ucwords(preg_replace('/[^\w\s]/u', ' ', $key)) }}</label>
        @if (!empty($value) && is_array($value))
            <ul>
                @foreach ($value as $subKey => $subValue)
                    @include('modules.auth.roles.menuedit', ['key' => $subKey, 'value' => $subValue])
                @endforeach
            </ul>
        @endif
    </li>
@else
    <li>
        <input type="checkbox" id="{{ $value->name }}" name="permissions[]" value="{{ $value->id }}"
            {{ in_array($value->id, $rolePermissions ?? []) ? 'checked' : '' }}>
        <label for="{{ $value->name }}">{{ ucwords($value->title) }}</label>
    </li>
@endif
