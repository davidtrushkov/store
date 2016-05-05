(function() {
    'use strict';

    var test = require('colored-tape'),
        runOptionsTest = require('./common.js').runOptionsTest;

    test('basename', function(t) {
        runOptionsTest(t, {
            basename: 'basenameTest!'
        });
    });
}());
