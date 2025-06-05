<?php

namespace App\Traits;
use Illuminate\Database\Eloquent\Builder;

trait HasMetaFields
{
    public function getId(): int
    {
        return $this->id;
    }

    public function getCode(): string
    {
        return $this->code;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }



    public function getTagLine(): array
    {
        return explode(',', $this->tags ?? '');
    }
    /**
     * Предметы, содержащие конкретный тег
     */
    public static function withTag(string $tag)
    {
        return static::query()->whereJsonContains('tags', $tag)->get();
    }

    /**
     * Предметы, содержащие хотя бы один из указанных тегов
     */
    public static function withAnyTags(array $tags)
    {
        return static::query()->where(function (Builder $q) use ($tags) {
            foreach ($tags as $tag) {
                $q->orWhereJsonContains('tags', $tag);
            }
        })->get();
    }

    /**
     * Предметы, содержащие все указанные теги
     */
    public static function withAllTags(array $tags)
    {
        return static::query()->where(function (Builder $q) use ($tags) {
            foreach ($tags as $tag) {
                $q->whereJsonContains('tags', $tag);
            }
        })->get();
    }

    public function getImageUrl(): ?string
    {
        return $this->image ? asset(($this->imagesDirectory ?? 'storage/images/') . $this->image) : null;
    }

    public function getSoundUrl(): ?string
    {
        return $this->sound ? asset(($this->soundsDirectory ?? 'storage/sounds/') . $this->sound) : null;
    }

    public function isPublished(): bool
    {
        return $this->published_at !== null && $this->published_at <= now();
    }

    public function isActive(): bool
    {
        return (bool) $this->is_active;
    }
}
