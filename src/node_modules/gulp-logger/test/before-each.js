(function() {
    'use strict';

    var test = require('colored-tape'),
        runOptionsTest = require('./common.js').runOptionsTest;

    test('beforeEach', function(t) {
        runOptionsTest(t, {
            beforeEach: 'beforeEachTest!'
        });
    });
}());
