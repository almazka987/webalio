"use strict";

var gulp = require('gulp');
var notify = require('gulp-notify');
var compass = require('gulp-for-compass');

//css
gulp.task('css', function () {
  gulp.src('css/style.css')
    .pipe(gulp.dest('css'))
    .pipe(notify("Done!"))
    .pipe(compass({
	    sassDir: 'sass',
	    cssDir: 'css',
	    force: true
	}));
});

// watch
gulp.task('watch', function() {
	gulp.watch('sass/*.scss', ['css'])
});

// default
gulp.task('default', ['css', 'watch']);