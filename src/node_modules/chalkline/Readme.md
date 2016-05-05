
[![MIT License][license-image]][license-url]
[![Unicorn Approved][unicorn-approved]][unicorn-url]

> Draw a big chalkline in your terminal!

<h1 align="center">
  <img width="500" src="https://cdn.rawgit.com/niftylettuce/chalkline/master/media/logo.svg" />
  <img alt="chalkline screenshot" src="https://cdn.rawgit.com/niftylettuce/chalkline/master/media/screenshot.png" />
</h1>

<h4 align="center">
  <p>Sponsored by <a href="http://www.clevertech.biz/?ref=chalkline">Clevertech</a></p>
  <a href="http://www.clevertech.biz/?ref=chalkline"><img width="300" src="https://s3.amazonaws.com/filenode/logo-black.png" /></a>
</h4>

## Install

```bash
npm install --save chalkline
```


## Usage

Chalkline extends the [chalk][chalk] package, so you can log any color line to the console.

```js
var cl = require('chalkline');

cl.green();
cl.blue.bgMagenta();
cl.white();
cl.bgYellow.red();
```


## Colors and Background colors

Please see [chalk's colors][chalks-colors] for a list of supported colors and background colors for your chalklines.


## License

[MIT][license-url]


[chalk]: https://github.com/chalk/chalk
[chalks-colors]: https://github.com/chalk/chalk#colors
[license-image]: http://img.shields.io/badge/license-MIT-blue.svg?style=flat
[license-url]: LICENSE
[unicorn-approved]: http://img.shields.io/badge/unicorn-approved-ff69b4.svg
[unicorn-url]: https://www.youtube.com/watch?v=9auOCbH5Ns4
