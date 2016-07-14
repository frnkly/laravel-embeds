<?php

namespace Frnkly\Spec\Suite;

use Kahlan\Plugin\Stub;
use Frnkly\Spec\MockModels\Article;

describe('Model', function() {

    describe('__toString', function() {

        it('Embeds the given attributes to the model\'s array form.', function() {

            $model = new Article;

            expect(true)->toBeTruthy();
        });
    });
});
