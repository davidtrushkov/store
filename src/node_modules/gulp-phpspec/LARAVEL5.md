# Laravel5/PHPSpec Getting Started
#### Added gulp-phpspec 0.5.4

### Overview

The following provides simple instructions for getting PHPSpec up and running with Laravel5.

### General Configuration

1. Install PHPSpec
   `$ composer require phpspec/phpspec --dev`

2. Confirm phpspec installation was successful
   `$ phpspec run`
   *At this point, you should see something like*

   ````
   0 specs
   0 examples
   0ms
   ````

3. Create `phpspec.yml`, add the following default settings
   *These settings are based on the default Laravel 5 settings*

  ````
  extensions:
  #    - PhpSpec\Laravel\Extension\LaravelExtension

  laravel_extension:
    testing_environment: 'testing' # testing is default value, just here for some edge case testing

  suites:
    main:
      namespace: App
      psr4_prefix: App
      src_path: app
  ````

4. Create sample spec file we can use for testing plug-in
   `$ phpspec describe App/HelloWorld`

   You will see something similar to

   `Specification for App\Test created in /Users/mikee/Documents/Projects/l5-phpspec/spec/HelloWorld.php.`


5. Run phpspec to execute new test
   `$ phpspec run`

   - The first time you execute phpspec, it will inform you that the supported class does not exist, and give you the option to have class created for you.

6. After test class has been created, you can run phpspec again and all will be green

   `$phpspec run`

   You will see something similar to
   ````
                            100%                          2
   2 specs
   2 examples (2 passed)
   20ms
   ````

### Laravel Elixir Integration

Laravel5 ships with a workflow interface called `Elixir`.  During the installation of Elixir, `gulp-phpspec` will be installed automatically

1. Install Elixir and Dependencies
   `$ npm install`

2. Update `gulpfile.js` adding `phpspec` support

   ````
   elixir(function(mix) {
       mix.phpSpec();
   });
   ````

3. If you wish to extend the `phpspec` call to use any of the `gulp-phpspec` options, you can adjust as

   ````
   elixir(function(mix) {
       mix.phpSpec('', {debug: true});
   });
   ````

4. Finally, to kick off `gulp-phpspec`, you simply execute the gulp command

   `$ gulp`

### PHPSpec-Laravel Extension

If you wish to extend Laravel5/PHPSpec, you may be interested in the `PHPSpec-Laravel Extension`
[Laravel/PHPExtension](https://github.com/BenConstable/phpspec-laravel)

1. Install extension
   `$ composer require benconstable/phpspec-laravel --dev`

2. Add the following to your `phpspec.yml` file (or uncomment if you copy/pasted from above)
   ````
   extensions:
     - PhpSpec\Laravel\Extension\LaravelExtension
   ````
3. For more information on using PHPSpec-Laravel Extension, please refer to instructions included with archive (see above)



### License

Copyright (c) 2016 Mike Erickson
Released under the MIT license

### Credits

gulp-phpspec written by Mike Erickson

E-Mail: [codedungeon@gmail.com](mailto:codedungeon@gmail.com)

Twitter: [@codedungeon](http://twitter.com/codedungeon)

Website: [codedungeon.org](http://codedungeon.org)

***
