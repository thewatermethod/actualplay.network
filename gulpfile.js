/*
	Open command prompt as administrator

	cd YOUR-THEME-DIRECTORY
	npm install gulp gulp-concat gulp-uglify gulp-sourcemaps gulp-less gulp-clean gulp-clean-css run-sequence  --save-dev 
	gulp

*/

//these are all the modules that you installed above
var gulp = require("gulp"),
  clean = require("gulp-clean"),
  concat = require("gulp-concat"),
  uglify = require("gulp-uglify"),
  sourcemaps = require("gulp-sourcemaps"),
  less = require("gulp-less"),
  cleanCSS = require("gulp-clean-css"),
  runSequence = require("run-sequence");

//this task builds the less files into minified css
gulp.task("build-less", function() {
  return gulp
    .src(["less/normalize.less,", "less/vars.less", "less/*.less"])
    .pipe(concat("style.less"))
    .pipe(less())
    .pipe(cleanCSS())
    .pipe(gulp.dest("min"));
});

gulp.task("gather-assets", function() {
  return gulp
    .src(["node_modules/vue/dist/vue.min.js"])
    .pipe(gulp.dest("admin"));
});

gulp.task("compile", function() {
  runSequence("build-less");
});

gulp.task("default", function() {
  runSequence("compile");
});
