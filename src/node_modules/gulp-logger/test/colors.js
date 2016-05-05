(function() {
    'use strict';

    var test = require('colored-tape'),
        runOptionsTest = require('./common.js').runOptionsTest;

    test('colors disabled', function(t) {
        runOptionsTest(t, {
            colors: false
        });
    });
}());
