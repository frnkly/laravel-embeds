<?php

namespace Frnkly\Spec\Suite;

use Kahlan\Plugin\Stub;
use Frnkly\Spec\MockModels\Article;

describe('Model', function() {

    $model = new Article;

    it('tests Khalan', function() {

        expect(true)->toBeTruthy();

    });
});
