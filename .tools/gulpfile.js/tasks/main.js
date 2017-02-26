var gulp = require('gulp');

// Default task chain: build -> (livereload or browsersync) -> watch
gulp.task('default', ['watch']);

// Build a working copy of the theme
gulp.task('release', ['images', 'scripts', 'styles', 'theme']);

// Compress images
// NOTE: this is a resource-intensive task!
gulp.task('optimize', ['images-optimize']);

// Tests - Lints
gulp.task('tests', ['sass-lint', 'css-lint', 'js-lint', 'php-lint', 'textdomain-lint']);
