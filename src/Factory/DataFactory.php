<?php

namespace App\Factory;

use App\Entity\Data;
use App\Repository\DataRepository;
use Zenstruck\Foundry\ModelFactory;
use Zenstruck\Foundry\Proxy;
use Zenstruck\Foundry\RepositoryProxy;

/**
 * @extends ModelFactory<Data>
 *
 * @method        Data|Proxy create(array|callable $attributes = [])
 * @method static Data|Proxy createOne(array $attributes = [])
 * @method static Data|Proxy find(object|array|mixed $criteria)
 * @method static Data|Proxy findOrCreate(array $attributes)
 * @method static Data|Proxy first(string $sortedField = 'id')
 * @method static Data|Proxy last(string $sortedField = 'id')
 * @method static Data|Proxy random(array $attributes = [])
 * @method static Data|Proxy randomOrCreate(array $attributes = [])
 * @method static DataRepository|RepositoryProxy repository()
 * @method static Data[]|Proxy[] all()
 * @method static Data[]|Proxy[] createMany(int $number, array|callable $attributes = [])
 * @method static Data[]|Proxy[] createSequence(iterable|callable $sequence)
 * @method static Data[]|Proxy[] findBy(array $attributes)
 * @method static Data[]|Proxy[] randomRange(int $min, int $max, array $attributes = [])
 * @method static Data[]|Proxy[] randomSet(int $number, array $attributes = [])
 */
final class DataFactory extends ModelFactory
{
    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#factories-as-services
     *
     * @todo inject services if required
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#model-factories
     *
     * @todo add your default values here
     */
    protected function getDefaults(): array
    {
        return [
            'measuredValue' => self::faker()->numberBetween(1, 100),
            //'module' => ModuleFactory::new(),
            'speed' =>self::faker()->numberBetween(1, 100), // Generate a random float between 1 and 100
            'temperature' => self::faker()->numberBetween(1, 100),
            'workingTime' => self::faker()->dateTime(),
            'module' => ModuleFactory::new()->create(),
        ];
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
     */
    protected function initialize(): self
    {
        return $this
            // ->afterInstantiate(function(Data $data): void {})
        ;
    }

    protected static function getClass(): string
    {
        return Data::class;
    }
}
