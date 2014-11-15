var gulp = require('gulp');
var sass = require('gulp-ruby-sass');
var del = require('del');

gulp.task('clean', function(cb) {
  del([
    'build/dev/css',
    'build/dev/js',
    'build/prod/css',
    'build/prod/js'
  ], cb);
});

gulp.task('sass', function() {
  gulp.src('front/stylesheets/**/*.scss')
    .pipe(sass())
    .pipe(gulp.dest('build/dev/css/style.css'))
    .pipe(gulp.dest('build/prod/css/style.min.css'));
});

gulp.task('default', ['sass']);
