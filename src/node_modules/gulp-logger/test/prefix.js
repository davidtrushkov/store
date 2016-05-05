(function() {
    'use strict';

    var test = require('colored-tape'),
        runOptionsTest = require('./common.js').runOptionsTest;

    test('prefix', function(t) {
        runOptionsTest(t, {
            prefix: 'prefixTest!'
        });
    });
}());
