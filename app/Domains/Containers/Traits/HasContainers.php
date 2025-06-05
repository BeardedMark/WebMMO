<?php

namespace App\Traits;

use App\Services\Instances\ContainerInstance;
use Illuminate\Support\Collection;

trait HasContainers
{
    public function getContainers(): Collection
    {
        return collect($this->containers ?? [])->map(fn($data) => new ContainerInstance($data));
    }

    public function addContainer(ContainerInstance $new): void
    {
        $list = $this->getContainers();
        $added = false;

        foreach ($list as $container) {
            if (
                $container->getCode() === $new->getCode()
                // $container->getModifierInstances() == $new->getModifierInstances() &&
                // $container->getProperties() == $new->getProperties()
            ) {
                // Увеличиваем стек
                $container->data['stack'] += $new->getStack();
                $added = true;
                break;
            }
        }

        if (!$added) {
            // Назначаем uuid, если нет
            if (!$new->getUuid()) {
                $new->setUuid();
            }
            $list->push($new);
        }

        $this->containers = $list->map(fn($e) => $e->toArray())->toArray();
        $this->save();
    }

    public function addContainers(array $containers): void
    {
        foreach ($containers as $container) {
            if ($container instanceof ContainerInstance) {
                $this->addContainer($container);
            }
        }
    }

    public function removeContainerByUuid(string $uuid): void
    {
        $this->containers = $this->getContainers()
            ->reject(fn($e) => $e->getUuid() === $uuid)
            ->map(fn($e) => $e->toArray())
            ->toArray();
        $this->save();
    }

    public function findContainerByCode(string $code): ?Collection
    {
        return $this->getContainers()->filter(fn($e) => $e->getCode() === $code);
    }

    public function hasContainerByCode(string $code): bool
    {
        return $this->findContainerByCode($code)->isNotEmpty();
    }

    public function findContainerByUuid(string $uuid): ?ContainerInstance
    {
        return $this->getContainers()->first(fn($container) => $container->getUuid() === $uuid);
    }
}
