<?php

namespace App\Schema;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Str;

class MetaFieldsSchema
{
    public static function applyMeta(Blueprint $table): void
    {
        $table->string('slug')->nullable()->comment('ЧПУ-ссылка для страницы');
        $table->string('meta_title')->nullable()->comment('Мета-заголовок для SEO');
        $table->text('meta_description')->nullable()->comment('Мета-описание для SEO');
    }

    public static function applyContent(Blueprint $table): void
    {
        $table->string('code')->unique()->comment('Короткий символьный код (внутренний)');
        $table->string('name')->comment('Название страницы');
        $table->text('description')->nullable()->comment('Краткое описание');
        $table->longText('content')->nullable()->comment('Основной текст');

        $table->json('comments')->nullable()->comment('Комментарии');
        $table->json('groups')->nullable()->comment('Группы');
        $table->json('tags')->nullable()->comment('Теги');
        $table->json('settings')->nullable()->comment('Настройки');
        $table->json('data')->nullable()->comment('Произвольные данные');
        $table->json('logs')->nullable()->comment('Логи');
    }

    public static function applyMedia(Blueprint $table): void
    {
        self::applyLinks($table);
        self::applyImages($table);
        self::applySounds($table);
        self::applyVideos($table);
    }

    public static function applyLinks(Blueprint $table): void
    {
        $table->string('link')->nullable()->comment('Основная ссылка');
        $table->json('links')->nullable()->comment('Дополнительные ссылки');
    }

    public static function applyImages(Blueprint $table): void
    {
        $table->string('image')->nullable()->comment('Обложка');
        $table->json('images')->nullable()->comment('Галерея');
    }

    public static function applySounds(Blueprint $table): void
    {
        $table->string('sound')->nullable()->comment('Звук');
        $table->json('sounds')->nullable()->comment('Коллекция звуков');
    }

    public static function applyVideos(Blueprint $table): void
    {
        $table->string('video')->nullable()->comment('Видео');
        $table->json('videos')->nullable()->comment('Коллекция видео');
    }
}
