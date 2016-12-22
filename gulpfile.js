/*
	Open command prompt as administrator

	cd YOUR-THEME-DIRECTORY
	npm install gulp gulp-concat gulp-uglify gulp-sourcemaps gulp-less gulp-clean-css run-sequence gulp-watch browser-sync --save-dev 
	gulp

*/

//these are all the modules that you installed above
var gulp = require('gulp'),
	clean = require('gulp-clean'),
	concat = require('gulp-concat'),
	uglify = require('gulp-uglify'),
	sourcemaps = require('gulp-sourcemaps'),
	less = require('gulp-less'),
	cleanCSS = require('gulp-clean-css'),
	runSequence = require('run-sequence'),
	watch = require('gulp-watch'),
	browserSync = require('browser-sync').create();

//this task builds the less files into minified css
gulp.task('build-less', function(){
	return gulp.src(['!less/fa/*.less','less/*.less'])
		.pipe( sourcemaps.init() )
		.pipe( concat('style.less') )
		.pipe( less() )
		.pipe( cleanCSS() )
		.pipe( sourcemaps.write('maps') )
		.pipe( gulp.dest('min') )
		.pipe( browserSync.stream() );
});


gulp.task('watch', function() {
	gulp.watch('less/*.less', ['compile']);
	gulp.watch('*.php').on('change', browserSync.reload);
	gulp.watch('inc/*.php').on('change', browserSync.reload);
	gulp.watch('template-parts/*.php').on('change', browserSync.reload);
	gulp.watch(['js/*.js', '*.js']).on('change', browserSync.reload);
});


gulp.task('compile', function(){
	runSequence(
		'build-less'
	);
});

gulp.task('serve', function(){
	// browserSync.init({
	// 	//change name of proxy to local dev URL
	// 	proxy: 'localhost/actualplay.network',
	// 	port: '81'
	// });
});


gulp.task( 'default', function(){
	runSequence(
		//'watch',
		'compile'
		//'serve'
	);

});