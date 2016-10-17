'use strict';

// Load modules
var gulp = require('gulp');

// All gulp plugins
var $ = require('gulp-load-plugins')();

gulp.task('stylesheets', function () {
  return gulp
    .src('public/sass/style.scss')
    .pipe($.compass({
      config_file: 'public/config.rb',
      css: 'public/css',
      sass: 'public/sass'
    }))
    .on('error', $.notify.onError())
    .pipe($.notify('Compiled stylesheets.'));
});

gulp.task('watch', function () {
  gulp.watch('public/sass/**/*.scss', ['stylesheets']);
});

gulp.task('default', function () {
  return gulp.start('stylesheets');
});
