# Digital Nature - Utilities Build
This directory contains the source css/js/img files for the plugin.

The build process gathers the input files (specified in `vite.config.js`) and outputs them
to the locations specified in that same config.

This allows us to keep the source files here and the published plugin files inside the
directory that shares the plugin name.


## Install dependencies
```shell
npm i
```

## Development build
```shell
npm run watch
```

## Production Build
```shell
npm run build
```