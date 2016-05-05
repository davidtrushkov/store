(function() {
    'use strict';

    var test = require('colored-tape'),
        runOptionsTest = require('./common.js').runOptionsTest;

    test('showChange', function(t) {
        runOptionsTest(t, {
            showChange: true
        });
    });
}());
