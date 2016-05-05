/*globals module, require */
(function() {
    'use strict';

    var through = require('through2'),
        utils = require('./lib/utils.js'),
        log = require('gulp-util').log,
        colorTrans = utils.colorTrans,
        processFilePath = require('./lib/process-file-path.js'),
        processFunction = require('./lib/process-function.js'),

        GulpLogger;

    GulpLogger = function(fnOpts, opts) {
        var options = typeof fnOpts === 'object' ? fnOpts : opts,
            beforeComplete = false,
            afterComplete = false;

        if (options) {
            utils.colorsEnabled = typeof options.colors !== 'undefined' ? options.colors : true;
        }

        function loggerEndHandler(flushCallback) {
            if (options && options.after && !afterComplete) {
                log(colorTrans(options.after, 'cyan'));
                afterComplete = true;
            }

            flushCallback();
        }

        return through.obj(function(file, ext, streamCallback) {
            var filePath = file.path;

            if (options && options.before && !beforeComplete) {
                log(colorTrans(options.before, 'cyan'));
                beforeComplete = true;
            }

            if (typeof fnOpts === 'function') {
                processFunction(filePath, fnOpts, opts);
            } else if (typeof fnOpts === 'object') {
                processFilePath(filePath, fnOpts);
            } else {
                log(utils.getRelativePath(filePath));
            }

            streamCallback(null, file);
        }, loggerEndHandler);
    };

    module.exports = GulpLogger;

}());
