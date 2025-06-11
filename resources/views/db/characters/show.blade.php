@extends('layouts.container')

@section('content')
    <div class="row">
        <div class="col">
            <div class="flex-col-13">
                <div class="flex-col-8 pad-13">
                    <h1 class="color-brand">Подробности о персонаже</h1>
                    <p class="font-lg">Информация, показатели и статистика персонажа</p>
                </div>

                <div class="flex-col-8 pad-13">
                    @isset($character->description)
                        <h2>{{ $character->description }}</h2>
                    @endisset

                    @isset($character->content)
                        <p>{{ $character->content }}</p>
                    @endisset
                </div>

                <div class="flex-col-8 pad-13">
                    <h3>Характеристики</h3>

                    <div class="flex-col color-second">
                        @component('components.stat', ['name' => 'Сила', 'value' => $character->getStrength()])
                        @endcomponent
                        @component('components.stat', ['name' => 'Ловкость', 'value' => $character->getAgility()])
                        @endcomponent
                        @component('components.stat', ['name' => 'Интеллект', 'value' => $character->getIntelligence()])
                        @endcomponent
                    </div>
                </div>

                <div class="flex-col-8 pad-13">
                    <h3>Показатели</h3>

                    <div class="flex-col color-second">
                        @component('components.stat', ['name' => 'Всего здоровья', 'value' => $character->getHealth()])
                        @endcomponent
                        @component('components.stat', ['name' => 'Текущее здоровье', 'value' => $character->getCurrentHealth()])
                        @endcomponent
                        @component('components.stat', ['name' => 'Регенерация здоровья в сек', 'value' => $character->getRegen()])
                        @endcomponent
                        @component('components.stat', ['name' => 'Состояние здоровья', 'value' => $character->getHealthPercent() . ' %'])
                        @endcomponent

                        @component('components.stat', ['name' => 'Урон', 'value' => $character->getDamage()])
                        @endcomponent
                    </div>

                    <div class="flex-col color-second">
                        @component('components.stat', ['name' => 'Максимальный вес', 'value' => $character->maxWeight() . ' кг'])
                        @endcomponent
                        @component('components.stat', ['name' => 'Переносимый вес', 'value' => $character->getTotalWeight() . ' кг'])
                        @endcomponent
                        @component('components.stat', [
                            'name' => 'Недовес',
                            'value' => $character->maxWeight() - $character->getTotalWeight() . ' кг',
                        ])
                        @endcomponent
                        @component('components.stat', ['name' => 'Перевес', 'value' => $character->overWeight() . ' кг'])
                        @endcomponent
                        @component('components.stat', ['name' => 'Скорость передвижения', 'value' => $character->getMoveSpeed() . ' км/ч'])
                        @endcomponent
                        @component('components.stat', ['name' => 'Выпадение предметов', 'value' => $character->dropChanceBonus() . ' %'])
                        @endcomponent
                    </div>
                </div>

                <div class="flex-col-8 pad-13">
                    <h3>Опыт персонажа</h3>

                    <div class="flex-col color-second">
                        @component('components.stat', ['name' => 'Текущий уровень', 'value' => $character->getLevel() . ' ур'])
                        @endcomponent
                        @component('components.stat', ['name' => 'Прогресс уровня', 'value' => $character->getLevelPercent() . ' %'])
                        @endcomponent
                        @component('components.stat', [
                            'name' => 'Для текущего уровня',
                            'value' => $character->experienceToCurrentLevel() . ' оп',
                        ])
                        @endcomponent
                        @component('components.stat', ['name' => 'Текущий опыт', 'value' => $character->getExperience() . ' оп'])
                        @endcomponent
                        @component('components.stat', [
                            'name' => 'Для следующего уровня',
                            'value' => $character->experienceToNextLevel() . ' оп',
                        ])
                        @endcomponent
                        @component('components.stat', [
                            'name' => 'Нужно до следующего уровня',
                            'value' => $character->experienceToNextLevel() - $character->experienceToCurrentLevel() . ' оп',
                        ])
                        @endcomponent
                        @component('components.stat', [
                            'name' => 'Осталось до следующего уровня',
                            'value' =>
                                $character->experienceToNextLevel() -
                                $character->experienceToCurrentLevel() -
                                ($character->getExperience() - $character->experienceToCurrentLevel()) .
                                ' оп',
                        ])
                        @endcomponent
                        @component('components.stat', [
                            'name' => 'От текущего уровня',
                            'value' => $character->getExperience() - $character->experienceToCurrentLevel() . ' оп',
                        ])
                        @endcomponent
                    </div>
                </div>

                <div class="flex-col-8 pad-13">
                    <h3>Статистика</h3>

                    <div class="flex-col color-second">
                        @component('components.stat', ['name' => 'Посещено локаций', 'value' => count($character->visitedLocations())])
                        @endcomponent

                        @component('components.stat', [
                            'name' => 'Совершено переходов',
                            'value' => count($character->allTransitions()->get()),
                        ])
                        @endcomponent
                    </div>
                </div>

                <div>
                    <h3 class="pad-13">JSON представление</h3>

                    <details class="pad-13">
                        <summary>Показать / Скрыть</summary>
                        <pre><code>{{ $character->getJson() }}</code></pre>
                    </details>
                </div>
            </div>

        </div>

        <div class="col col-4">
            <div class="flex-col-5">
                @component('db.characters.frames.card', compact('character'))
                @endcomponent

                @component('db.characters.frames.info', compact('character'))
                @endcomponent
            </div>
        </div>
    </div>
@endsection
