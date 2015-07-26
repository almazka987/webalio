"use strict";

var gulp = require('gulp');
var compass = require('gulp-compass');


// compass
gulp.task('compass', function() {
  gulp.src('sass/*.scss')
    .pipe(compass({
      config_file: 'config.rb',
      css: '',
      sass: 'sass'
    }))
    .pipe(gulp.dest(''));
});

// watch
gulp.task('watch', function() {
	gulp.watch('sass/*.scss', ['compass'])
});

// default
gulp.task('default', ['compass', 'watch']);