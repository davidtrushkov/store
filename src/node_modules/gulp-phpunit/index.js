/*jshint node:true */
/*global require*/
/*global module*/

'use strict';

var VERSION  = require('./package.json').version;

var map      = require('map-stream');
var	gutil    = require('gulp-util');
var	os       = require('os');
var	chalk    = require('chalk');
var	exec     = require('child_process').exec;
var msg      = require('gulp-messenger');
var _        = require('lodash');
var notifier = require('node-notifier');
var utils    = require('./src/utils.js');

module.exports = function(command, opt) {

	var cmd      = '';
	var launched = false;
	var skip     = false;

	// Assign default options if one is not supplied
	opt = opt || {};

	// merge default options and user supplied options
	var defaultOptions = {

		// plugin specific options (not associated with phpunit options)
		silent:             false,
		debug:              false,
		clear:              false,
		dryRun:             false,
		notify:             true,
		statusLine:         true,

		// code coverage options
		coverageClover:     '',
		coverageCrap4j:     '',
		coverageHtml:       '',
		coveragePhp:        '',
		coverageText:       '',
		coverageXml:        '',

		// logging options
		logJunit:           '',
		logTap:             '',
		logJson:            '',
		testdoxHtml:        '',
		testdoxText:        '',

		// test selection options
		filter:             '',
		testClass:          '',
		testSuite:          '',
		group:              '',
		excludeGroup:       '',
		listGroups:         '',
		testSuffix:         '',

		// test execution options
		reportUselessTests: false,
		strictCoverage:     false,
		disallowTestOutput: false,
		enforceTimeLimit:   false,
		disallowTodoTests:  false,
		strict:             false,

		processIsolation:   false,
		noGlobalsBackup:    false,
		staticBackup:       false,

		colors:             'always',
		stderr:             false,
		stopOnError:        false,
		stopOnFailure:      false,
		stopOnRisky:        false,
		stopOnSkipped:      false,
		stopOnIncomplete:   false,
		verbose:            false,

		loader:             '',
		repeat:             '',
		tap:                false,
		testdox:            false,
		printer:            '',

		// configuration options
		bootstrap:          '',
		configurationFile:  '',
		noConfiguration:    false,
		includePath:        ''

	};
	opt = _.defaults( opt, defaultOptions );

	// If path to phpunit bin not supplied, use default vendor/bin path
	if (!command) {
		command = './vendor/bin/phpunit';

		// Use the backslashes on Windows
		if (os.platform() === 'win32') {
			command = command.replace(/[/]/g, '\\');
		}
	} else if (typeof command !== 'string') {
		throw new gutil.PluginError('gulp-phpunit', 'Command Not Found: PHPUnit');
	}


	return map( function(file, cb) {
		// First file triggers the command, so other files does not matter
		if (launched) {
			return cb(null, file);
		}
		launched = true;

		/* code coverage */
		if(opt.coverageClover)      { cmd += ' --coverage-clover=' + opt.coverageClover; }
		if(opt.coverageCrap4j)      { cmd += ' --coverage-crap4j=' + opt.coverageCrap4j; }
		if(opt.coverageHtml)        { cmd += ' --coverage-html=' + opt.coverageHtml; }
		if(opt.coveragePhp)         { cmd += ' --coverage-php=' + opt.coveragePhp; }
		if(opt.coverageText)        { cmd += ' --coverage-text=' + opt.coverageText; }
		if(opt.coverageXml)         { cmd += ' --coverage-xml=' + opt.coverageXml; }

		/* logging options */
		if(opt.logJunit)            { cmd += ' --log-junit=' + opt.logJunit; }
		if(opt.logTap)              { cmd += ' --log-tap=' + opt.logTap; }
		if(opt.logJson)             { cmd += ' --log-json=' + opt.logJson; }
		if(opt.testdoxHtml)         { cmd += ' --testdox-html=' + opt.testdoxHtml; }
		if(opt.testdoxText)         { cmd += ' --testdox-text=' + opt.testdoxText; }

		/* test selection */
		if(opt.filter)              { cmd += ' --filter=' + opt.filter; }
		if(opt.group)               { cmd += ' --group=' + opt.group; }
		if(opt.excludeGroup)        { cmd += ' --exclude-group=' + opt.excludeGroup; }
		if(opt.listGroups)          { cmd += ' --list-groups=' + opt.listGroups; }
		if(opt.testSuffix)          { cmd += ' --test-suffix=' + opt.testSuffix; }

		/* test execution options */
		if(opt.reportUselessTests)  { cmd += ' --report-useless-tests'; }
		if(opt.strictCoverage)      { cmd += ' --strict-coverage'; }
		if(opt.disallowTestOutput)  { cmd += ' --disallow-test-output'; }
		if(opt.enforceTimeLimit)    { cmd += ' --enforce-time-limit'; }
		if(opt.disallowTodoTests)   { cmd += ' --disallow-todo-tests'; }
		if(opt.strict)              { cmd += ' --strict'; }
		if(opt.processIsolation)    { cmd += ' --process-isolation'; }
		if(opt.noGlobalsBackup)     { cmd += ' --no-globals-backup'; }
		if(opt.staticBackup)        { cmd += ' --static-backup'; }
		if(opt.colors)              { cmd += ' --colors=' + opt.colors; }
		if(opt.stderr)              { cmd += ' --stderr'; }
		if(opt.stopOnError)         { cmd += ' --stop-on-error'; }
		if(opt.stopOnFailure)       { cmd += ' --stop-on-failure'; }
		if(opt.stopOnRisky)         { cmd += ' --stop-on-risky'; }
		if(opt.stopOnSkipped)       { cmd += ' --stop-on-skipped'; }
		if(opt.stopOnIncomplete)    { cmd += ' --stop-on-incomplete'; }
		if(opt.verbose) 				    { cmd += ' --verbose'; }
		if(opt.loader)              { cmd += ' --loader=' + opt.loader; }
		if(opt.repeat)              { cmd += ' --repeat=' + opt.repeat; }
		if(opt.tap)                 { cmd += ' --tap'; }
		if(opt.testdox)             { cmd += ' --testdox'; }
		if(opt.printer)             { cmd += ' --printer=' + opt.printer; }
		if (opt.debug)              { cmd += ' --debug'; }

		/* configuration options */
		if(opt.bootstrap)           { cmd += ' --bootstrap=' + opt.bootstrap; }
		if (opt.includePath)        { cmd += ' --include-path=' + opt.includePath; }

		// after options and switches are added, then add either testClass or testSuite

		// Priority:
		// - config file path from gulp.src()
		// - configuration file
		// - testSuite
		// - testClass

		if ((file.path) && (! skip) && (!opt.noConfiguration)){
			var ext = file.path.substr(file.path.lastIndexOf('.')+1);
			if ( ext === 'xml') {
				cmd += ' -c "' + file.path + '"'; skip = true;
			}
		}

		if ((opt.configurationFile.length > 0) && (! skip) && (! opt.noConfiguration)) {
			cmd += ' -c ' + opt.configurationFile;
		}

		if ((opt.testSuite) && (! skip)) {
			cmd += ' --testsuite ' + opt.testSuite; skip = true;
		}

		if ((opt.testClass) && (! skip)) {
			cmd += ' ' + opt.testClass; skip = true;
		}

		// construct command
		cmd = command + cmd;
		if ( opt.clear ) {
			cmd = 'clear && ' + cmd;
		}

		// append debug code if switch enabled
		if ((opt.debug) || (opt.dryRun)) {
			var vStr = '[Version] ' + VERSION;
			if(opt.dryRun) {
				console.log(chalk.green('\n\n       *** ' + vStr + ' Dry Run Cmd: ' + cmd  + ' ***\n'));
			} else {
				console.log(chalk.yellow('\n\n       *** ' + vStr + ' Debug Cmd: ' + cmd  + ' ***\n'));
			}
		}

		if( ! opt.dryRun ) {

			exec(cmd, function (error, stdout, stderr) {
				if (!opt.silent && stderr) {
					msg.error(stderr);
				}

				if (!opt.silent) {
					// Trim trailing cr-lf
					stdout = stdout.trim();
					if (stdout) {
						console.log(stdout);
					}
				}

				// call user callback if error occurs
				if (error) {
					if ( opt.statusLine ) {
						console.log('\n');
						msg.chalkline.red();
					}
					if (opt.debug) {
						msg.error(error);
						msg.chalkline.yellow();
					}
					cb(error, file);
				} else {
					if ( opt.statusLine ) {
						console.log('\n');
						if ( opt.debug ) {
							msg.chalkline.yellow();
						} else {
							msg.chalkline.green();
						}
					}
					cb(null, file);
				}


				// if notify flag enabled, show notification
				if ( opt.notify ) {
					var options = utils.notifyOptions(error ? 'fail' : 'pass',{taskName: 'PHPUnit'});
					notifier.notify(options);
				}

			}).stdout.on('data', function(data) {
				var str = data.toString();
				cb(null, str);
			});
		}

	});
};

