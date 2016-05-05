(function() {
    'use strict';

    var test = require('colored-tape'),
        runOptionsTest = require('./common.js').runOptionsTest;

    test('afterEach', function(t) {
        runOptionsTest(t, {
            afterEach: 'afterEachTest!'
        });
    });
}());
