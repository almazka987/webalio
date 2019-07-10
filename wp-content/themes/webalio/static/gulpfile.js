let gulp = require('gulp'),
	sass = require('gulp-sass'),
	autoprefixer = require('autoprefixer'),
	plumber = require('gulp-plumber'),
	uglify = require('gulp-uglifyjs'),
	notify = require('gulp-notify'),
    concat = require('gulp-concat'),
	cleanCSS = require('gulp-clean-css'),
	sourcemaps = require('gulp-sourcemaps'),
    postcss = require('gulp-postcss');

let path = {
	src: {
		js: 'src/js/*.js',
		style: 'src/sass/*.scss',
	},
	dist: {
		js: '../js/',
		style: '../css/',
	},
	watch: {
		js: 'src/js/**/*.js',
		style: 'src/sass/**/*.scss',
	}
};

let onError = function errorsNotify(err) {
	notify.onError({
		title:    "Gulp",
		subtitle: "Failure!",
		message:  "Error: <%= error.message %>",
		sound:    "Beep"
	})(err);
	this.emit('end');
};

gulp.task('css', function () {
	return gulp.src(path.src.style)
        .pipe(plumber({errorHandler: onError}))
        .pipe(sourcemaps.init())
        .pipe(sass().on('error', sass.logError))
        .pipe(postcss([ autoprefixer ]))
        .pipe(cleanCSS())
        .pipe(concat('main.min.css'))
        .pipe(sourcemaps.write('.'))
        .pipe(gulp.dest(path.dist.style))
        .pipe(notify({ message: 'css task completed!'}));
});

gulp.task('js', function() {
    return gulp.src(path.src.js)
        .pipe(concat('main.min.js'))
        .pipe(uglify())
        .pipe(gulp.dest(path.dist.js))
        .pipe(notify({ message: 'js task completed!'}));
});

gulp.task('watch', function() {
    gulp.watch(path.watch.style, gulp.parallel('css'));
    gulp.watch(path.watch.js, gulp.parallel('js'));
});

gulp.task('build', gulp.parallel('js', 'css'));

gulp.task('default', gulp.parallel('build'));
