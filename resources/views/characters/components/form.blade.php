<div class="flex-col-13">
    <div class="flex-col">
        <label class="form-label">Имя персонажа</label>
        <input type="text" name="name" class="input form-control" value="{{ old('name', $location->name ?? '') }}"
            required>
    </div>
</div>
