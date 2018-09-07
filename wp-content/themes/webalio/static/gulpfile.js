var gulp = require('gulp');
var sass = require('gulp-sass');
var autoprefixer = require('gulp-autoprefixer');
var plumber = require('gulp-plumber');
var uglify = require('gulp-uglifyjs');
var notify = require('gulp-notify');
var gcmq = require('gulp-group-css-media-queries');
var minify = require('gulp-minify');
var concat = require('gulp-concat');
var cleanCSS = require('gulp-clean-css');
var watch = require('gulp-watch');
var sourcemaps = require('gulp-sourcemaps');
var path = {
	src: {
		js: 'src/js/main.js',
		style: 'src/sass/**/*.scss',
        fonts: 'src/fonts/**/*.*',
	},
	dist: {
		js: '../js/',
		style: '../css/',
        fonts: '../fonts/'
	},
	watch: {
		js: 'src/js/**/*.js',
		style: 'src/sass/**/*.scss',
        fonts: 'src/fonts/**/*.*'
	}
};
var onError = function errorsNotify(err) {
	notify.onError({
		title:    "Gulp",
		subtitle: "Failure!",
		message:  "Error: <%= error.message %>",
		sound:    "Beep"
	})(err);
	this.emit('end');
}

gulp.task('css', function () {
	return gulp.src(path.src.style)
	.pipe(plumber({errorHandler: onError}))
    .pipe(sourcemaps.init())
	.pipe(sass({outputStyle: 'compressed'}).on('error', sass.logError))
    .pipe(sourcemaps.write({includeContent: false}))
    .pipe(sourcemaps.init({loadMaps: true}))
	.pipe(gcmq())
	.pipe(autoprefixer({
		browsers: ['last 3 versions'],
		cascade: false
	}))
    .pipe(cleanCSS())
    .pipe(concat('main.min.css'))
    .pipe(sourcemaps.write('.'))
	.pipe(gulp.dest(path.dist.style))
	.pipe(notify({ message: 'css task completed!'}));
});

gulp.task('fonts', function() {
    gulp.src(path.src.fonts)
        .pipe(gulp.dest(path.dist.fonts))
});


gulp.task('js', function() {
	gulp.src(path.src.js)
	.pipe(concat('main.min.js'))
	.pipe(uglify())
	.pipe(gulp.dest(path.dist.js))
	.pipe(notify({ message: 'js task completed!'}));
});

gulp.task('watch', function() {
	watch([path.watch.style], function(event, cb) {
		gulp.start('css');
	});
	watch([path.watch.js], function(event, cb) {
		gulp.start('js');
	});
    watch([path.watch.fonts], function(event, cb) {
        gulp.start('fonts');
    });
});

gulp.task('build', [
	'js',
	'css',
    'fonts'
]);

gulp.task('default', ['build']);
gulp.task('dev', ['build', 'watch']);
gulp.task('watcher', ['css', 'js', 'watch']);