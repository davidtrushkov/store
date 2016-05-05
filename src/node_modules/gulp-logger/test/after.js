(function() {
    'use strict';

    var test = require('colored-tape'),
        runOptionsTest = require('./common.js').runOptionsTest;

    test('after', function(t) {
        runOptionsTest(t, {
            after: 'afterTest!'
        });
    });
}());
