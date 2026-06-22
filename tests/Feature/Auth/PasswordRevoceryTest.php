<?php

use function Pest\Laravel\get;

it('needs to have a route to password recovery', function () {
    get(route('auth.password.recovery'))
    ->assertOk();

});
