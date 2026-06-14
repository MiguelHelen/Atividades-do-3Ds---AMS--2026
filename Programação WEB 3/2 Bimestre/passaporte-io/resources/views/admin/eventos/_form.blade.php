<div class="grid md:grid-cols-2 gap-4">
    <div class="form-control md:col-span-2">
        <label class="label" for="title">
            <span class="label-text font-medium">Título do evento</span>
        </label>
        <input type="text" name="title" id="title" value="{{ old('title', $evento->title ?? '') }}"
               class="input input-bordered w-full @error('title') input-error @enderror"
               placeholder="Ex: Laravel Conf Brasil 2026" required>
        @error('title')
            <span class="text-error text-sm mt-1">{{ $message }}</span>
        @enderror
    </div>

    <div class="form-control md:col-span-2">
        <label class="label" for="description">
            <span class="label-text font-medium">Descrição</span>
        </label>
        <textarea name="description" id="description" rows="4"
                  class="textarea textarea-bordered w-full @error('description') textarea-error @enderror"
                  placeholder="Descreva o evento em detalhes..." required>{{ old('description', $evento->description ?? '') }}</textarea>
        @error('description')
            <span class="text-error text-sm mt-1">{{ $message }}</span>
        @enderror
    </div>

    <div class="form-control">
        <label class="label" for="date_time">
            <span class="label-text font-medium">Data e hora</span>
        </label>
        <input type="datetime-local" name="date_time" id="date_time"
               value="{{ old('date_time', isset($evento) ? $evento->date_time->format('Y-m-d\TH:i') : '') }}"
               class="input input-bordered w-full @error('date_time') input-error @enderror" required>
        @error('date_time')
            <span class="text-error text-sm mt-1">{{ $message }}</span>
        @enderror
    </div>

    <div class="form-control">
        <label class="label" for="category_id">
            <span class="label-text font-medium">Categoria</span>
        </label>
        <select name="category_id" id="category_id"
                class="select select-bordered w-full @error('category_id') select-error @enderror" required>
            <option value="" disabled {{ old('category_id', $evento->category_id ?? '') ? '' : 'selected' }}>Selecione...</option>
            @foreach($categorias as $categoria)
                <option value="{{ $categoria->id }}"
                    {{ old('category_id', $evento->category_id ?? '') == $categoria->id ? 'selected' : '' }}>
                    {{ $categoria->name }}
                </option>
            @endforeach
        </select>
        @error('category_id')
            <span class="text-error text-sm mt-1">{{ $message }}</span>
        @enderror
    </div>

    <div class="form-control md:col-span-2">
        <label class="label" for="location">
            <span class="label-text font-medium">Localização</span>
        </label>
        <input type="text" name="location" id="location" value="{{ old('location', $evento->location ?? '') }}"
               class="input input-bordered w-full @error('location') input-error @enderror"
               placeholder="Ex: Centro de Convenções, São Paulo - SP" required>
        @error('location')
            <span class="text-error text-sm mt-1">{{ $message }}</span>
        @enderror
    </div>

    <div class="form-control">
        <label class="label" for="capacity">
            <span class="label-text font-medium">Vagas disponíveis</span>
        </label>
        <input type="number" name="capacity" id="capacity" min="1" value="{{ old('capacity', $evento->capacity ?? '') }}"
               class="input input-bordered w-full @error('capacity') input-error @enderror"
               placeholder="Ex: 100" required>
        @error('capacity')
            <span class="text-error text-sm mt-1">{{ $message }}</span>
        @enderror
    </div>

    <div class="form-control">
        <label class="label" for="banner">
            <span class="label-text font-medium">
                Banner do evento
                @if(isset($evento))
                    <span class="text-base-content/50 font-normal">(deixe vazio para manter o atual)</span>
                @endif
            </span>
        </label>
        <input type="file" name="banner" id="banner" accept="image/*"
               class="file-input file-input-bordered w-full @error('banner') file-input-error @enderror">
        <span class="text-xs text-base-content/50 mt-1">Imagem até 2MB.</span>
        @error('banner')
            <span class="text-error text-sm mt-1">{{ $message }}</span>
        @enderror
    </div>

    @if(isset($evento) && $evento->banner_path)
        <div class="md:col-span-2">
            <p class="label-text font-medium mb-2">Banner atual:</p>
            <img src="{{ $evento->bannerUrl() }}" alt="Banner atual" class="rounded-box max-h-48 object-cover">
        </div>
    @endif
</div>