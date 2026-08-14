<?php

use App\Livewire\Customers\Index;
use App\Models\{Customer, Permission, User};
use Illuminate\Pagination\LengthAwarePaginator;
use Livewire\Livewire;

use function Pest\Laravel\{actingAs, get};

it('should be to access the route customers', function () {
    actingAs(User::factory()->create());

    get(route('customers'))
        ->assertOk();
});

test('let is create a livewire componente to list all customers in the page.', function () {
    actingAs(User::factory()->create());
    $customers = Customer::factory()->count(10)->create();

    $lw = Livewire::test(Index::class);

    $lw->assertSet('customers', function ($customers) {
        expect($customers)
            ->toHaveCount(10);

        return true;
    });

    foreach ($customers as $item) {
        $lw->assertSee($item->name);
    }
});

test('check the table format', function () {
    actingAs(User::factory()->create());

    Livewire::test(Index::class)
        ->assertSet('headers', [
            [
                'key'           => 'id',
                'label'         => '#',
                'sortColumnBy'  => 'id',
                'sortDirection' => 'asc',
            ],
            [
                'key'           => 'name',
                'label'         => 'Name',
                'sortColumnBy'  => 'id',
                'sortDirection' => 'asc',
            ],
            [
                'key'           => 'email',
                'label'         => 'Email',
                'sortColumnBy'  => 'id',
                'sortDirection' => 'asc',
            ],
            [
                'key'           => 'actions',
                'label'         => 'Actions',
                'sortColumnBy'  => null,
                'sortDirection' => null,
            ],
        ]);
});

it('should be able to filter by name and email', function () {
    Customer::factory()->create(['name' => 'Joe Doe', 'email' => 'admin@gmail.com']);
    $user  = User::factory()->create();
    $mario = Customer::factory()->create(
        [
            'name'  => 'Mario Rossi',
            'email' => 'little_guy@example.com',
        ]
    );

    actingAs($user);

    Livewire::test(Index::class)
        ->assertSet('customers', function ($customers) {
            expect($customers)
                ->toHaveCount(2);

            return true;
        })
        ->set('search', 'mar')
        ->assertSet('customers', function ($customers) use ($mario) {
            expect($customers)
                ->toHaveCount(1)
                ->and($customers->first()->name)->toBe($mario->name);

            return true;
        })
        ->set('search', 'guy')
        ->assertSet('customers', function ($customers) use ($mario) {
            expect($customers)
                ->toHaveCount(1)
                ->and($customers->first()->name)->toBe($mario->name);

            return true;
        });
});

it('should be able to sort by name', function () {
    $joe  = Customer::factory()->create(['name' => 'Joe Doe', 'email' => 'admin@gmail.com']);
    $user = User::factory()->create();

    $mario = Customer::factory()->create(
        [
            'name'  => 'Mario Rossi',
            'email' => 'little_guy@example.com',
        ]
    );

    actingAs($user);

    Livewire::test(Index::class)
        ->set('sortDirection', 'asc')
        ->set('sortColumnBy', 'name')
        ->assertSet('customers', function ($customers) use ($joe, $mario) {
            expect($customers)
                ->first()->name->toBe($joe->name)
                ->and($customers)->last()->name->toBe($mario->name);

            return true;
        })
        ->set('sortDirection', 'desc')
        ->assertSet('customers', function ($customers) use ($joe, $mario) {
            expect($customers)
                ->first()->name->toBe($mario->name)
                ->and($customers)->last()->name->toBe($joe->name);

            return true;
        });
});

it('should be able to paginate the result', function () {
    $joe  = Customer::factory()->create(['name' => 'Joe Doe', 'email' => 'admin@gmail.com']);
    $user = User::factory()->create();

    Customer::factory()->count(30)->create();

    actingAs($user);

    Livewire::test(Index::class)
        ->assertSet('customers', function (LengthAwarePaginator $customers) {
            expect($customers)
                ->toHaveCount(15);

            return true;
        })
        ->set('perPage', 20)
        ->assertSet('customers', function ($customers) {
            expect($customers)->toHaveCount(20);

            return true;
        });
});
