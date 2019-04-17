var gulp = require('gulp');
var sass = require('gulp-sass');

// Sass support
gulp.task('sass', function () {
  return gulp.src(['./sass/**/*.scss'])
  .pipe(sass().on('error', sass.logError))
  .pipe(gulp.dest('./css'));
});

// For development
gulp.task('sass:watch', function () {
  gulp.watch('./sass/**/*.scss', ['sass']);
});

// Default task
gulp.task('default', ['sass', 'sass:watch']);

// For production
gulp.task('prod', ['sass']);
