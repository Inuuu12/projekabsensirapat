<x-layouts.admin :title="$config['title']" :heading="$config['title']">
    @php
        $isEditing = filled($editItem);
        $action = $isEditing
            ? route('admin.crud.update', [$resource, $editItem->getKey()])
            : route('admin.crud.store', $resource);
        $tableFields = collect($config['fields'])->reject(fn ($field) => $field['hideTable'] ?? false);
        $formatValue = function ($item, $field) {
            $value = data_get($item, $field['name']);

            if (isset($field['options']) && $value !== null && array_key_exists($value, $field['options'])) {
                return $field['options'][$value];
            }

            if ($value instanceof \Carbon\CarbonInterface) {
                return $value->format(($field['type'] ?? null) === 'date' ? 'd/m/Y' : 'd/m/Y H:i');
            }

            if (is_bool($value)) {
                return $value ? 'Ya' : 'Tidak';
            }

            return filled($value) ? \Illuminate\Support\Str::limit((string) $value, 80) : '-';
        };
        $inputValue = function ($field) use ($editItem) {
            $name = $field['name'];
            $value = old($name, $editItem ? data_get($editItem, $name) : '');

            if (($field['type'] ?? null) === 'password') {
                return '';
            }

            if ($value instanceof \Carbon\CarbonInterface) {
                return ($field['type'] ?? null) === 'datetime-local'
                    ? $value->format('Y-m-d\TH:i')
                    : $value->format('Y-m-d');
            }

            if (($field['type'] ?? null) === 'datetime-local' && is_string($value) && $value !== '') {
                return str_replace(' ', 'T', substr($value, 0, 16));
            }

            return $value;
        };
    @endphp

    @if (session('success'))
        <div class="panel panel-pad" style="margin-bottom: 18px; color: #007a44; font-weight: 800;">{{ session('success') }}</div>
    @endif

    @if ($errors->any())
        <div class="panel panel-pad" style="margin-bottom: 18px; color: #c9141d; font-weight: 800;">{{ $errors->first() }}</div>
    @endif

    <section class="panel" style="margin-bottom: 22px;">
        <div class="panel-pad">
            <form method="POST" action="{{ $action }}">
                @csrf
                @if ($isEditing)
                    @method('PUT')
                @endif

                <div class="modal-grid">
                    @foreach ($config['fields'] as $field)
                        @php
                            $type = $field['type'] ?? 'text';
                            $required = $field['required'] ?? true;
                            $value = $inputValue($field);
                        @endphp
                        <label class="field-label">{{ $field['label'] }}
                            @if ($type === 'textarea')
                                <textarea name="{{ $field['name'] }}" class="textarea-field" @required($required)>{{ $value }}</textarea>
                            @elseif ($type === 'select')
                                <select name="{{ $field['name'] }}" class="field" @required($required)>
                                    @unless($required)
                                        <option value="">-</option>
                                    @endunless
                                    @foreach (($field['options'] ?? []) as $optionValue => $optionLabel)
                                        <option value="{{ $optionValue }}" @selected((string) $value === (string) $optionValue)>{{ $optionLabel }}</option>
                                    @endforeach
                                </select>
                            @else
                                <input name="{{ $field['name'] }}" type="{{ $type }}" class="field" value="{{ $value }}" @required($required)>
                            @endif
                        </label>
                    @endforeach
                </div>

                <div class="modal-footer">
                    @if ($isEditing)
                        <a href="{{ route('admin.crud.index', $resource) }}" class="btn-ghost">Batal</a>
                    @endif
                    <button type="submit" class="btn-save">@include('partials.icon', ['name' => 'save', 'class' => 'h-4 w-4']) {{ $isEditing ? 'Update' : 'Simpan' }}</button>
                </div>
            </form>
        </div>
    </section>

    <section class="panel">
        <div class="panel-pad">
            <form method="GET" action="{{ route('admin.crud.index', $resource) }}" class="searchbox wide">
                @include('partials.icon', ['name' => 'search', 'class' => 'h-5 w-5'])
                <input name="keyword" type="search" placeholder="Cari {{ strtolower($config['title']) }}..." value="{{ request('keyword') }}">
            </form>
        </div>

        <div class="table-wrap scrollbar-soft">
            <table class="data-table" style="min-width: 1080px;">
                <thead>
                    <tr>
                        <th>ID</th>
                        @foreach ($tableFields as $field)
                            <th>{{ $field['label'] }}</th>
                        @endforeach
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($items as $item)
                        <tr>
                            <td class="mono">{{ $item->getKey() }}</td>
                            @foreach ($tableFields as $field)
                                <td>{{ $formatValue($item, $field) }}</td>
                            @endforeach
                            <td>
                                <div class="actions">
                                    <a href="{{ route('admin.crud.index', [$resource, 'edit' => $item->getKey()]) }}" class="icon-btn edit">@include('partials.icon', ['name' => 'edit', 'class' => 'h-5 w-5'])</a>
                                    <form method="POST" action="{{ route('admin.crud.destroy', [$resource, $item->getKey()]) }}">
                                        @csrf
                                        @method('DELETE')
                                        <button class="icon-btn delete" type="submit">@include('partials.icon', ['name' => 'trash', 'class' => 'h-5 w-5'])</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="{{ $tableFields->count() + 2 }}">Belum ada data.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="table-footer">
            <span>Menampilkan {{ $items->firstItem() ?? 0 }} sampai {{ $items->lastItem() ?? 0 }} dari {{ $items->total() }} data</span>
            {{ $items->links() }}
        </div>
    </section>
</x-layouts.admin>
