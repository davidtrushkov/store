## Changelog
  
- 0.11.1 Updated module dependencies
- 0.11.0 Bug Fixes and Code Refactoring
    - Fixed all know issues related to using configuration files
      - If `.xml` file supplied as task source, it will be used as configuration file
      - If `configurationFile` property supplied in options, it will be used as configuration file
      - If you enable `noConfigurationFile` property, no configuration file will be used
    - Refactored internal options object
    - Fixed issue when using configuration files ( -c option )
    - Removed a spurious console.log statement
    - Modified `colors` option to match new color options in PHPUnit. You now supply one of three values
      Use colors in output ("never", "auto" or "always")
    - Fixed issue where output colors were not displayed, regardless of '--colors' attribute
    - Added new property `statusLine` which will display one of three status lines
      - green for passing tests
      - red for failing tests
      - yellow for tests which have `debug` property enabled (will also display red, green status)
    - Notifications are on by default (if gulp-notify installed)
      - You can disable notifications using the `notify` property ( default: true )
      
- 0.10.0 Fixed Issues
    - Added new property `notify` which will conditionally display notifications (both in buffer and growl where available)
      - This property is `false` by default as to not affect existing installations.
      - You can enable by adding in `options` parameter (options.notify = true)
      
    - Fixed issues when supplying `testsuite` 
    
    - Closed Issues
      [30] (https://github.com/mikeerickson/gulp-phpunit/issues/30) https://github.com/mikeerickson/gulp-phpunit/issues/30
      [27] (https://github.com/mikeerickson/gulp-phpunit/issues/27) https://github.com/mikeerickson/gulp-phpunit/issues/27
      [17] (https://github.com/mikeerickson/gulp-phpunit/issues/27) https://github.com/mikeerickson/gulp-phpunit/issues/17
      
- 0.9.0 Fixed Issues
    - Fixed issue when supplying a configuration file (either through configuration option or file parameter)
    - Added bounds check to assure file supplied as `src` parameter is an actual configuration file
      - I am only checking to assure it is an .xml file, not a VALID xml file
    - Tested against Elixir 3.0 for combatability
    
    - Closed Issues:
      [23] (https://github.com/mikeerickson/gulp-phpunit/issues/22) https://github.com/mikeerickson/gulp-phpunit/issues/22
      [23] (https://github.com/mikeerickson/gulp-phpunit/issues/23) https://github.com/mikeerickson/gulp-phpunit/issues/23
      [24] (https://github.com/mikeerickson/gulp-phpunit/issues/24) https://github.com/mikeerickson/gulp-phpunit/issues/24
      [25] (https://github.com/mikeerickson/gulp-phpunit/issues/25) https://github.com/mikeerickson/gulp-phpunit/issues/25

- 0.8.0 Bug Fixes and New Features

    - Fixed issue with gulp.src not correctly using supplied phpunit.xml file
    - Added stdout datastream for live logging of phpunit's progress.
    - Updated internal gulp dependencies (getting ready for gulp 4 support)
    
- 0.7.0 Added Plugin Resources
    - Added new icons for pass and fail which can be used by notify plugin (see example below for usage)
      /assets/test-pass.png
      /assets/test-fail.png
    - Added missing 'verbose' flag to PHPUnit command call (option existed but wasn't used).
   
- 0.6.3 Updated general options
    - Changed dry run output text color

- 0.6.2 Updated general options
    - Added dryRun option (echo constructed PHPUnit command) sets opt.debug true

- 0.6.1 Updated README to include all udpated options

- 0.6.0 Updated to support PHPUnit 4.x and new options

    - Added Code Coverage Options
      - coverageClover
      - coverageCrap4j
      - coverageHtml
      - coveragePHP
      - coverageText
      - coverageXML
      
    - Added Logging Options
      - logJunit
      - logTap
      - logJson
      - testdoxHtml 
      - testdoxText
      
    - Added Test Selection Options
      - filter
      - testsuite
      - group 
      - excludeGroup 
      - testSuffix 
      
    - Added Test Execution Options
      - reportUseless
      - strictCoverage
      - disallowTestOutput
      - enforceTimeLimit
      - strict
      - isolation 
      - noGlobals 
      - staticBackup 
      - stopOnError 
      - stopOnFailure 
      - stopOnRisky 
      - stopOnSkipped 
      - displayDebug 
      - testdox
      - tap
      
    - Added Configuration Options
      - includePath
      - noColor
      - noConfig

- 0.5.3 Updated dev dependencies to use latest builds

- 0.5.2: Small adjustments and Configuration File Support (thanks @wayneashleyberry)
   - Added Configuration File Support
   - Removed Node 0.9 from Travis support
   
- 0.5.1: Added CI Support
    - Added .travis support
    - Added .circle support

- 0.5.0: Complete refactoring and cleanup (thanks @taai)
    - Simplified code and callback handling
    - Addressed additional issues related to dependecies

- 0.4.2: Added additional tests

- 0.4.1: Code Cleanup
    - Removed calls to console.log -> gutil.log (playing nice in the playground)
    - Fixed issue with calling as dependency task (thanks @taai)

- 0.4.0: Added check for invalid PHPUnit binary path as first parameter
    - Safeguard to assure options is not passed as first parameter

- 0.3.0: Refactoring
    - Refactored color console message to use gulp-util instance instead of color plugi

- 0.2.1: Update Default Command - Windows Fix
    - Fixed default command when using windows (thx @imissions)

- 0.1.0:
    - Enhanced debug output (supporting color)

- 0.0.4:
    - Updated version number, error publishing full archive to npm in 0.0.3 update

- 0.0.3:
    - Added support return calling user supplied callback to handle notification

- 0.0.2:
    - Fixed issue which caused tests to be run multiple times
    - Added 'clear' flag to clear console before running tests
    - Added 'testClass' option to define a specific class to test
    - Added './vendor/bin/phpunit' as default bin if no path supplied

- 0.0.1: Initial Release
