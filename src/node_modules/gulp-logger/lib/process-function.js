(function() {
    'use strict';

    var utils = require('./utils.js'),
        path = require('path'),
        getDisplayPath = utils.getDisplayPath;

    module.exports = function(filePath, fn, opts) {
        opts = opts || {};

        var display = opts.display || 'rel',
            newPath = getDisplayPath(filePath, display) + path.basename(filePath);

        fn(newPath);
    };
}());
