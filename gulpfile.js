// Prerequisites

var gulp = require('gulp'),
    autoprefixer = require('gulp-autoprefixer'),
    cleanCss = require('gulp-clean-css'),
    concat = require('gulp-concat'),
    notify = require('gulp-notify'),
    plumber = require('gulp-plumber'),
    sass = require('gulp-sass'),
    sourcemaps = require('gulp-sourcemaps'),
    uglify = require('gulp-uglify'),
    pump = require('pump'),
    dirSync = require('gulp-file-sync');

var config = require('./gulpconfig.json');

var onError = function (err) {
  notify.onError({
    title: 'Gulp',
    subtitle: 'Failure!',
    message: 'Error: <%= error.message %>',
    sound: 'Beep'
  })(err);

  this.emit('end');
}

// Build methods

function buildStyles(finished) {
  pump([
    gulp.src(config.source.vendor.styles.concat(config.source.styles)),
    plumber({
      errorHandler: onError
    }),
    sourcemaps.init(),
    concat('main.min.css'),
    sass(),
    cleanCss(),
    autoprefixer({
      browsers: ['last 3 versions']
    }),
    sourcemaps.write('.'),
    gulp.dest(config.dest.styles),
    notify({
      'title': 'Gulp',
      'message': 'Stylesheets were generated',
      onLast: true
    })
  ], finished);
}

function buildScripts(finished) {
  pump([
    gulp.src(config.source.vendor.scripts.concat(config.source.scripts)),
    plumber({
      errorHandler: onError
    }),
    sourcemaps.init(),
    concat('main.min.js'),
    uglify(),
    sourcemaps.write('.'),
    gulp.dest(config.dest.scripts),
    notify({
      'title': 'Gulp',
      'message': 'Script files were generated',
      onLast: true
    })
  ], finished);
}

function watchForChanges() {
  gulp.watch(config.source.styles, buildStyles);
  gulp.watch(config.source.scripts, buildScripts);
}

// Tasks

exports.build = gulp.parallel(buildScripts, buildStyles);
exports.watch = gulp.series(exports.build, watchForChanges);
exports.default = exports.watch;
