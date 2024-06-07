@if (!empty($value) && is_array($value) && !is_int($key))
    <li>
        <label for="{{ $key }}">{{ ucwords(preg_replace('/[^\w\s]/u', ' ', $key)) }}</label>
        @if (!empty($value) && is_array($value))
            <ul>
                @foreach ($value as $subKey => $subValue)
                    @include('modules.auth.roles.menushow', ['key' => $subKey, 'value' => $subValue])
                @endforeach
            </ul>
        @endif
    </li>
@else
    <li>
        <input type="checkbox" {{ in_array($value->id, $rolePermissions ?? []) ? 'checked' : '' }}
            onclick="return false;">
        <label>{{ ucwords($value->title) }}</label>
    </li>
@endif
