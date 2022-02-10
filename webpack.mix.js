const mix = require('laravel-mix');
const glob = require('glob');
const path = require('path');
require('@tinypixelco/laravel-mix-wp-blocks');

const buildPath = (file) => `${path.dirname(path.dirname(file))}/build`

glob.sync('src/blocks/*/assets/index.js').forEach((file) => {
  mix.blocks(file, buildPath(file));
});

glob.sync('src/blocks/*/assets/{index,style}.scss').forEach((file) => {
  mix.sass(file, buildPath(file));
});

glob.sync('src/blocks/*/assets/block.json').forEach((file) => {
  mix.copy(file, buildPath(file));
});
