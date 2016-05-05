/*global require*/
/*global process*/
/* jshint -W030 */
/* jshint -W098 */

'use strict';

var VERSION      = require('./package.json').version;

var chalk        = require('chalk');
var defaults     = require('defaults');
var is           = require('is_js');
var mkdirp       = require('mkdirp');
var moment       = require('moment');
var path         = require("path");
var prettyHrtime = require('pretty-hrtime');
var through      = require('through2');
var winston      = require('winston');
var chalkline    = require('chalkline');
var Purdy        = require('purdy');

var _            = require('lodash');

_.mixin(require('lodash-deep'));

var VALUE_REGEXP = /<%=\s*([^\s]+)\s*%>/g;

// SETUP DEFAULT OPTIONS
// =============================================================================

var defOptions = {
  logToFile:        false,
  logToConsole:     true,
  logPath:          'logs/',
  logFile:          'app.log',
  timestamp:        false,
  rotateLog:        false,
  boldVariables:    true,
  showPipeFile:     true,
  lineLength:       80
};


// SETUP WINSTON
// =============================================================================
// Initialize logger, additional settings will be created in `init` method

var logger = new (winston.Logger)({ level: 'debug'});

function notify(style, before, message, after, data) {

  var text, variable;
  var result = '';
  var tokens;

// 2015.05.28 - added bounds check, exposed when adding *.line() routine
  if( is.undefined(message) ) { message = ''; }

  tokens = (is.not.object(message) ) ? message.split(VALUE_REGEXP) : tokens = message;

  switch (style) {
    case "info":
    case 'log':
      text     = chalk.cyan;
      variable = chalk.cyan.bold;
      break;
    case "success":
      text     = chalk.green;
      variable = chalk.green.bold;
      break;
    case "warning":
      text     = chalk.yellow;
      variable = chalk.yellow.bold;
      break;
    case "error":
      text     = chalk.red;
      variable = chalk.red.bold;
      break;
    case "note":
      text     = chalk.gray;
      variable = chalk.white;
      break;
    case "time":
      text     = chalk.magenta;
      variable = chalk.magenta.bold;
      break;
    case "debug":
      text     = chalk.grey.dim;
      variable = chalk.grey.dim.bold;
      break;
    case "line":
      text     = chalk.green;
      variable = chalk.green.bold;
      break;
    case "header":
      text     = chalk.white.underline;
      variable = chalk.white;
      break;
    default:
      text     = chalk.gray;
      variable = chalk.white;
      break;
  }

// if we don't have bold variables (for merging), set variable to text color
  if( ! defOptions.boldVariables ) {
    variable = text;
    if ( text === chalk.gray ) {
      variable = chalk.white;
    }
  }

  for (var i = 0; i < tokens.length; i++) {
    if (i%2) {
      result += variable(_.deepGet(data, tokens[i]) || '');
    } else {
      result += text(tokens[i] || '');
    }
  }

// if the supplied message is an object, return object (string) as result
  if(! result.length ) {
    result = tokens;
  }

  function setConsole(data) {

    var callData = {};
    if ( is.not.undefined(data) ) {
      callData = data;
    }
    var hCurrentTime = moment().format('HH:mm:ss');

    if (( defOptions.logToConsole ) && ( style !== 'line')){
      if ( defOptions.timestamp || (style === 'time')) {
        if ( style === 'time') {
          console.log('[' + chalk.grey.dim(hCurrentTime) + '] ' + hCurrentTime);
        } else {
          if ( result ) {
            if( Object.keys(arguments[0]).length === 2 ) {
              console.log('[' + chalk.grey.dim(hCurrentTime) + '] ' + result, arguments[0]);
            } else {
              console.log('[' + chalk.grey.dim(hCurrentTime) + '] ' + result);
            }
          }
        }
      } else {

        if ( is.object(callData)) {
          if ( Object.keys(callData).length > 0 ) {
            console.log(result, callData);
          } else {
            console.log(result);
          }
        } else {
          console.log(result, callData)
        }
      }
    }

    // if we are outputting a line, just spit out what we got using `lineLength`
    if ( style === 'line') {
      setLine(result);
    }

  }

  function setLine(line) {

    if (!line) { return; }

    var result = '';
    for (var i = 0; i < defOptions.lineLength; i++) {
      result += line;
    }
    if ( defOptions.logToConsole ) { console.log(text(result)); }
  }

  function logToFile(style, result) {
    switch (style) {
      case 'error':
        (defOptions.logToFile) ? logger.error(result) : '';
        break;
      case 'warning':
        (defOptions.logToFile) ? logger.warn(result) : '';
        break;
      case 'info':
      case 'log':
        (defOptions.logToFile) ? logger.info(result) : '';
        break;
      case 'success':
        (defOptions.logToFile) ? logger.info(result) : '';
        break;
      case 'time':
        (defOptions.logToFile) ? logger.info(result) : '';
        break;
      case 'debug':
        (defOptions.logToFile) ? logger.log('debug', result) : '';
        break;
      case 'line':
        (defOptions.logToFile) ? logger.log('log', result) : '';
        break;
      case "header":
        (defOptions.logToFile) ? logger.log('log', result) : '';
        break;
      case 'default':
        (defOptions.logToFile) ? logger.info(result) : '';
        break;
    }
  }

  setLine(before);
  setConsole(data);
  setLine(after);
  logToFile(style, result);

}

function getArgs(args) {

  var result = {
    before:  args[0],
    message: args[1],
    after:   args[2] || null,
    data:    args[3] || {}
  };

  if(args.length === 1) {
    result.before = '';
    result.message = args[0];
    result.after = '';
  }

  if(args.length === 2) {
    result.before = args[0];
    result.message = args[1];
    result.after = '';
  }

  if( is.not.undefined(args[1]) ) {
    if(is.not.string(args[1])) {
      result.before  = null;
      result.message = args[0];
      result.after   = null;
      result.data    = args[1];
      // result.data    = args;
    } else if (is.not.string(args[2])) {
      result.before  = args[0];
      result.message = args[1];
      result.after   = null;
      result.data    = args[2];
    }
  }
  if( is.undefined(result.data) ) {
    result.data = {};
    result.data.file = '';
  }

  //result.data = _.merge({env: process.env}, result.data);
  return result;
}

function msg(style, useFlush) {
  var totalStart    = process.hrtime();

  return function() {
    var args     = getArgs(arguments);
    var lastFile = {};
    var start    = process.hrtime();

    function transform(file, enc, callback) {
      lastFile = file;

      if (!useFlush) {
        args.data.file          = _.clone(file);
        args.data.file.relative = path.relative(file.base, file.path);
        args.data.file.basename = path.basename(file.path);
        args.data.duration      = prettyHrtime(process.hrtime(start));
        args.data.totalDuration = prettyHrtime(process.hrtime(totalStart));
        notify(style, args.before, args.message, args.after, args.data);
      }
      callback(null, file);
    }

    function flush(callback) {
      if (useFlush) {

        // not sure how this is going to be used as we are clearing .data below
        args.data.file          = _.clone(lastFile);
        args.data.duration      = prettyHrtime(process.hrtime(start));
        args.data.totalDuration = prettyHrtime(process.hrtime(totalStart));

        // gulp pipeline specifc
        defOptions.timestamp = true; // timestamp always true when in pipeline
        args.data = {};              // no data available in gulp pipeline

        // this is only appropriate adjustment to message (to include the filename)
        var msg = args.message;
        if (defOptions.showPipeFile) {
          msg += ' [' + lastFile.relative + '] ';
        }

        notify(style, args.before, msg, args.after, args.data);
      }
      callback();
    }

    return through.obj(transform, flush);
  };
}

function init(options) {

  var added = false;

  return function(options) {

    if(is.not.undefined(options)) {
      defOptions = defaults(options, defOptions);
    }

    if(defOptions.logPath[defOptions.logPath.length] !== '/') {
      defOptions.logPath += '/';
    }

    // create log path if it doesn't already exist
    mkdirp(defOptions.logPath);

    defOptions.logFilename = defOptions.logPath + defOptions.logFile;
    if ( defOptions.rotateLog ) {
      logger.add(winston.transports.DailyRotateFile,{filename: defOptions.logFilename});
    } else {
      if( !added ) {
        added = true;
        logger.add(winston.transports.File,{filename: defOptions.logFilename});
      }
    }
    defOptions.logInitialized = true;
  };
}

function setOptions(options) {

  var added = true;

  return function(options) {

    if(is.not.undefined(options)) {
      defOptions = defaults(options, defOptions);
    }

    if(defOptions.logPath[defOptions.logPath.length] !== '/') {
      defOptions.logPath += '/';
    }

    // create log path if it doesn't already exist
    mkdirp(defOptions.logPath);

    defOptions.logFilename = defOptions.logPath + defOptions.logFile;
    if ( defOptions.rotateLog ) {
      logger.add(winston.transports.DailyRotateFile,{filename: defOptions.logFilename});
    } else {
      if( !added ) {
        added = true;
        logger.add(winston.transports.File,{filename: defOptions.logFilename});
      }
    }
    defOptions.logInitialized = true;
  };
}

function Msg(style) {
  return function() {
    var args = getArgs(arguments);
    notify(style, args.before, args.message, args.after, args.data);
  };

}

module.exports = {
  init:       init(),
  setOptions: setOptions(),
  info:       new Msg('info'),
  log:        new Msg('info'),
  success:    new Msg('success'),
  warning:    new Msg('warning'),
  warn:       new Msg('warning'),
  error:      new Msg('error'),
  note:       new Msg('note'),
  time:       new Msg('time'),
  debug:      new Msg('debug'),
  line:       new Msg('line'),
  header:     new Msg('header'),
  dir:        function() {
    Purdy.apply(Purdy, arguments);
  },
  purdy:      function() {
    Purdy.apply(Purdy, arguments);
  },
  dump:       function() {
    Purdy.apply(Purdy, arguments);
  },
  version:    function() {
    return VERSION;
  },
  chalkline:  chalkline,
  chalk:      chalk,
  flush: {
    info:    msg('info', true),
    log:     msg('info', true),
    success: msg('success', true),
    warning: msg('warning', true),
    warn:    msg('warning', true),
    error:   msg('error', true),
    note:    msg('note', true),
    time:    msg('time', true),
    debug:   msg('debug', true),
    line:    msg('line', true),
    header:  msg('header',true),
    chalkline: chalkline,
    dir: function() {
      Purdy.apply(Purdy, arguments);
    },
    purdy: function() {
      Purdy.apply(Purdy, arguments);
    },
    dump: function(){
      Purdy.apply(Purdy, arguments);
    }
  },
  Info:       new Msg('info'),
  Log:        new Msg('info'),
  Success:    new Msg('success'),
  Warning:    new Msg('warning'),
  Warn:       new Msg('warning'),
  Error:      new Msg('error'),
  Note:       new Msg('note'),
  Time:       new Msg('time'),
  Debug:      new Msg('debug'),
  Line:       new Msg('line'),
  Header:     new Msg('header'),
  Purdy:     function() {
    Purdy.apply(Purdy, arguments);
  },
  Dump:      function() {
    Purdy.apply(Purdy, arguments);
  },
  Version:   function() {
    return VERSION;
  }
};
