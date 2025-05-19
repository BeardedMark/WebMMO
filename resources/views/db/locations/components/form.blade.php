<div class="mb-3">
    <label class="form-label">Название</label>
    <input type="text" name="name" class="input form-control" value="{{ old('name', $location->name ?? '') }}" required>
</div>

<div class="mb-3">
    <label class="form-label">Описание</label>
    <input type="text" name="description" class="input form-control" value="{{ old('description', $location->description ?? '') }}">
</div>

<div class="mb-3">
    <label class="form-label">Уровень</label>
    <input type="number" name="level" class="input form-control" value="{{ old('level', $location->level ?? 0) }}">
</div>

<div class="mb-3">
    <label class="form-label">Размер</label>
    <input type="number" name="size" class="input form-control" value="{{ old('size', $location->getSize() ?? 1) }}">
</div>

<div class="mb-3">
    <label class="form-label">X</label>
    <input type="number" name="x" class="input form-control" value="{{ old('x', $location->x ?? 0) }}">
</div>

<div class="mb-3">
    <label class="form-label">Y</label>
    <input type="number" name="y" class="input form-control" value="{{ old('y', $location->y ?? 0) }}">
</div>

<div class="form-check mb-3">
    <input class="form-check-input" type="checkbox" name="is_open" value="1"
        {{ old('is_open', $location->is_open ?? true) ? 'checked' : '' }}>
    <label class="form-check-label">Открыта</label>
</div>
