(function() {
    'use strict';

    var test = require('colored-tape'),
        runOptionsTest = require('./common.js').runOptionsTest;

    test('suffix', function(t) {
        runOptionsTest(t, {
            suffix: 'suffixTest!'
        });
    });
}());
