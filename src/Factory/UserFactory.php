<?php

namespace App\Factory;

use App\Entity\User;
use App\Repository\UserRepository;
use Zenstruck\Foundry\ModelFactory;
use Zenstruck\Foundry\Proxy;
use Zenstruck\Foundry\RepositoryProxy;
use Illuminate\Support\Str;
use Orchestra\Testbench\Factories\UserFactory as BaseUserFactory;

/**
 * @extends ModelFactory<User>
 *
 * @method        User|Proxy create(array|callable $attributes = [])
 * @method static User|Proxy createOne(array $attributes = [])
 * @method static User|Proxy find(object|array|mixed $criteria)
 * @method static User|Proxy findOrCreate(array $attributes)
 * @method static User|Proxy first(string $sortedField = 'id')
 * @method static User|Proxy last(string $sortedField = 'id')
 * @method static User|Proxy random(array $attributes = [])
 * @method static User|Proxy randomOrCreate(array $attributes = [])
 * @method static UserRepository|RepositoryProxy repository()
 * @method static User[]|Proxy[] all()
 * @method static User[]|Proxy[] createMany(int $number, array|callable $attributes = [])
 * @method static User[]|Proxy[] createSequence(iterable|callable $sequence)
 * @method static User[]|Proxy[] findBy(array $attributes)
 * @method static User[]|Proxy[] randomRange(int $min, int $max, array $attributes = [])
 * @method static User[]|Proxy[] randomSet(int $number, array $attributes = [])
 */
final class UserFactory extends ModelFactory
{
    protected $faker;
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
        $baseEmail = 'user'; // Base email address
    $counter = $this->faker()->unique()->numberBetween(1, 100); // Generate a unique counter

    $email = sprintf('%s%d@example.com', $baseEmail, $counter); // Generate unique email

    $roles = ['ROLE_ADMIN', 'ROLE_USER']; // Define available roles

    // Select a random role from the available roles
    $randomRole = $roles[array_rand($roles)];

    return [
        'email' => $email,// you can generate one unique email
        'locale' => 'fr',
        'password' => '$2y$13$w7usfxJhm1MP8qjT8TDNzOq.UuYWFuZszfwqX/agMwG8JeqWgacZ.', // you have to leave the encoded password as is, it's related to 123456
        'roles' => [$randomRole], // Set the randomly selected role
        'username' => 'Admin', // 'category' => self::faker()->realtext(10), you can do same to username so that it can change the name
        'is_verified' => 1,
        
        ];

    }
    /*
    why all that? it is because when creating user i havent yet configure the send email by symfony so we can't register
    until i configure that but we can login that is while 
    But finally not just for that because the Fixtures help us to add data very fastly in the database 
    hope it would help 
    Don't forget when login the password should be: 123456
    */

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
     */
    protected function initialize(): self
    {
        return $this
            // ->afterInstantiate(function(User $user): void {})
        ;
    }

    protected static function getClass(): string
    {
        return User::class;
    }
}
