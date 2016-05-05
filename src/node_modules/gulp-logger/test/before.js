(function() {
    'use strict';

    var test = require('colored-tape'),
        runOptionsTest = require('./common.js').runOptionsTest;

    test('before', function(t) {
        runOptionsTest(t, {
            before: 'beforeTest!'
        });
    });
}());
